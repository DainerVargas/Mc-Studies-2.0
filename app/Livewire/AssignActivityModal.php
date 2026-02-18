<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Group;
use App\Models\AssignedActivity;
use Illuminate\Support\Facades\Auth;

class AssignActivityModal extends Component
{
    use WithFileUploads;

    public $confirmingActivityAssignment = false;
    public $assign_titulo, $assign_descripcion, $assign_archivo;
    public $assign_groups = [];
    public $groups = [];

    public function mount()
    {
        $this->groups = Group::all();
    }

    public function openAssignModal()
    {
        $this->reset(['assign_titulo', 'assign_descripcion', 'assign_archivo', 'assign_groups']);
        $this->confirmingActivityAssignment = true;
    }

    public function saveAssignedActivity()
    {
        $this->validate([
            'assign_titulo' => 'required|string|max:255',
            'assign_groups' => 'required|array|min:1',
            'assign_descripcion' => 'nullable|string',
            'assign_archivo' => 'nullable|file|max:10240',
        ]);

        $filePath = null;
        if ($this->assign_archivo) {
            $filePath = $this->assign_archivo->store('assigned_docs', 'public');
        }

        $activity = AssignedActivity::create([
            'titulo' => $this->assign_titulo,
            'descripcion' => $this->assign_descripcion,
            'archivo' => $filePath,
            'user_id' => Auth::id(),
        ]);

        $activity->groups()->sync($this->assign_groups);

        // Get Group Names for logging
        $groupNames = Group::whereIn('id', $this->assign_groups)->pluck('name')->implode(', ');

        // Log the deletion
        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'user_role' => Auth::user()->rol->name ?? 'Usuario',
            'action_type' => 'CREAR',
            'entity_type' => 'Actividad',
            'entity_id' => $activity->id,
            'description' => "Se asignó la actividad '{$activity->titulo}' a los grupos: {$groupNames}",
            'new_values' => $activity->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $this->confirmingActivityAssignment = false;
        $this->reset(['assign_titulo', 'assign_descripcion', 'assign_archivo', 'assign_groups']);

        $this->dispatch('success', 'Actividad asignada correctamente a los grupos seleccionados.');
        $this->dispatch('activityAssigned'); // Refresh other components if needed
    }

    public function render()
    {
        return view('livewire.assign-activity-modal');
    }
}
