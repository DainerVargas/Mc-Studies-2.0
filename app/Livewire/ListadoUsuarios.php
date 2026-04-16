<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListadoUsuarios extends Component
{
    public $search = '';

    public function eliminar(User $user)
    {
        $user->delete();
    }

    public function render()
    {
        $user = Auth::user();
        $usuarios = User::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        })
            ->get();

        return view('livewire.listado-usuarios', [
            'usuarios' => $usuarios,
            'user' => $user
        ]);
    }
}
