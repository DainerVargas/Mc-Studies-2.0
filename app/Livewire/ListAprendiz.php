<?php

namespace App\Livewire;

use App\Mail\PasswordResetMail;
use App\Models\Apprentice;
use App\Models\Group;
use App\Models\Informe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ListAprendiz extends Component
{
    public $aprendices = [];
    public $grupos = [];
    public $nameAprendiz = '';
    public $grupo = 'all';
    public $estado = 'all';
    public $count = 0, $user, $sede_id = '';

    public function delete(Apprentice $apprentice)
    {
        $informes = Informe::where('apprentice_id', $apprentice->id)->get();

        foreach ($informes as $informe) {
            $informe->delete();
        }
        $apprentice->delete();
        $this->aprendices = Apprentice::all();
    }

    public function mount()
    {
        $usuario = Auth::user();

        if($usuario->rol_id != 4){
            $this->grupos = Group::all();
        }else{
            $this->grupos = Group::where('teacher_id',$usuario->teacher_id)->get();
        }
    }

    public function sendEmail(){

        return redirect('/Enviar-Email');
    }

    public function render()
    {
        $this->user = Auth::user();

        if (isset($this->user->teacher_id)) {
            $grupos = Group::where('teacher_id', $this->user->teacher_id)->pluck('id');

            $query = Apprentice::whereIn('group_id', $grupos);
        } else {
            $query = Apprentice::query();
        }

        if ($this->grupo == 'all') { 
        } elseif ($this->grupo == 'none') {
            $query->whereNull('group_id');
        } else {
            $query->where('group_id', $this->grupo);
        }

        if ($this->sede_id != '') {
            $query->where('sede_id', $this->sede_id);
        } 

        if ($this->estado == 'active') {
            $query->where('estado', 1);
        } elseif ($this->estado == 'inactive') {
            $query->where('estado', 0);
        }

        $query->where('name', 'LIKE', '%' . $this->nameAprendiz . '%');

        $this->aprendices = $query->get();

        return view('livewire.list-aprendiz', [
            'user' => $this->user,
            'aprendices' => $this->aprendices
        ]);
    }
}
