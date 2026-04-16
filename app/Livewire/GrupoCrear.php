<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Group;
use App\Models\History;
use App\Models\Qualification;
use App\Models\Teacher;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GrupoCrear extends Component
{

    public $grupos, $grupoNmae, $grupoId, $estado;
    public $name;
    public $teacher_id, $profesor_id, $profesorName, $show = false, $nameTeacher, $groupName, $typeGroup;
    public $type_id, $historyName, $qualifications, $idGroup;
    public $profesores;
    public $filtroTeacher = '';
    public $types;
    public $filtroName = '';
    public $view = 0;
    public $view2 = 0;
    public $tutor_ids = [];
    public $allTutors = [];

    public function update()
    {
        $this->view = 1;
        $this->view2 = 0;
    }

    public function ocultar()
    {
        $this->view = 0;
        $this->view2 = 0;
        $this->profesor_id = '';
        $this->show = false;
    }

    public function save()
    {
        $validaciones =  $this->validate([
            'name' => 'required|unique:groups,name',
            'teacher_id' => 'required',
            'type_id' => 'required',
        ], [
            'required' => 'Este campo es requerido.',
            'name.unique' => 'Este nombre ya existe.',
        ]);

        if ($validaciones) {

            $grupos = Group::create([
                'name' => $this->name,
                'teacher_id' => $this->teacher_id,
                'type_id' => $this->type_id,
            ]);

            if (!empty($this->tutor_ids)) {
                $grupos->tutors()->sync($this->tutor_ids);
            }

            $year = Carbon::now()->format('y');
            /* $year = 25; */
            $mes = Carbon::now()->format('m');
            /* $mes = 9; */

            $historial = new History();
            $historial->name = $this->name;
            $historial->cantidad = 0;
            $historial->year =  $year;
            $historial->mes = $mes;
            $historial->total = 0;
            $historial->save();

            $this->name = '';
            $this->teacher_id = '';
            $this->type_id = '';
            $this->filtroTeacher = '';

            $this->view = 0;
            $this->tutor_ids = [];
            $this->render();
        }
    }
    public function mount()
    {
        $this->profesores = Teacher::all();
        $this->allTutors = Teacher::where('type_teacher_id', 2)->get();
        $this->types = Type::all();
    }

    public function delete(Group $grupo)
    {
        if (Auth::user()->rol_id != 1) {
            $this->dispatch('error', 'No tienes permisos para eliminar.');
            return;
        }

        $grupo->teacher_id = null;
        $grupo->type_id = null;
        $aprentices = Apprentice::where('group_id', $grupo->id)->get();
        foreach ($aprentices as $aprentice) {
            $aprentice->group_id = null;
            $aprentice->save();
        }
        $grupo->delete();
        $this->grupos = Group::all();
    }

    public function actualizar(Group $grupo)
    {
        if (!$this->canAccessGroup($grupo)) {
            $this->dispatch('error', 'No tienes permisos para acceder a este grupo.');
            return;
        }
        $this->view2 = 1;
        $this->grupoNmae = $grupo->name;
        $this->historyName = $grupo->name;
        if (isset($grupo->teacher->id)) {
            $this->profesorName = Teacher::find($grupo->teacher->id);
            $this->profesor_id = $this->profesorName->id;
        }
        $this->tutor_ids = $grupo->tutors->pluck('id')->toArray();
        $this->grupoId = $grupo->id;
    }

    public function guardar(Group $group)
    {
        if (!$this->canAccessGroup($group)) {
            $this->dispatch('error', 'No tienes permisos para modificar este grupo.');
            return;
        }
        $validaciones =  $this->validate([
            'grupoNmae' => 'required',
            'profesor_id' => 'required',
        ], [
            'required' => 'Este campo es requerido.',
        ]);

        if ($validaciones) {

            $group->update([
                'name' => $this->grupoNmae,
                'teacher_id' => $this->profesor_id,
            ]);

            $group->tutors()->sync($this->tutor_ids);

            $year = Carbon::now()->format('y');
            /* $year = 25; */
            $history = History::where('name', $this->historyName)->where('year', $year)->first();

            if (isset($history)) {
                $history->name = $this->grupoNmae;
                $history->save();
            }

            $this->profesor_id = '';
            $this->filtroTeacher = '';
            $this->view2 = 0;
        }
    }

    public function descargarReporte()
    {
        session()->put('groupName', $this->groupName);
        session()->put('nameTeacher', $this->nameTeacher);
        session()->put('typeGroup', $this->typeGroup);
        session()->put('qualifications', $this->qualifications);

        return redirect()->route('groupCalification');
    }

    public function verDetalle($grupo = null)
    {
        $group = Group::find($grupo);
        if (!$group || !$this->canAccessGroup($group)) {
            $this->dispatch('error', 'No tienes permisos para ver los detalles de este grupo.');
            return;
        }

        $this->idGroup = $group->id;

        $this->show = true;
        session()->put('show', $this->show);

        if (!$group) {
            return;
        }
        $this->nameTeacher = '';
        if (isset($group->teacher->name)) {
            $this->nameTeacher = $group->teacher->name;
        }
        $this->groupName = $group->name;
        $this->typeGroup = '';
        if (isset($group->type->name)) {
            $this->typeGroup = $group->type->name;
        }

        $this->qualifications = Qualification::where('group_id', $group->id)
            ->orderBy('semestre', 'ASC')
            ->get()
            ->groupBy('semestre')
            ->map(function ($items) {
                $listening = $items->avg('listening');
                $writing   = $items->avg('writing');
                $reading   = $items->avg('reading');
                $speaking  = $items->avg('speaking');

                $global = ($listening + $writing + $reading + $speaking) / 4;

                return [
                    'listening' => round($listening, 2),
                    'writing'   => round($writing, 2),
                    'reading'   => round($reading, 2),
                    'speaking'  => round($speaking, 2),
                    'global'    => round($global, 2),
                ];
            });
    }

    public function render()
    {
        $this->profesores = Teacher::where('name', 'LIKE', '%' . $this->filtroTeacher . '%')->get();
        /* dd($this->profesores); */

        $query = Group::query();

        if ($this->estado == 'active') {
            $query->where('type_id', 1);
        } elseif ($this->estado == 'inactive') {
            $query->where('type_id', 2);
        }

        $query->where('name', 'LIKE', '%' . $this->filtroName . '%');

        $user = Auth::user();
        if (!in_array($user->rol_id, [1, 2, 3]) && $user->teacher_id) {
            $teacher = $user->teacher;
            if ($teacher->type_teacher_id == 2) { // Tutor
                $query->where(function($q) use ($teacher) {
                    $q->where('teacher_id', $teacher->id)
                      ->orWhereHas('tutors', function($sq) use ($teacher) {
                          $sq->where('teacher_id', $teacher->id);
                      });
                });
            } else { // Regular Professor
                $query->where('teacher_id', $teacher->id);
            }
        }

        $this->grupos = $query->get();


        return view('livewire.grupo-crear');
    }
    protected function canAccessGroup(Group $group)
    {
        $user = Auth::user();
        if (in_array($user->rol_id, [1, 2, 3])) { // Admin, Secretaria, Asistente
            return true;
        }

        if (!$user->teacher_id) {
            return false;
        }

        $teacherId = $user->teacher_id;
        
        // Owner or assigned tutor
        return $group->teacher_id == $teacherId || $group->tutors()->where('teacher_id', $teacherId)->exists();
    }
}
