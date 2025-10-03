<?php

namespace App\Livewire;

use App\Models\RegisterHours as ModelsRegisterHours;
use App\Models\Teacher;
use Livewire\Component;

class RegisterHours extends Component
{
    public $registerHours, $profesores, $view = false, $teacher_id = '', $horas = '', $fecha = '', $filtro = '', $id = null;

    public function mount()
    {
        $this->registerHours = ModelsRegisterHours::all();

        $this->profesores = Teacher::all();
    }

    public function show($value = null)
    {
        $this->view = !$this->view;

        if ($this->view) {
            $registerHorus = ModelsRegisterHours::find($value);
            if ($registerHorus) {
                $this->teacher_id = $registerHorus->teacher_id;
                $this->horas = $registerHorus->horas;
                $this->fecha = $registerHorus->fecha;
                $this->id = $registerHorus->id;
            } else {
                $this->id = null;
            }
        }
    }

    public function updatedFiltro()
    {

        $this->registerHours = ModelsRegisterHours::whereHas(
            'teacher',
            fn($query) =>
            $query->where('name', 'like', "%{$this->filtro}%")
        )->get();
    }

    public function delete($value)
    {
        ModelsRegisterHours::where('id', $value)->delete();

        $this->registerHours = ModelsRegisterHours::all();
    }

    public function save()
    {
        $validaciones =  $this->validate([
            'teacher_id' => 'required',
            'horas' => 'required',
            'fecha' => 'required',
        ], [
            'required' => 'Este campo es requerido.',
        ]);

        ModelsRegisterHours::updateOrCreate(
            [
                'id' => $this->id
            ],
            $validaciones
        );

        $this->view = false;

        $this->registerHours = ModelsRegisterHours::all();
    }

    public function render()
    {
        return view('livewire.register-hours');
    }
}
