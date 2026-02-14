<?php

namespace App\Livewire;

use App\Models\Reunion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReunionComponent extends Component
{
    public $meetings;
    public $titulo, $descripcion, $fecha_programada, $hora_seleccionada;
    public $confirmingMeetingCreation = false;
    public $filterStatus = ''; // New filter property

    protected $rules = [
        'titulo' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'fecha_programada' => 'required|date|after_or_equal:today',
        'hora_seleccionada' => 'required',
    ];

    public function isTimeSlotTaken($time)
    {
        if (!$this->fecha_programada) {
            return false;
        }

        $fullDateTime = $this->fecha_programada . ' ' . $time . ':00';
        return Reunion::where('fecha_programada', $fullDateTime)->exists();
    }

    public function render()
    {
        $user = Auth::user();

        $query = Reunion::query();

        if ($user->attendant) {
            $query->where('attendant_id', $user->attendant->id);
        } else {
            $query->with('attendant');
        }

        if ($this->filterStatus) {
            $query->where('estado', $this->filterStatus);
        }

        $this->meetings = $query->orderBy('fecha_programada', 'desc')->get();

        return view('livewire.reunion-component')->layout('Dashboard');
    }

    public function createMeeting()
    {
        $this->reset(['titulo', 'descripcion', 'fecha_programada', 'hora_seleccionada']);
        $this->confirmingMeetingCreation = true;
    }

    public function saveMeeting()
    {
        $this->validate();

        $user = Auth::user();
        if ($user->attendant) {
            // Combine Date and Time
            $fullDateTime = $this->fecha_programada . ' ' . $this->hora_seleccionada . ':00';

            // Check for conflict: Same Date + Same Time
            $exists = Reunion::where('fecha_programada', $fullDateTime)->exists();
            if ($exists) {
                $this->addError('hora_seleccionada', 'Esta hora ya está ocupada para la fecha seleccionada.');
                return;
            }

            Reunion::create([
                'attendant_id' => $user->attendant->id,
                'titulo' => $this->titulo,
                'descripcion' => $this->descripcion,
                'fecha_programada' => $fullDateTime,
                'estado' => 'pendiente',
            ]);

            session()->flash('new_meeting', true);
        }

        $this->confirmingMeetingCreation = false;
        $this->reset(['titulo', 'descripcion', 'fecha_programada', 'hora_seleccionada']);
    }

    public function updateStatus($id, $status)
    {
        $meeting = Reunion::findOrFail($id);
        $meeting->update(['estado' => $status]);

        session()->flash('status_updated', true);
    }

    public function updateLink($id, $link)
    {
        $meeting = Reunion::findOrFail($id);
        $meeting->update(['link_reunion' => $link]);

        session()->flash('status_updated', true);
    }
}
