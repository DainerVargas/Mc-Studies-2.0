<?php

namespace App\Livewire;

use App\Models\RegisterHours;
use App\Models\Teacher;
use Livewire\Component;

class RegisterHoursForm extends Component
{
    public $editId, $teacher_id = '', $horas = '', $lunes = '', $martes = '', $miercoles = '', $jueves = '', $viernes = '', $sabado = '';
    public $profesores;

    public function mount($editId = null)
    {
        $this->editId = $editId;
        $this->profesores = Teacher::all();

        if ($this->editId) {
            $record = RegisterHours::find($this->editId);
            if ($record) {
                $this->teacher_id = $record->teacher_id;
                $this->horas = $record->horas;
                $this->lunes = $record->lunes;
                $this->martes = $record->martes;
                $this->miercoles = $record->miercoles;
                $this->jueves = $record->jueves;
                $this->viernes = $record->viernes;
                $this->sabado = $record->sabado;
            }
        }
    }

    public function save()
    {
        $validaciones = $this->validate([
            'teacher_id' => 'required',
            'horas' => 'required',
            'lunes' => 'nullable',
            'martes' => 'nullable',
            'miercoles' => 'nullable',
            'jueves' => 'nullable',
            'viernes' => 'nullable',
            'sabado' => 'nullable',
        ], [
            'required' => 'Este campo es requerido.',
        ]);

        foreach (['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'] as $dia) {
            if (empty($validaciones[$dia])) {
                $validaciones[$dia] = null;
            }
        }

        RegisterHours::updateOrCreate(
            ['id' => $this->editId],
            $validaciones
        );

        return redirect()->route('registerHours')->with('success', 'Registro guardado correctamente.');
    }

    public function render()
    {
        return view('livewire.register-hours-form');
    }
}
