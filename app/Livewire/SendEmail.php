<?php

namespace App\Livewire;

use App\Mail\SendMail;
use App\Models\Apprentice;
use App\Models\Group;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class SendEmail extends Component
{
    use  WithFileUploads;

    public $search = '';
    public $group = 'all';
    public $asunto, $text, $message, $documento;
    public $selectEstudents = [];
    public $hidden = false;
    public $hidden2 = false;

    public function mount()
    {
        // No need to load all students here if we do it in render
    }

    public function active()
    {
        $this->hidden = !$this->hidden;
    }

    public function show()
    {
        $this->hidden2 = !$this->hidden2;
    }

    public function save()
    {
        $this->validate(['message' => 'required|string']);
        Message::create(['message' => $this->message]);
        $this->reset('message');
    }

    public function delete(Message $message)
    {
        if (Auth::user()->rol_id != 1) {
            $this->dispatch('error', 'No tienes permisos para eliminar.');
            return;
        }
        $message->delete();
    }

    public function selectStudent($id)
    {
        $id = (int) $id;
        if (in_array($id, $this->selectEstudents, true)) {
            $this->selectEstudents = array_values(array_diff($this->selectEstudents, [$id]));
        } else {
            $this->selectEstudents[] = $id;
        }
        $this->syncSelects();
    }

    public function removeStudent($id)
    {
        $id = (int) $id;
        $this->selectEstudents = array_values(array_diff($this->selectEstudents, [$id]));
        $this->syncSelects();
    }

    public function selectAll()
    {
        $currentIds = $this->getCurrentStudents()->pluck('id')->map(fn($id) => (int)$id)->toArray();
        $selectedInCurrent = array_intersect($this->selectEstudents, $currentIds);

        if (count($selectedInCurrent) === count($currentIds) && count($currentIds) > 0) {
            // Unselect all VISIBLE
            $this->selectEstudents = array_values(array_diff($this->selectEstudents, $currentIds));
        } else {
            // Select all VISIBLE
            $this->selectEstudents = array_values(array_unique(array_merge($this->selectEstudents, $currentIds)));
        }
        $this->syncSelects();
    }

    protected function syncSelects()
    {
        $this->selectEstudents = array_values(array_unique(array_map('intval', $this->selectEstudents)));
    }

    protected function getCurrentStudents()
    {
        $query = Apprentice::query();
        if ($this->group !== 'all') {
            $query->where('group_id', $this->group);
        }
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('apellido', 'like', "%{$this->search}%");
            });
        }
        return $query->get();
    }

    public function send()
    {
        $this->validate([
            'asunto' => 'required|string',
            'text' => 'required|string',
            'selectEstudents' => 'required|array|min:1'
        ]);

        $documentPath = $this->documento ? $this->documento->store('emails', 'public') : null;
        $estudiantes = Apprentice::whereIn('id', $this->selectEstudents)->get();

        foreach ($estudiantes as $estudiant) {
            try {
                $email = $estudiant->email ?? optional($estudiant->attendant)->email;
                if ($email) {
                    Mail::to($email)->send(new SendMail($this->asunto, $this->text, $documentPath));
                }
            } catch (\Exception $e) {
                // Log error
            }
        }

        session()->flash('success', 'Correos enviados satisfactoriamente.');
        return redirect()->route('sendEmail');
    }

    public function render()
    {
        $estudiantes = $this->getCurrentStudents();
        
        // Ensure we load the latest selected info
        $selectedStudentsInfo = Apprentice::whereIn('id', $this->selectEstudents)->get();

        $currentIds = $estudiantes->pluck('id')->map(fn($id) => (int)$id)->toArray();
        $allSelectedInView = count($currentIds) > 0 && count(array_intersect($this->selectEstudents, $currentIds)) === count($currentIds);

        return view('livewire.send-email', [
            'estudiantes' => $estudiantes,
            'selectedStudentsInfo' => $selectedStudentsInfo,
            'allSelectedInView' => $allSelectedInView,
            'groups' => Group::all(),
            'messages' => Message::all(),
        ]);
    }
}
