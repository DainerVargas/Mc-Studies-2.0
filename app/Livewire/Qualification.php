<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Group;
use App\Models\Qualification as ModelsQualification;
use App\Models\Teacher;
use App\Models\AssignedActivity;
use App\Models\AcademicActivity;
use Carbon\Carbon;
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
    $this->isAdmin = in_array(Auth::user()->rol_id, [1, 2, 3]);
    $this->selectedYear = date('Y');

    if ($this->isAdmin) {
      $this->groups = Group::all();
    } else {
      $this->groups = Group::where('teacher_id', $this->teacherId)
        ->orWhereHas('tutors', function ($q) {
          $q->where('teacher_id', $this->teacherId);
        })
        ->get();
    }
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
      $year = (int)$this->selectedYear;
      $semester = (int)$this->selectedSemester;
      $result = (int)$this->selectedResult;
      $keywords = ['worksheet', 'pelicula', 'movie', 'serie', 'series'];
      $groupId = $this->selectedGroup;

      if ($this->selectedResult !== 'final') {
        // Definir rango de fechas según semestre y resultado
        if ($semester == 1) {
          if ($result == 1) {
            $startDate = Carbon::createFromDate($year, 2, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, 3, 31)->endOfDay();
          } elseif ($result == 2) {
            $startDate = Carbon::createFromDate($year, 4, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, 4, 30)->endOfDay();
          } elseif ($result == 3) {
            $startDate = Carbon::createFromDate($year, 5, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, 5, 31)->endOfDay();
          }
        } else {
          if ($result == 1) {
            $startDate = Carbon::createFromDate($year, 8, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, 9, 30)->endOfDay();
          } elseif ($result == 2) {
            $startDate = Carbon::createFromDate($year, 10, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, 10, 31)->endOfDay();
          } elseif ($result == 3) {
            $startDate = Carbon::createFromDate($year, 11, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, 11, 30)->endOfDay();
          }
        }

        // --- ASIGNADOS (Cálculo único para el grupo en este periodo) ---
        $autoActividadesAsig = AssignedActivity::whereHas('groups', function ($g) use ($groupId) {
          $g->where('groups.id', $groupId);
        })->whereBetween('assigned_activities.created_at', [$startDate, $endDate])
          ->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) { $q->where('titulo', 'not like', "%{$word}%"); }
          })->count();

        foreach ($this->students as $student) {
          $sid = (string)$student->id;

          // --- ENTREGADOS (Cálculo individual por estudiante en este periodo) ---
          $autoActividadesEnt = AcademicActivity::where('apprentice_id', $student->id)
            ->whereBetween('fecha', [$startDate, $endDate])
            ->where(function ($q) use ($keywords) {
              foreach ($keywords as $word) { $q->where('titulo', 'not like', "%{$word}%"); }
            })->count();

          $this->actividades_asignados[$sid] = (string)$autoActividadesAsig;
          $this->actividades_entregados[$sid] = (string)$autoActividadesEnt;

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
            $this->worksheet_asignados[$sid] = (string)($calificacion->worksheet_asignados ?? '');
            $this->worksheet_entregados[$sid] = (string)($calificacion->worksheet_entregados ?? '');
            $this->observaciones[$sid] = $calificacion->observacion ?? '';
          }
        }
      } else {
        // --- RESULTADO FINAL (Consolidado Semestral) ---
        if ($semester == 1) {
          $startDate = Carbon::createFromDate($year, 2, 1)->startOfDay();
          $endDate = Carbon::createFromDate($year, 5, 31)->endOfDay();
        } else {
          $startDate = Carbon::createFromDate($year, 8, 1)->startOfDay();
          $endDate = Carbon::createFromDate($year, 11, 30)->endOfDay();
        }

        $autoActividadesAsigFinal = AssignedActivity::whereHas('groups', function ($g) use ($groupId) {
          $g->where('groups.id', $groupId);
        })->whereBetween('assigned_activities.created_at', [$startDate, $endDate])
          ->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) { $q->where('titulo', 'not like', "%{$word}%"); }
          })->count();

        foreach ($this->students as $student) {
          $sid = (string)$student->id;

          $autoActividadesEntFinal = AcademicActivity::where('apprentice_id', $student->id)
            ->whereBetween('fecha', [$startDate, $endDate])
            ->where(function ($q) use ($keywords) {
              foreach ($keywords as $word) { $q->where('titulo', 'not like', "%{$word}%"); }
            })->count();

          $this->actividades_asignados[$sid] = (string)$autoActividadesAsigFinal;
          $this->actividades_entregados[$sid] = (string)$autoActividadesEntFinal;

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
            $this->worksheet_asignados[$sid] = (string)$historico->sum('worksheet_asignados');
            $this->worksheet_entregados[$sid] = (string)$historico->sum('worksheet_entregados');
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

    if ($this->selectedResult === 'final') {
      session()->flash('error', 'El resultado final es calculado automáticamente y no se puede guardar manualmente.');
      return;
    }

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

    $this->validate();

    $group = Group::find($this->selectedGroup);
    $teacherToSave = $group->teacher_id ?? $this->teacherId;

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
          'teacher_id' => $teacherToSave,
          'listening' => $this->listening[$id] ?? 0,
          'writing' => $this->writing[$id] ?? 0,
          'reading' => $this->reading[$id] ?? 0,
          'speaking' => $this->speaking[$id] ?? 0,
          'actividades_asignados' => $this->actividades_asignados[$id] ?? 0,
          'actividades_entregados' => $this->actividades_entregados[$id] ?? 0,
          'worksheet_asignados' => $this->worksheet_asignados[$id] ?? 0,
          'worksheet_entregados' => $this->worksheet_entregados[$id] ?? 0,
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
      $query = ModelsQualification::where('group_id', $this->selectedGroup)
        ->where('apprentice_id', $studentId)
        ->where('year', (string)$this->selectedYear);

      if (!$this->isAdmin) {
        $query->where('teacher_id', $this->teacherId);
      }

      $groupId = $this->selectedGroup;
      $year = (int)$this->selectedYear;
      $semester = (int)$this->selectedSemester;

      $calculateLive = function (&$qualities) use ($groupId, $year, $semester) {
        $keywords = ['worksheet', 'pelicula', 'movie', 'serie', 'series'];
        foreach ($qualities as $q) {
          $result = (int)$q->resultado;
          $startDate = null; $endDate = null;
          if ($semester == 1) {
            if ($result == 1) { $startDate = Carbon::createFromDate($year, 2, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 3, 31)->endOfDay(); }
            elseif ($result == 2) { $startDate = Carbon::createFromDate($year, 4, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 4, 30)->endOfDay(); }
            elseif ($result == 3) { $startDate = Carbon::createFromDate($year, 5, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 5, 31)->endOfDay(); }
          } else {
            if ($result == 1) { $startDate = Carbon::createFromDate($year, 8, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 9, 30)->endOfDay(); }
            elseif ($result == 2) { $startDate = Carbon::createFromDate($year, 10, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 10, 31)->endOfDay(); }
            elseif ($result == 3) { $startDate = Carbon::createFromDate($year, 11, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 11, 30)->endOfDay(); }
          }

          if ($startDate) {
            $baseAsig = AssignedActivity::whereHas('groups', function ($g) use ($groupId) {
              $g->where('groups.id', $groupId);
            })->whereBetween('assigned_activities.created_at', [$startDate, $endDate]);

            $q->actividades_asignados = (clone $baseAsig)->where(function ($g) use ($keywords) {
              foreach ($keywords as $word) { $g->where('titulo', 'not like', "%{$word}%"); }
            })->count();

            $baseEnt = AcademicActivity::where('apprentice_id', $q->apprentice_id)
              ->whereBetween('fecha', [$startDate, $endDate]);

            $q->actividades_entregados = (clone $baseEnt)->where(function ($g) use ($keywords) {
              foreach ($keywords as $word) { $g->where('titulo', 'not like', "%{$word}%"); }
            })->count();
          }
        }
      };

      if ($this->selectedResult === 'final') {
        $qualifications = (clone $query)->whereIn('resultado', ['1', '2', '3'])->get();
        $calculateLive($qualifications);
      } else {
        $qualifications = (clone $query)->where('resultado', $this->selectedResult)->get();
        $calculateLive($qualifications);
      }

      if ($qualifications->isEmpty()) {
        session()->flash('error', 'No hay calificaciones registradas para descargar el informe.');
        return;
      }

      $resultMap = ['1' => 'Primer', '2' => 'Segundo', '3' => 'Tercer', 'final' => 'Final'];
      session()->put('qualifications', $qualifications);
      session()->put('number', $resultMap[$this->selectedResult] ?? '');
      session()->put('selectedSemester', $this->selectedSemester);
      session()->put('selectedResult', $this->selectedResult);
      session()->put('selectedYear', $this->selectedYear);

      return redirect()->route('qualificationDownload');
    }
  }

  public function descargarGrupo()
  {
    if (!$this->selectedGroup || !$this->selectedSemester || !$this->selectedResult) {
      session()->flash('error', 'Seleccione Año, Semestre, Grupo y Resultado para descargar el informe grupal.');
      return;
    }

    $group = Group::with('type', 'teacher')->find($this->selectedGroup);
    $year = (int)$this->selectedYear;
    $semester = (int)$this->selectedSemester;
    $groupId = $this->selectedGroup;
    $keywords = ['worksheet', 'pelicula', 'movie', 'serie', 'series'];

    $calculateLiveForBatch = function (&$qualities) use ($keywords, $year, $semester, $groupId) {
      foreach ($qualities as $q) {
        $result = (int)$q->resultado;
        $startDate = null; $endDate = null;
        if ($semester == 1) {
          if ($result == 1) { $startDate = Carbon::createFromDate($year, 2, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 3, 31)->endOfDay(); }
          elseif ($result == 2) { $startDate = Carbon::createFromDate($year, 4, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 4, 30)->endOfDay(); }
          elseif ($result == 3) { $startDate = Carbon::createFromDate($year, 5, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 5, 31)->endOfDay(); }
        } else {
          if ($result == 1) { $startDate = Carbon::createFromDate($year, 8, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 9, 30)->endOfDay(); }
          elseif ($result == 2) { $startDate = Carbon::createFromDate($year, 10, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 10, 31)->endOfDay(); }
          elseif ($result == 3) { $startDate = Carbon::createFromDate($year, 11, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 11, 30)->endOfDay(); }
        }

        if ($startDate) {
          $baseAsig = AssignedActivity::whereHas('groups', function ($g) use ($groupId) {
            $g->where('groups.id', $groupId);
          })->whereBetween('assigned_activities.created_at', [$startDate, $endDate]);

          $q->actividades_asignados = (clone $baseAsig)->where(function ($g) use ($keywords) {
            foreach ($keywords as $word) { $g->where('titulo', 'not like', "%{$word}%"); }
          })->count();

          $baseEnt = AcademicActivity::where('apprentice_id', $q->apprentice_id)
            ->whereBetween('fecha', [$startDate, $endDate]);

          $q->actividades_entregados = (clone $baseEnt)->where(function ($g) use ($keywords) {
            foreach ($keywords as $word) { $g->where('titulo', 'not like', "%{$word}%"); }
          })->count();
        }
      }
    };

    if ($this->selectedResult === 'final') {
      $records = ModelsQualification::with('apprentice')
        ->where('group_id', $this->selectedGroup)
        ->where('year', (string)$this->selectedYear)
        ->where('semestre', $this->selectedSemester)
        ->whereIn('resultado', ['1', '2', '3'])
        ->get();

      if ($records->isEmpty()) {
        session()->flash('error', 'No hay registros para calcular el promedio final.');
        return;
      }

      $qualifications = $records->groupBy('apprentice_id')->map(function ($groupRecords) use ($year, $semester, $groupId, $keywords) {
        $first = $groupRecords->first();
        $virtual = new ModelsQualification();
        $virtual->setRelation('apprentice', $first->apprentice);
        $virtual->listening = $groupRecords->avg('listening');
        $virtual->writing = $groupRecords->avg('writing');
        $virtual->reading = $groupRecords->avg('reading');
        $virtual->speaking = $groupRecords->avg('speaking');

        $start = ($semester == 1) ? Carbon::createFromDate($year, 2, 1)->startOfDay() : Carbon::createFromDate($year, 8, 1)->startOfDay();
        $end = ($semester == 1) ? Carbon::createFromDate($year, 5, 31)->endOfDay() : Carbon::createFromDate($year, 11, 30)->endOfDay();

        $virtual->actividades_asignados = AssignedActivity::whereHas('groups', function ($g) use ($groupId) {
          $g->where('groups.id', $groupId);
        })->whereBetween('assigned_activities.created_at', [$start, $end])
          ->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) { $q->where('titulo', 'not like', "%{$word}%"); }
          })->count();

        $virtual->actividades_entregados = AcademicActivity::where('apprentice_id', $first->apprentice_id)
          ->whereBetween('fecha', [$start, $end])
          ->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) { $q->where('titulo', 'not like', "%{$word}%"); }
          })->count();

        $virtual->worksheet_asignados = $groupRecords->sum('worksheet_asignados');
        $virtual->worksheet_entregados = $groupRecords->sum('worksheet_entregados');
        return $virtual;
      })->values();

      session()->put('selectedResultName', 'Promedio Final Academico');
    } else {
      $qualifications = ModelsQualification::with('apprentice')
        ->where('group_id', $this->selectedGroup)
        ->where('year', (string)$this->selectedYear)
        ->where('semestre', $this->selectedSemester)
        ->where('resultado', $this->selectedResult)
        ->get();
      $calculateLiveForBatch($qualifications);
      session()->put('selectedResultName', 'Resultado ' . $this->selectedResult);
    }

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
