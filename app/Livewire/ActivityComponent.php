<?php

namespace App\Livewire;

use App\Models\AcademicActivity;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ActivityComponent extends Component
{
    // use WithPagination; // Removed pagination

    public $limit = 15; // Initial limit
    public $totalActivitiesCount = 0; // To track if there are more
    public $titulo, $descripcion, $archivo, $apprentice_id;
    public $confirmingActivityCreation = false;
    public $children;
    public $filterChild = null;
    public $search = ''; // Search Filter

    protected $rules = [
        'titulo' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'archivo' => 'nullable|file|max:10240', // 10MB Max
        'apprentice_id' => 'required|exists:apprentices,id',
    ];

    public function updatingSearch()
    {
        $this->limit = 15; // Reset limit on search
    }

    public function mount()
    {
        $user = Auth::user();
        if ($user->attendant) {
            $this->children = $user->attendant->apprentice;
        } else {
            $this->children = collect();
        }
    }

    public function loadMore()
    {
        $this->limit += 15;
    }

    public function render()
    {
        $user = Auth::user();
        $activities = collect();

        if ($user->attendant) {
            $query = AcademicActivity::where('attendant_id', $user->attendant->id)
                ->with('apprentice')
                ->orderBy('created_at', 'desc');

            if ($this->filterChild) {
                $query->where('apprentice_id', $this->filterChild);
            }

            if ($this->search) {
                $query->where('titulo', 'like', '%' . $this->search . '%');
            }

            $this->totalActivitiesCount = $query->count();
            $activities = $query->take($this->limit)->get();
        }

        return view('livewire.activity-component', [
            'activities' => $activities
        ])->layout('Dashboard');
    }

    public function createActivity()
    {
        $this->reset(['titulo', 'descripcion', 'archivo', 'apprentice_id']);
        $this->confirmingActivityCreation = true;
    }

    public function saveActivity()
    {
        $this->validate();

        $user = Auth::user();
        if ($user->attendant) {
            $filePath = null;
            if ($this->archivo) {
                $filePath = $this->archivo->store('activities_docs', 'public');
            }

            AcademicActivity::create([
                'attendant_id' => $user->attendant->id,
                'apprentice_id' => $this->apprentice_id,
                'titulo' => $this->titulo,
                'descripcion' => $this->descripcion,
                'fecha' => now(), // Automatically set to current date and time
                'archivo' => $filePath,
            ]);
        }

        $this->confirmingActivityCreation = false;
        $this->reset(['titulo', 'descripcion', 'archivo', 'apprentice_id']);
    }

    public function deleteActivity($id)
    {
        if (Auth::user()->rol_id != 1) {
            $this->dispatch('error', 'No tienes permisos para eliminar.');
            return;
        }
        $activity = AcademicActivity::findOrFail($id);

        // Time check: allow deletion only within 10 minutes
        if ($activity->created_at->diffInMinutes(now()) > 10) {
            session()->flash('error', 'El tiempo para eliminar esta actividad ha expirado.');
            return;
        }

        if ($activity->archivo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($activity->archivo);
        }

        $activity->delete();
    }
}
