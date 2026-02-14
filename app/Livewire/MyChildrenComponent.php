<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyChildrenComponent extends Component
{
    public $children;

    public function render()
    {
        $user = Auth::user();
        if ($user->attendant) {
            $this->children = $user->attendant->apprentice;
        } else {
            $this->children = collect();
        }

        // Check if only one child, maybe redirect? 
        // User asked for a list, and then click to access.
        // If I redirect automatically, they might not see the "list" if they expect it.
        // But for UX, if only 1, it's better to go directly.
        // However, the prompt said: "Exacto, muestra una lista... y luego al darle clic..."
        // So I will show the list even for one, or maybe redirect if 1?
        // Let's show list for consistency.

        return view('livewire.my-children-component')->layout('Dashboard');
    }
}
