<?php

namespace App\Livewire;

use App\Mail\PasswordResetMail;
use App\Models\Apprentice;
use App\Models\Group;
use App\Models\Informe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ListAprendiz extends Component
{

    public $aprendices = [];
    public $grupos = [];
    public $filtro = '';
    public $grupo = 'all';
    public $estado = 'all';
    public $count = 0;

    public function filtrar()
    {

        $query = Apprentice::query();
        /*  dd($this->grupo); */

        if ($this->grupo == 'all') {
            $query = Apprentice::query();
        } elseif ($this->grupo == 'none') {
            $query->whereNull('group_id');
        } else {
            $query->where('group_id', $this->grupo);
        }

        if ($this->estado == 'active') {
            $query->where('estado', 1);
        } elseif ($this->estado == 'inactive') {
            $query->where('estado', 0);
        }

        if (!empty($this->filtro)) {
            $query->where('name', 'LIKE', '%' . $this->filtro . '%');
        }

        $this->aprendices = $query->get();
    }

    public function delete(Apprentice $apprentice)
    {
        $informe = Informe::where('apprentice_id', $apprentice->id)->first();
        if ($informe) {
            $informe->delete();
        }
        $apprentice->delete();
        $this->aprendices = Apprentice::all();
    }


    public function deleteAll()
    {
        $informes = Informe::all();
        $aprendices = Apprentice::all();

        foreach ($informes as $value) {
            $value->delete();
        }

        foreach ($aprendices as $value) {
            $value->delete();
        }

        $this->aprendices = Apprentice::all();
    }

    public function mount()
    {
        $this->aprendices = Apprentice::all();
        $this->grupos = Group::all();
    }

    public function render()
    {

        return view('livewire.list-aprendiz');
    }
}
