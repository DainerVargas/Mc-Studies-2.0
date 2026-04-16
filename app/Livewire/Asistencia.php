<?php

namespace App\Livewire;

use App\Models\Asistencia as Asistent;
use App\Models\Group;
use App\Models\Apprentice;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Asistencia extends Component
{
    public $asistencias, $user, $estado = [], $date, $message, $observaciones = [];
    public $estudiantes, $filter = 'null', $nameAprendiz = '', $groups, $grupos, $selectGrupo = 'all';
    public $startDate, $endDate, $datesInRange = [];
    public Teacher $teacher;

    public function mount($teacher)
    {
        $this->teacher = $teacher;
        $this->user = Auth::user();

        // Inicializar con la semana actual
        $this->startDate = now()->startOfWeek()->format('Y-m-d');
        $this->endDate = now()->endOfWeek()->format('Y-m-d');
        $this->date = now()->format('Y-m-d');

        $this->cargarAsistencias();
    }

    public function updatedStartDate()
    {
        $this->message = null;
        $this->cargarAsistencias();
    }

    public function updatedEndDate()
    {
        $this->message = null;
        $this->cargarAsistencias();
    }

    public function setFilter($value)
    {
        if ($this->filter === $value) {
            $this->filter = 'null';
        } else {
            $this->filter = $value;
        }
        $this->cargarAsistencias();
    }

    public function updatedFilter()
    {
        $this->cargarAsistencias();
    }

    public function updatedNameAprendiz()
    {
        $isAdmin = in_array(Auth::user()->rol_id, [1, 2, 3]);
        if ($isAdmin) {
            $gruposIds = Group::pluck('id');
        } else {
            $gruposIds = Group::where('teacher_id', $this->teacher->id)
                ->orWhereHas('tutors', function($q) {
                    $q->where('teacher_id', $this->teacher->id);
                })
                ->pluck('id');
        }

        if ($this->nameAprendiz != '') {
            $estudiantesIds = Apprentice::whereIn('group_id', $gruposIds)
                ->where('name', 'LIKE', "%{$this->nameAprendiz}%")
                ->pluck('id');

            $query = Asistent::whereIn('apprentice_id', $estudiantesIds)
                ->whereBetween('fecha', [$this->startDate, $this->endDate]);

            if ($this->filter !== 'null') {
                $query->where('estado', $this->filter);
            }
            $this->asistencias = $query->get()->groupBy(['apprentice_id', 'fecha'])->toArray();
        } else {
            $this->cargarAsistencias();
        }
    }

    public function updatedSelectGrupo()
    {
        $this->cargarAsistencias();
    }

    private function cargarAsistencias()
    {
        $isAdmin = in_array(Auth::user()->rol_id, [1, 2, 3]);

        // Generar lista de fechas en el rango
        $this->datesInRange = [];
        $start = \Carbon\Carbon::parse($this->startDate);
        $end = \Carbon\Carbon::parse($this->endDate);

        // Limitar el rango a máximo 31 días para evitar problemas de rendimiento/diseño
        if ($start->diffInDays($end) > 31) {
            $end = (clone $start)->addDays(31);
            $this->endDate = $end->format('Y-m-d');
        }

        $tempDate = clone $start;
        while ($tempDate <= $end) {
            $this->datesInRange[] = $tempDate->format('Y-m-d');
            $tempDate->addDay();
        }

        $query = Asistent::whereBetween('fecha', [$this->startDate, $this->endDate]);

        if (!$isAdmin) {
            $query->where(function($q) {
                $q->where('teacher_id', $this->teacher->id)
                  ->orWhereHas('group.tutors', function($sq) {
                      $sq->where('teacher_id', $this->teacher->id);
                  });
            });
        }

        if ($isAdmin) {
            $this->grupos = Group::all();
        } else {
            $this->grupos = Group::where('teacher_id', $this->teacher->id)
                ->orWhereHas('tutors', function($q) {
                    $q->where('teacher_id', $this->teacher->id);
                })
                ->get();
        }

        if ($this->selectGrupo != 'all') {
            $query->where('group_id', $this->selectGrupo);
        }

        if ($this->filter !== 'null') {
            $query->where('estado', $this->filter);
        }

        $this->asistencias = $query->get()->groupBy(['apprentice_id', 'fecha'])->toArray();

        // Cargar estudiantes siempre para tener la lista base
        if ($isAdmin) {
            $this->groups = Group::pluck('id');
        } else {
            $this->groups = Group::where('teacher_id', $this->teacher->id)
                ->orWhereHas('tutors', function($q) {
                    $q->where('teacher_id', $this->teacher->id);
                })
                ->pluck('id');
        }

        $studentQuery = Apprentice::query();
        if ($this->selectGrupo != 'all') {
            $studentQuery->where('group_id', $this->selectGrupo);
        } else {
            $studentQuery->whereIn('group_id', $this->groups);
        }

        if ($this->nameAprendiz != '') {
            $studentQuery->where('name', 'LIKE', "%{$this->nameAprendiz}%");
        }

        $this->estudiantes = $studentQuery->get();

        if (empty($this->asistencias)) {
            $this->message = $this->filter !== 'null' ? "No hay registros con el estado: " . $this->filter : '';
        } else {
            $this->message = '';
        }
    }

    public function guardarAsistencia()
    {
        foreach ($this->estudiantes as $estudiante) {
            if (!isset($this->estado[$estudiante->id])) {
                $this->estado[$estudiante->id] = null;
            }
        }

        $this->validate(
            [
                'estado.*' => 'required',
            ],
            [
                'estado.*.required' => 'El estado del estudiante es requerido',
            ]
        );

        foreach ($this->estudiantes as $estudiante) {
            $groupId = $this->selectGrupo === 'all' ? $estudiante->group_id : $this->selectGrupo;
            $group = Group::find($groupId);
            $teacherId = $group->teacher_id ?? $this->teacher->id;

            Asistent::create(
                [
                    'apprentice_id' => $estudiante->id,
                    'teacher_id' => $teacherId,
                    'fecha' => $this->date,
                    'group_id' => $groupId,
                    'estado' => $this->estado[$estudiante->id],
                    'observaciones' => $this->observaciones[$groupId][$estudiante->id] ?? null,
                ]
            );
        }

        return redirect('Resgistro-Asistencias/' . $this->teacher->id);
    }

    public function descarga()
    {
        $isAdmin = in_array(Auth::user()->rol_id, [1, 2, 3]);
        $query = Asistent::with('apprentice')
            ->whereBetween('fecha', [$this->startDate, $this->endDate])
            ->where('group_id', $this->selectGrupo);

        if (!$isAdmin) {
            $query->where('teacher_id', $this->teacher->id);
        }

        $asistencias = $query->get();

        dd($asistencias);

        return view('descargaAsistencia', compact('asistencias'));
    }

    public function render()
    {
        return view('livewire.asistencia', [
            'mostrarVideo' => $this->filter !== 'null' && empty($this->asistencias)
        ]);
    }
}
