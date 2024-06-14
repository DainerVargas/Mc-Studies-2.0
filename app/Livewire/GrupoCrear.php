<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Group;
use App\Models\History;
use App\Models\Teacher;
use App\Models\Type;
use Carbon\Carbon;
use Livewire\Component;

class GrupoCrear extends Component
{

    public $grupos, $grupoNmae, $grupoId, $estado;
    public $name;
    public $teacher_id, $profesor_id, $profesorName;
    public $type_id, $historyName;
    public $profesores;
    public $filtroTeacher = '';
    public $types;
    public $filtroName = '';
    public $view = 0;
    public $view2 = 0;

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
            $this->grupos = Group::all();
        }
    }
    public function mount()
    {
        $this->grupos = Group::all();
        $this->profesores = Teacher::all();
        $this->types = Type::all();
    }

    public function delete(Group $grupo)
    {
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
        $this->view2 = 1;
        $this->grupoNmae = $grupo->name;
        $this->historyName = $grupo->name;
        if (isset($grupo->teacher->id)) {
            $this->profesorName = Teacher::find($grupo->teacher->id);
            $this->profesor_id = $this->profesorName->id;
        }
        $this->grupoId = $grupo->id;
    }

    public function guardar(Group $group)
    {
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

        $this->grupos = $query->get();


        return view('livewire.grupo-crear');
    }
}
