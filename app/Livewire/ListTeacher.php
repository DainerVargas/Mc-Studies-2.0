<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Group;
use App\Models\Teacher;
use App\Models\Tinforme;
use App\Models\TypeTeacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ListTeacher extends Component
{
    use WithFileUploads;

    public $profesores = [];

    public $types = [];

    public $filtro = '';
    public $type_teacher_id = '';
    public $name = '', $email = '', $apellido = '', $telefono = '', $image;

    public $estado = 'all';

    public $view = 0;

    public function update()
    {
        $this->view = 1;
    }

    public function ocultar()
    {
        $this->image = '';
        $this->view = 0;
    }

    public function delete(Teacher $teacher)
    {
        if (Auth::user()->rol_id != 1) {
            $this->dispatch('error', 'No tienes permisos para eliminar.');
            return;
        }

        $grupos = Group::where('teacher_id', $teacher->id)->get();
        $informes = Tinforme::where('teacher_id', $teacher->id)->get();
        foreach ($grupos as $grupo) {
            $grupo->teacher_id = null;
            $grupo->save();
        }

        Account::where('teacher_id', $teacher->id)->delete();

        foreach ($informes as $informe) {
            $informe->delete();
        }
        $teacher->delete();
        $this->profesores = Teacher::all();
    }

    public function save()
    {
        $validaciones = $this->validate([
            'name' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:teachers,email',
            'image' => 'nullable|image|max:2048',
            'telefono' => 'required|max:10|min:10',
            'type_teacher_id' => 'required',
        ], [
            'required' => 'Este campo es requerido',
            'unique' => 'Este email ya existe',
            'max' => 'El tamño de la imagen es muy grande',
            'numeric' => 'No parece ser un numero',
            'email' => 'Este campo debe ser un email',
            'telefono.max' => 'El numero de telefono es muy largo',
            'telefono.min' => 'El numero de telefono es muy corto',
        ]);

        if ($validaciones) {

            if (isset($this->image)) {

                $imageName = $this->image->store('', 'public');
                $foto = basename($imageName);
            } else {
                $imageName = '';
            }


            $profesor = Teacher::create([
                'name' => $this->name,
                'apellido' => $this->apellido,
                'email' => $this->email,
                'image' => $imageName,
                'estado' => 1,
                'telefono' => $this->telefono,
                'type_teacher_id' => $this->type_teacher_id,
                'fecha_inicio' => now(),
                'precio_hora' => 0,
                'fecha_fin' => now()->addDays(7),
            ]);

            $this->view = 0;
            $this->name = '';
            $this->apellido = '';
            $this->email = '';
            $this->image = '';
            $this->telefono = '';
            $this->type_teacher_id = '';
        }
    }

    public function mount()
    {
        $this->profesores = Teacher::all();
        $this->types = TypeTeacher::all();
    }

    public function render()
    {
        $query = Teacher::query();

        if ($this->estado == 'active') {
            $query->where('estado', 1);
        } elseif ($this->estado == 'inactive') {
            $query->where('estado', 0);
        }

        if ($this->filtro != '') {
            $words = preg_split('/\s+/', strtolower(trim($this->filtro)));

            $query->where(function ($q) use ($words) {
                foreach ($words as $word) {

                    if (strlen($word) <= 4) {
                        continue;
                    }

                    $term = '%' . $word . '%';

                    $q->orWhere(function ($subQ) use ($term) {
                        $subQ->where('name', 'LIKE', $term)
                            ->orWhere('apellido', 'LIKE', $term);
                    });
                }
            });
        }

        $this->profesores = $query->get();

        return view('livewire.list-teacher');
    }
}
