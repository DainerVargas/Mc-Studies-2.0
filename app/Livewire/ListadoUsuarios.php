<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListadoUsuarios extends Component
{
    public $user, $usuarios;

    public function mount()
    {
        $this->usuarios = User::all();
    }

    public function eliminar(User $user)
    {
        $user->delete();
        $this->usuarios = User::all();
    }

    public function render()
    {
        $this->user = Auth::user();
        return view('livewire.listado-usuarios');
    }
}
