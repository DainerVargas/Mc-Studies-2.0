<?php

namespace App\Livewire;

use App\Models\Group;
use App\Models\Modality;
use Livewire\Component;
use Livewire\WithFileUploads;

class SelecteImage extends Component
{
    use WithFileUploads;

    public $aprendiz;
    public $image;
    public $grupos;
    public $modalidades;

    public function mount(){
        $this->grupos = Group::all();
        $this->modalidades = Modality::all();
    }

    public function render()
    {
        return view('livewire.selecte-image');
    }
}
