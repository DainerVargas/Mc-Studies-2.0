<?php

namespace App\Livewire;

use App\Services\ActivityLogService;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Group;
use App\Models\AssignedActivity;
use Illuminate\Support\Facades\Auth;

class AssignActivityModal extends Component
{
    use WithFileUploads;

    public $confirmingActivityAssignment = false;
    public $isEdit = false;
    public $activityId;
    public $assign_titulo, $assign_descripcion, $assign_archivo;
    public $assign_groups = [];
    public $groups = [];

    public function mount()
    {
        $this->groups = Group::all();
    }

    public function openAssignModal()
    {
        $this->reset(['assign_titulo', 'assign_descripcion', 'assign_archivo', 'assign_groups', 'isEdit', 'activityId']);
        $this->confirmingActivityAssignment = true;
    }

    #[\Livewire\Attributes\On('editActivity')]
    public function editActivity($id)
    {
        $this->reset(['assign_titulo', 'assign_descripcion', 'assign_archivo', 'assign_groups']);
        $this->activityId = $id;
        $this->isEdit = true;

        $activity = AssignedActivity::with('groups')->findOrFail($id);
        $this->assign_titulo = $activity->titulo;
        $this->assign_descripcion = $activity->descripcion;
        $this->assign_groups = $activity->groups->pluck('id')->toArray();

        $this->confirmingActivityAssignment = true;
    }

    public function saveAssignedActivity()
    {
        $this->validate([
            'assign_titulo' => 'required|string|max:255',
            'assign_groups' => 'required|array|min:1',
            'assign_descripcion' => 'nullable|string',
            'assign_archivo' => 'nullable|' . ($this->isEdit ? '' : 'file|max:10240'),
        ]);

        $filePath = null;
        if ($this->assign_archivo instanceof \Illuminate\Http\UploadedFile) {
            $filePath = $this->assign_archivo->store('assigned_docs', 'public');
        }

        if ($this->isEdit) {
            $activity = AssignedActivity::findOrFail($this->activityId);
            $oldValues = $activity->toArray();

            $data = [
                'titulo' => $this->assign_titulo,
                'descripcion' => $this->assign_descripcion,
            ];

            if ($filePath) {
                $data['archivo'] = $filePath;
            }

            $activity->update($data);
            $activity->groups()->sync($this->assign_groups);

            $action = 'EDITAR';
            $description = "Se editó la actividad '{$activity->titulo}'";
        } else {
            $activity = AssignedActivity::create([
                'titulo' => $this->assign_titulo,
                'descripcion' => $this->assign_descripcion,
                'archivo' => $filePath,
                'user_id' => Auth::id(),
            ]);

            $activity->groups()->sync($this->assign_groups);
            $oldValues = null;
            $action = 'CREAR';
            $groupNames = Group::whereIn('id', $this->assign_groups)->pluck('name')->implode(', ');
            $description = "Se asignó la actividad '{$activity->titulo}' a los grupos: {$groupNames}";
        }

        ActivityLogService::log(
            $action,
            'Actividad',
            $description,
            $activity->id,
            $oldValues,
            $activity->toArray()
        );


        $this->confirmingActivityAssignment = false;
        $this->reset(['assign_titulo', 'assign_descripcion', 'assign_archivo', 'assign_groups', 'isEdit', 'activityId']);

        $this->dispatch('success', $this->isEdit ? 'Actividad actualizada correctamente.' : 'Actividad asignada correctamente.');
        $this->dispatch('activityAssigned');
    }

    public function render()
    {
        return view('livewire.assign-activity-modal');
    }
}
