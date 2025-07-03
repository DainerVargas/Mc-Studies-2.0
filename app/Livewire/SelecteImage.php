<?php

namespace App\Livewire;

use App\Models\Becado;
use App\Models\Group;
use App\Models\Modality;
use DateTime;
use Livewire\Component;
use Livewire\WithFileUploads;

class SelecteImage extends Component
{
    use WithFileUploads;

    public $aprendiz, $modalidades, $grupos, $image, $edadActualizada, $becados;

    public function mount()
    {
        $this->grupos = Group::all();
        $this->modalidades = Modality::all();
        $this->becados = Becado::all();

        $fechaNacimiento = new DateTime($this->aprendiz->fecha_nacimiento);
        $hoy = new DateTime();
        $this->edadActualizada = $hoy->diff($fechaNacimiento)->y;
    }

    public function render()
    {
        return view('livewire.selecte-image');
    }
}
