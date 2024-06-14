<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class CargarImagen extends Component
{

    use WithFileUploads;

    public $user,$imagen;

    public function render()
    {
        return view('livewire.cargar-imagen');
    }
}
