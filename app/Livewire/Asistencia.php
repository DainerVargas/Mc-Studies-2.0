<?php

namespace App\Livewire;

use App\Models\Asistencia as Asistent;
use App\Models\Group;
use App\Models\Apprentice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Asistencia extends Component
{
    public $asistencias, $user, $estado = [], $date, $message, $observaciones = [];
    public $estudiantes, $filter = 'null', $nameAprendiz = '', $groups, $grupos, $selectGrupo = 'all';


    public function mount()
    {
        $this->user = Auth::user();
        $this->date = now()->format('Y-m-d');

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
        if ($this->date <= now()->format('Y-m-d') && !empty($this->asistencias->toArray())) {
            $this->cargarAsistencias();
        } else {
            $this->message = "Debes guardar la asistencia.";
        }
    }

    public function updatedNameAprendiz()
    {
        $grupos = Group::where('teacher_id', $this->user->teacher_id)->pluck('id');
        if ($this->nameAprendiz != '') {
            $estudiantes = Apprentice::whereIn('group_id', $grupos)
                ->where('name', 'LIKE', "%{$this->nameAprendiz}%")
                ->pluck('id');

            $query = Asistent::whereIn('apprentice_id', $estudiantes)
                ->where('fecha', $this->date);

            if ($this->filter !== 'null') {
                $query->where('estado', $this->filter);
            }
            $this->asistencias = $query->get();
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
        $query = Asistent::where('teacher_id', $this->user->teacher_id)
            ->where('fecha', $this->date);

        $this->grupos = Group::where('teacher_id', $this->user->teacher_id)->get();

        if ($this->selectGrupo != 'all') {
            $query->where('group_id', $this->selectGrupo);
        }

        if ($this->filter !== 'null') {
            $query->where('estado', $this->filter);

            $validate = $query->get();

            if ($validate->isEmpty()) {
                $this->message = "No hay registros con el estado: " . $this->filter;
                return;
            } else {
                $this->message = '';
            }
        } else {
            $this->message = '';
        }

        $this->asistencias = $query->get();

        if ($this->asistencias->isEmpty()) {
            $this->groups = Group::where('teacher_id', $this->user->teacher_id)->pluck('id');

            if ($this->selectGrupo != 'all') {
                $this->estudiantes = Apprentice::where('group_id', $this->selectGrupo)->get();
            } else {
                $this->estudiantes = Apprentice::whereIn('group_id', $this->groups)->get();
            }
            $this->asistencias = [];
            return;
        } else {

            $estudiantesIds = $this->asistencias->pluck('apprentice_id');
            $this->estudiantes = Apprentice::whereIn('id', $estudiantesIds)->get();
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
            Asistent::create(
                [
                    'apprentice_id' => $estudiante->id,
                    'teacher_id' => $this->user->teacher_id,
                    'fecha' => $this->date,
                    'group_id' => $this->selectGrupo,
                    'estado' => $this->estado[$estudiante->id],
                    'observaciones' => $this->observaciones[$this->selectGrupo][$estudiante->id] ?? null,
                ]
            );
        }

        return redirect('Resgistro-Asistencias');
    }

    public function descarga()
    {
        $asistencias = Asistent::with('apprentice')
        ->where('teacher_id', $this->user->teacher_id)
        ->where('fecha', $this->date)
        ->where('group_id', $this->selectGrupo)
        ->get();

    
   /*  $pdf = Pdf::loadView('descargaAsistencia', ['asistencias' => $asistencias]);
    
    return $pdf->download("Registro_Asistencia.pdf"); */

   return view('descargaAsistencia' , compact('asistencias'));
    
    }

    public function render()
    {
        return view('livewire.asistencia', [
            'mostrarVideo' => $this->filter !== 'null' && $this->asistencias->isEmpty()
        ]);
    }
}
