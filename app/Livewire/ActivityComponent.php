<?php

namespace App\Livewire;

use App\Models\AcademicActivity;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ActivityComponent extends Component
{
    use WithFileUploads;

    public $limit = 15; // Initial limit
    public $totalActivitiesCount = 0; // To track if there are more
    public $titulo, $descripcion, $archivo, $apprentice_id;
    public $confirmingActivityCreation = false;
    public $confirmingActivityAssignment = false; // New modal for staff
    public $children;
    public $groups; // For filtering and assignment
    public $filterChild = null;
    public $filterGroup = null; // New Group Filter
    public $search = ''; // Search Filter
    public $showAssigned = false; // Toggle for parents: Historial vs Asignadas

    // Properties for assignment form
    public $assign_titulo, $assign_descripcion, $assign_archivo;
    public $assign_groups = []; // Array of selected group IDs

    protected $rules = [
        'titulo' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'archivo' => 'nullable|file|mimes:pdf,mp4,mov,avi,wmv|max:1048576', // 1GB Max
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

        // Load groups for filtering and assignment (Gerente, Secretaria, Asistente, Profesor)
        if (in_array((int)$user->rol_id, [1, 2, 3, 4])) {
            $this->groups = \App\Models\Group::all();
            if ($this->children->isEmpty()) {
                $this->children = \App\Models\Apprentice::all();
            }
        } elseif ($user->attendant) {
            // For parents, only groups their children are in
            $groupIds = $user->attendant->apprentice->pluck('group_id')->filter()->unique();
            $this->groups = \App\Models\Group::whereIn('id', $groupIds)->get();
        }
    }

    public function updatedFilterGroup($value)
    {
        $user = Auth::user();
        if (in_array((int)$user->rol_id, [1, 2, 3, 4])) {
            if ($value) {
                $this->children = \App\Models\Apprentice::where('group_id', $value)->get();
            } else {
                $this->children = \App\Models\Apprentice::all();
            }
            $this->filterChild = null; // Reset child filter when group changes
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
        $assignedActivities = collect();

        if ($user->attendant) {
            // "Realizadas" (Self-uploaded)
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

            // "Asignadas" (Assigned by staff to their children's groups)
            $assignedQuery = \App\Models\AssignedActivity::orderBy('created_at', 'desc');

            if ($this->filterChild) {
                $apprentice = \App\Models\Apprentice::find($this->filterChild);
                if ($apprentice && $apprentice->group_id) {
                    $groupId = $apprentice->group_id;
                    $assignedQuery->whereHas('groups', function ($q) use ($groupId) {
                        $q->where('groups.id', $groupId);
                    })->with(['groups' => function ($q) use ($groupId) {
                        $q->where('groups.id', $groupId);
                    }]);
                } else {
                    $assignedQuery->whereRaw('1 = 0'); // No group, no activities
                }
            } else {
                $childGroupIds = $user->attendant->apprentice->pluck('group_id')->filter()->unique()->toArray();
                $assignedQuery->whereHas('groups', function ($q) use ($childGroupIds) {
                    $q->whereIn('groups.id', $childGroupIds);
                })->with(['groups' => function ($q) use ($childGroupIds) {
                    $q->whereIn('groups.id', $childGroupIds);
                }]);
            }

            if ($this->search) {
                $assignedQuery->where('titulo', 'like', '%' . $this->search . '%');
            }

            $assignedActivities = $assignedQuery->get();
        } else {
            // Staff view
            $query = AcademicActivity::with(['apprentice', 'attendant'])
                ->orderBy('created_at', 'desc');

            if ($this->filterGroup) {
                $query->whereHas('apprentice', function ($q) {
                    $q->where('group_id', $this->filterGroup);
                });
            }

            if ($this->filterChild) {
                $query->where('apprentice_id', $this->filterChild);
            }

            if ($this->search) {
                $query->where('titulo', 'like', '%' . $this->search . '%');
            }

            $this->totalActivitiesCount = $query->count();
            $activities = $query->take($this->limit)->get();

            // Staff seeing their assigned activities history refined by group/search
            $assignedQuery = \App\Models\AssignedActivity::with('groups')
                ->orderBy('created_at', 'desc');

            if ($this->filterGroup) {
                $assignedQuery->whereHas('groups', function ($q) {
                    $q->where('groups.id', $this->filterGroup);
                });
            }

            if ($this->search) {
                $assignedQuery->where('titulo', 'like', '%' . $this->search . '%');
            }

            $assignedActivities = $assignedQuery->get();
        }

        return view('livewire.activity-component', [
            'activities' => $activities,
            'assignedActivities' => $assignedActivities,
        ])->layout('Dashboard');
    }

    public function createActivity()
    {
        $this->reset(['titulo', 'descripcion', 'archivo', 'apprentice_id']);
        $this->confirmingActivityCreation = true;
    }

    public function openAssignModal()
    {
        $this->reset(['assign_titulo', 'assign_descripcion', 'assign_archivo', 'assign_groups']);
        $this->confirmingActivityAssignment = true;
    }

    public function saveActivity()
    {
        $this->validate();

        $user = Auth::user();
        $apprentice = \App\Models\Apprentice::find($this->apprentice_id);

        $filePath = null;
        if ($this->archivo) {
            $filePath = $this->archivo->store('activities_docs', 'public');
        }

        AcademicActivity::create([
            'attendant_id' => $apprentice->attendant_id ?? null,
            'apprentice_id' => $this->apprentice_id,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'fecha' => now(),
            'archivo' => $filePath,
        ]);

        $this->confirmingActivityCreation = false;
        $this->reset(['titulo', 'descripcion', 'archivo', 'apprentice_id']);
        $this->dispatch('success', 'Actividad registrada correctamente.');
    }

    public function saveAssignedActivity()
    {
        $this->validate([
            'assign_titulo' => 'required|string|max:255',
            'assign_groups' => 'required|array|min:1',
            'assign_descripcion' => 'nullable|string',
            'assign_archivo' => 'nullable|file|mimes:pdf,mp4,mov,avi,wmv|max:1048576',
        ]);

        $filePath = null;
        if ($this->assign_archivo) {
            $filePath = $this->assign_archivo->store('assigned_docs', 'public');
        }

        $activity = \App\Models\AssignedActivity::create([
            'titulo' => $this->assign_titulo,
            'descripcion' => $this->assign_descripcion,
            'archivo' => $filePath,
            'user_id' => Auth::id(),
        ]);

        $activity->groups()->sync($this->assign_groups);

        $this->confirmingActivityAssignment = false;
        $this->reset(['assign_titulo', 'assign_descripcion', 'assign_archivo', 'assign_groups']);
        $this->dispatch('success', 'Actividad asignada correctamente.');
    }

    public function deleteActivity($id)
    {
        $activity = AcademicActivity::find($id);

        if (!$activity) {
            $this->dispatch('error', 'Actividad no encontrada.');
            return;
        }

        $user = Auth::user();

        // Permissions logic
        $isAdmin = (int)$user->rol_id === 1;
        $isStaff = in_array((int)$user->rol_id, [2, 3]);
        // Allow owner (attendant) to delete own activity
        $isOwner = $user->attendant && $activity->attendant_id == $user->attendant->id;

        if (!$isAdmin && !$isStaff && !$isOwner) {
            $this->dispatch('error', 'No tienes permisos para eliminar.');
            return;
        }

        // Time Validation (10 minutes) - Exempt Admin
        if (!$isAdmin) {
            if ($activity->created_at->diffInMinutes(now()) > 10) {
                $this->dispatch('error', 'El tiempo para eliminar esta actividad ha expirado.');
                return;
            }
        }

        if ($activity->archivo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($activity->archivo);
        }

        $activity->delete();
        $this->dispatch('success', 'Actividad eliminada.');
    }
}
