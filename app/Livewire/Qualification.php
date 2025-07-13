<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Asistencia;
use App\Models\Group;
use App\Models\Qualification as ModelsQualification;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Qualification extends Component
{
  public $qualification, $user, $estado = [], $success, $message, $observaciones = [];
  public $estudiantes, $filter = 'null', $nameAprendiz = '', $groups, $grupos, $selectGrupo = 'all';
  public $semestre = '', $number = '';
  public $speaking = [], $reading = [], $writing = [], $listening = [], $userEsAdmin, $erroresCampo = [], $messageSemestre;

  public Teacher $teacher;

  public function mount($teacher)
  {
    $this->teacher = $teacher;
    $this->user = Auth::user();
    $this->userEsAdmin = $this->user->rol_id == 1 || $this->user->rol_id == 2;
    $this->cargarAsistencias();
  }

  private function cargarAsistencias()
  {
    $this->grupos = Group::where('teacher_id', $this->teacher->id)->get();

    $gruposFiltrados = $this->selectGrupo !== 'all'
      ? [$this->selectGrupo]
      : Group::where('teacher_id', $this->teacher->id)->pluck('id')->toArray();

    $this->estudiantes = Apprentice::whereIn('group_id', $gruposFiltrados)->get();

    $this->listening = [];
    $this->writing = [];
    $this->reading = [];
    $this->speaking = [];
    $this->observaciones = [];

    foreach ($this->estudiantes as $estudiante) {
      $calificacion = ModelsQualification::where('apprentice_id', $estudiante->id)
        ->where('teacher_id', $this->teacher->id)
        ->where('group_id', $this->selectGrupo)
        ->where('semestre', $this->semestre)
        ->first();

      if ($calificacion) {
        $this->listening[$estudiante->id] = $calificacion->listening;
        $this->writing[$estudiante->id] = $calificacion->writing;
        $this->reading[$estudiante->id] = $calificacion->reading;
        $this->speaking[$estudiante->id] = $calificacion->speaking;
        $this->observaciones[$this->selectGrupo][$estudiante->id] = $calificacion->observacion;
      }
    }

    if ($this->semestre == 4) {
      foreach ($this->estudiantes as $estudiante) {
        $id = $estudiante->id;

        $calificaciones = ModelsQualification::where('apprentice_id', $id)
          ->where('group_id', $this->selectGrupo)
          ->where('teacher_id', $this->teacher->id)
          ->whereIn('semestre', [1, 2, 3])
          ->get();

        if ($calificaciones->count() > 0) {
          $this->listening[$id] = round($calificaciones->avg('listening'), 2);
          $this->writing[$id]   = round($calificaciones->avg('writing'), 2);
          $this->reading[$id]   = round($calificaciones->avg('reading'), 2);
          $this->speaking[$id]  = round($calificaciones->avg('speaking'), 2);
        } else {
          $this->listening[$id] = 0;
          $this->writing[$id] = 0;
          $this->reading[$id] = 0;
          $this->speaking[$id] = 0;
        }
      }
    }
  }

  public function updatedSemestre()
  {
    $this->cargarAsistencias();
  }

  public function updatedDate()
  {
    $this->message = null;
    if ($this->date > now()->format('Y-m-d')) {
      $this->message = "La fecha seleccionada es mayor que la actual.";
      return;
    }
    $this->cargarAsistencias();
  }

  public function updatedFilter()
  {
    try {
      if ($this->date <= now()->format('Y-m-d') && !empty($this->qualification->toArray())) {
        $this->cargarAsistencias();
      } else {
        $this->message = "Debes guardar la asistencia.";
      }
    } catch (\Throwable $th) {
      dd('Por favor guarde asistencias.');
    }
  }

  public function updatedNameAprendiz()
  {
    $grupos = Group::where('teacher_id', $this->teacher->id)->pluck('id');
    if ($this->nameAprendiz != '') {
      $estudiantes = Apprentice::whereIn('group_id', $grupos)
        ->where('name', 'LIKE', "%{$this->nameAprendiz}%")
        ->pluck('id');

      $query = ModelsQualification::whereIn('apprentice_id', $estudiantes)
        ->where('fecha', $this->date);

      if ($this->filter !== 'null') {
        $query->where('estado', $this->filter);
      }
      $this->qualification = $query->get();
    } else {
      $this->cargarAsistencias();
    }
  }

  public function updatedSelectGrupo()
  {
    $this->cargarAsistencias();
  }

  public function guardarNotas()
  {
    $this->reset('message');
    $this->erroresCampo = [];

    if (!$this->semestre || $this->selectGrupo == 'all') {
      $this->message = "Debes seleccionar el semestre y el grupo antes de guardar.";
      return;
    }

    foreach ($this->estudiantes as $estudiante) {
      $id = $estudiante->id;

      $notas = [
        'listening' => $this->listening[$id] ?? null,
        'writing'   => $this->writing[$id] ?? null,
        'reading'   => $this->reading[$id] ?? null,
        'speaking'  => $this->speaking[$id] ?? null,
      ];

      foreach ($notas as $materia => $nota) {
        $clave = "{$materia}_{$id}";

        if (is_null($nota)) {
          $this->erroresCampo[$clave] = "Campo obligatorio.";
        } elseif (!is_numeric($nota) || $nota < 0 || $nota > 100) {
          $this->erroresCampo[$clave] = "Debe estar entre 0 y 100.";
        }
      }
    }

    if (!empty($this->erroresCampo)) {
      $this->message = "Corrige los errores antes de guardar.";
      return;
    }

    if (!$this->userEsAdmin) {
      foreach ($this->estudiantes as $estudiante) {
        $yaExiste = ModelsQualification::where('apprentice_id', $estudiante->id)
          ->where('group_id', $this->selectGrupo)
          ->where('teacher_id', $this->teacher->id)
          ->where('semestre', $this->semestre)
          ->exists();

        if ($yaExiste) {
          $this->message = "Solo el administrador puede editar calificaciones ya registradas.";
          return;
        }
      }
    }

    foreach ($this->estudiantes as $estudiante) {
      $id = $estudiante->id;

      ModelsQualification::updateOrCreate(
        [
          'apprentice_id' => $id,
          'group_id' => $this->selectGrupo,
          'teacher_id' => $this->teacher->id,
          'semestre' => $this->semestre,
        ],
        [
          'listening'    => $this->listening[$id],
          'writing'      => $this->writing[$id],
          'reading'      => $this->reading[$id],
          'speaking'     => $this->speaking[$id],
          'observacion'  => $this->observaciones[$this->selectGrupo][$id] ?? null,
        ]
      );
    }

    $this->success = 'Todas las calificaciones se guardaron correctamente.';
    $this->cargarAsistencias();
  }

  public function deleteNotas()
  {
    if ($this->selectGrupo != 'all') {

      $qualifications = ModelsQualification::where('teacher_id', $this->teacher->id)
        ->where('group_id', $this->selectGrupo)->get();

      foreach ($qualifications as $qualification) {
        $qualification->delete();
      }
      $this->cargarAsistencias();
      $this->messageSemestre = '';
      
    } else {
      $this->messageSemestre = 'Seleccione el grupo a elimar la calificación';
    }
  }

  public function download($studentId)
  {
    if ($this->number != '' && $this->semestre != '' && $this->selectGrupo != 'all') {
      if ($this->semestre == 4) {
        $qualification = ModelsQualification::where('teacher_id', $this->teacher->id)
          ->where('group_id', $this->selectGrupo)
          ->where('apprentice_id', $studentId)
          ->whereIn('semestre', [1, 2, 3])
          ->get();
      } else {
        $qualification = ModelsQualification::where('teacher_id', $this->teacher->id)
          ->where('group_id', $this->selectGrupo)
          ->where('apprentice_id', $studentId)
          ->where('semestre', $this->semestre)
          ->get();
      }

      session()->put('qualifications', $qualification);
      session()->put('number',  $this->number);
      return redirect()->route('qualificationDownload');
    } else {
      $this->messageSemestre = 'Seleccione los campos';
    }
  }

  public function render()
  {
    return view('livewire.qualification');
  }
}
