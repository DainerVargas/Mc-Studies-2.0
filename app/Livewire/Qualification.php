<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Group;
use App\Models\Qualification as ModelsQualification;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Qualification extends Component
{
  public $teacherId;
  public $isAdmin;
  public $groups;
  public $selectedGroup = null;
  public $selectedYear;
  public $selectedSemester = null;
  public $selectedResult = '';
  public $exists = false;

  public $students = [];
  public $listening = [];
  public $writing = [];
  public $reading = [];
  public $speaking = [];
  public $actividades_asignados = [];
  public $actividades_entregados = [];
  public $worksheet_asignados = [];
  public $worksheet_entregados = [];
  public $observaciones = [];

  protected $rules = [
    'listening.*' => 'required|numeric|min:0|max:100',
    'writing.*' => 'required|numeric|min:0|max:100',
    'reading.*' => 'required|numeric|min:0|max:100',
    'speaking.*' => 'required|numeric|min:0|max:100',
    'actividades_asignados.*' => 'required|integer|min:0',
    'actividades_entregados.*' => 'required|integer|min:0',
    'worksheet_asignados.*' => 'required|integer|min:0',
    'worksheet_entregados.*' => 'required|integer|min:0',
    'observaciones.*' => 'nullable|string',
  ];

  protected $validationAttributes = [
    'listening.*' => 'listening',
    'writing.*' => 'writing',
    'reading.*' => 'reading',
    'speaking.*' => 'speaking',
    'actividades_asignados.*' => 'actividades asignadas',
    'actividades_entregados.*' => 'actividades entregadas',
    'worksheet_asignados.*' => 'worksheets asignados',
    'worksheet_entregados.*' => 'worksheets entregados',
  ];

  public Teacher $teacher;

  public function mount($teacher)
  {
    $this->teacher = $teacher;
    $this->teacherId = $teacher->id;
    $this->isAdmin = Auth::user()->rol_id == 1; // Gerente/Admin
    $this->selectedYear = date('Y');
    $this->groups = Group::where('teacher_id', $this->teacherId)->get();
  }

  public function updated($property)
  {
    if (in_array($property, ['selectedGroup', 'selectedYear', 'selectedSemester', 'selectedResult'])) {
      $this->loadData();
    }
  }

  public function loadData()
  {
    $this->resetGrades();

    if (!$this->selectedGroup) {
      $this->students = [];
      return;
    }

    $this->students = Apprentice::where('group_id', $this->selectedGroup)->get();

    // 1. Inicializar llaves para todos los estudiantes actuales
    foreach ($this->students as $student) {
      $sid = (string)$student->id;
      $this->listening[$sid] = '';
      $this->writing[$sid] = '';
      $this->reading[$sid] = '';
      $this->speaking[$sid] = '';
      $this->actividades_asignados[$sid] = '';
      $this->actividades_entregados[$sid] = '';
      $this->worksheet_asignados[$sid] = '';
      $this->worksheet_entregados[$sid] = '';
      $this->observaciones[$sid] = '';
    }

    $this->exists = false;

    // 2. Cargar datos si los filtros principales están completos
    if ($this->selectedYear && $this->selectedSemester && $this->selectedResult) {
      if ($this->selectedResult !== 'final') {
        foreach ($this->students as $student) {
          $sid = (string)$student->id;
          $calificacion = ModelsQualification::where('apprentice_id', $student->id)
            ->where('group_id', $this->selectedGroup)
            ->where('year', (string)$this->selectedYear)
            ->where('semestre', $this->selectedSemester)
            ->where('resultado', $this->selectedResult)
            ->first();

          if ($calificacion) {
            $this->exists = true;
            $this->listening[$sid] = (string)($calificacion->listening ?? '');
            $this->writing[$sid] = (string)($calificacion->writing ?? '');
            $this->reading[$sid] = (string)($calificacion->reading ?? '');
            $this->speaking[$sid] = (string)($calificacion->speaking ?? '');
            $this->actividades_asignados[$sid] = (string)($calificacion->actividades_asignados ?? '');
            $this->actividades_entregados[$sid] = (string)($calificacion->actividades_entregados ?? '');
            $this->worksheet_asignados[$sid] = (string)($calificacion->worksheet_asignados ?? '');
            $this->worksheet_entregados[$sid] = (string)($calificacion->worksheet_entregados ?? '');
            $this->observaciones[$sid] = $calificacion->observacion ?? '';
          }
        }
      } else {
        // Lógica de "Resultado Final" (Promedio de resultados 1, 2 y 3)
        foreach ($this->students as $student) {
          $sid = (string)$student->id;
          $historico = ModelsQualification::where('apprentice_id', $student->id)
            ->where('group_id', $this->selectedGroup)
            ->where('year', (string)$this->selectedYear)
            ->where('semestre', $this->selectedSemester)
            ->whereIn('resultado', ['1', '2', '3'])
            ->get();

          if ($historico->count() > 0) {
            $this->listening[$sid] = (string)round($historico->avg('listening'), 2);
            $this->writing[$sid] = (string)round($historico->avg('writing'), 2);
            $this->reading[$sid] = (string)round($historico->avg('reading'), 2);
            $this->speaking[$sid] = (string)round($historico->avg('speaking'), 2);
            $this->actividades_asignados[$sid] = (string)round($historico->avg('actividades_asignados'));
            $this->actividades_entregados[$sid] = (string)round($historico->avg('actividades_entregados'));
            $this->worksheet_asignados[$sid] = (string)round($historico->avg('worksheet_asignados'));
            $this->worksheet_entregados[$sid] = (string)round($historico->avg('worksheet_entregados'));
          }
        }
      }
    }
  }

  private function resetGrades()
  {
    $this->listening = [];
    $this->writing = [];
    $this->reading = [];
    $this->speaking = [];
    $this->actividades_asignados = [];
    $this->actividades_entregados = [];
    $this->worksheet_asignados = [];
    $this->worksheet_entregados = [];
    $this->observaciones = [];
  }

  public function guardarNotas()
  {

    if (!$this->selectedGroup || !$this->selectedSemester || !$this->selectedResult) {
      session()->flash('error', 'Debes seleccionar el año, semestre, grupo y resultado antes de guardar.');
      return;
    }

    // Bloqueo para Resultado Final (que es calculado)
    if ($this->selectedResult === 'final') {
      session()->flash('error', 'El resultado final es calculado automáticamente y no se puede guardar manualmente.');
      return;
    }

    // Regla de negocio: Solo admin edita lo guardado
    if (!$this->isAdmin) {
      foreach ($this->students as $student) {
        $yaExiste = ModelsQualification::where('apprentice_id', $student->id)
          ->where('group_id', $this->selectedGroup)
          ->where('year', (string)$this->selectedYear)
          ->where('semestre', $this->selectedSemester)
          ->where('resultado', $this->selectedResult)
          ->exists();

        if ($yaExiste) {
          session()->flash('error', 'Solo el administrador puede editar calificaciones ya registradas.');
          return;
        }
      }
    }

    try {
      $this->validate();
    } catch (\Illuminate\Validation\ValidationException $e) {
      session()->flash('error', 'Corrige los errores antes de guardar.');
      throw $e;
    }

    foreach ($this->students as $student) {
      $id = $student->id;

      ModelsQualification::updateOrCreate(
        [
          'apprentice_id' => $id,
          'group_id' => $this->selectedGroup,
          'year' => (string)$this->selectedYear,
          'semestre' => $this->selectedSemester,
          'resultado' => $this->selectedResult,
        ],
        [
          'teacher_id' => $this->teacherId,
          'listening' => $this->listening[$id] ?? null,
          'writing' => $this->writing[$id] ?? null,
          'reading' => $this->reading[$id] ?? null,
          'speaking' => $this->speaking[$id] ?? null,
          'actividades_asignados' => $this->actividades_asignados[$id] ?? null,
          'actividades_entregados' => $this->actividades_entregados[$id] ?? null,
          'worksheet_asignados' => $this->worksheet_asignados[$id] ?? null,
          'worksheet_entregados' => $this->worksheet_entregados[$id] ?? null,
          'observacion' => $this->observaciones[$id] ?? null,
        ]
      );
    }

    session()->flash('message', 'Todas las calificaciones se guardaron correctamente.');
    $this->loadData();
  }

  public function download($studentId)
  {
    if ($this->selectedGroup && $this->selectedSemester && $this->selectedResult) {

      $query = ModelsQualification::where('teacher_id', $this->teacherId)
        ->where('group_id', $this->selectedGroup)
        ->where('apprentice_id', $studentId)
        ->where('year', (string)$this->selectedYear);

      if ($this->selectedResult === 'final') {
        $qualifications = (clone $query)->whereIn('resultado', ['1', '2', '3'])->get();
      } else {
        $qualifications = (clone $query)->where('resultado', $this->selectedResult)->get();
      }

      if ($qualifications->isEmpty()) {
        session()->flash('error', 'No hay calificaciones registradas para descargar el informe.');
        return;
      }

      $resultMap = [
        '1' => 'Primer',
        '2' => 'Segundo',
        '3' => 'Tercer',
        'final' => 'Final'
      ];

      session()->put('qualifications', $qualifications);
      session()->put('number', $resultMap[$this->selectedResult] ?? '');

      return redirect()->route('qualificationDownload');
    } else {
      session()->flash('error', 'Seleccione todos los filtros para descargar el informe.');
    }
  }

  public function descargarGrupo()
  {
    if (!$this->selectedGroup || !$this->selectedSemester || !$this->selectedResult) {
      session()->flash('error', 'Seleccione Año, Semestre, Grupo y Resultado para descargar el informe grupal.');
      return;
    }

    $group = Group::with('type', 'teacher')->find($this->selectedGroup);

    // Obtenemos las calificaciones según el tipo de resultado
    if ($this->selectedResult === 'final') {
      // Caso Final: Promediamos resultados 1, 2 y 3 para todo el grupo
      $records = ModelsQualification::with('apprentice')
        ->where('group_id', $this->selectedGroup)
        ->where('year', (string)$this->selectedYear)
        ->where('semestre', $this->selectedSemester)
        ->whereIn('resultado', ['1', '2', '3'])
        ->get();

      if ($records->isEmpty()) {
        session()->flash('error', 'No hay registros (1, 2 o 3) para calcular el promedio final del grupo.');
        return;
      }

      // Agrupamos por aprendiz para crear objetos virtuales promediados
      $qualifications = $records->groupBy('apprentice_id')->map(function ($groupRecords) {
        $first = $groupRecords->first();
        // Creamos un objeto similar al modelo para que la vista no falle
        $virtual = new ModelsQualification();
        $virtual->setRelation('apprentice', $first->apprentice);
        $virtual->listening = $groupRecords->avg('listening');
        $virtual->writing = $groupRecords->avg('writing');
        $virtual->reading = $groupRecords->avg('reading');
        $virtual->speaking = $groupRecords->avg('speaking');
        $virtual->actividades_asignados = $groupRecords->avg('actividades_asignados');
        $virtual->actividades_entregados = $groupRecords->avg('actividades_entregados');
        $virtual->worksheet_asignados = $groupRecords->avg('worksheet_asignados');
        $virtual->worksheet_entregados = $groupRecords->avg('worksheet_entregados');
        return $virtual;
      })->values();

      session()->put('selectedResultName', 'Promedio Final Academico');
    } else {
      // Caso Individual (1, 2 o 3)
      $qualifications = ModelsQualification::with('apprentice')
        ->where('group_id', $this->selectedGroup)
        ->where('year', (string)$this->selectedYear)
        ->where('semestre', $this->selectedSemester)
        ->where('resultado', $this->selectedResult)
        ->get();

      session()->put('selectedResultName', 'Resultado ' . $this->selectedResult);
    }

    if ($qualifications->isEmpty()) {
      session()->flash('error', 'No hay calificaciones registradas para este grupo con los filtros seleccionados.');
      return;
    }

    // Datos para el reporte
    session()->put('qualifications', $qualifications);
    session()->put('groupName', $group->name);
    session()->put('nameTeacher', ($group->teacher->name ?? '') . ' ' . ($group->teacher->apellido ?? ''));
    session()->put('typeGroup', $group->type->name ?? 'N/A');
    session()->put('selectedSemester', $this->selectedSemester);
    session()->put('selectedResult', $this->selectedResult);
    session()->put('selectedYear', $this->selectedYear);

    return redirect()->route('groupCalification');
  }

  public function render()
  {
    return view('livewire.qualification');
  }
}
