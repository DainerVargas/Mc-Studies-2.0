<?php

namespace App\Livewire;

use App\Models\AcademicActivity;
use Livewire\Component;
use Livewire\Attributes\On;

class AcademicFeedbackModal extends Component
{
    public $isOpen = false;
    public $activityId;
    public $comentario;
    public $calificacion;
    public $activityTitle;

    #[On('openFeedbackModal')]
    public function openModal($id)
    {
        $this->activityId = $id;
        $activity = AcademicActivity::findOrFail($id);
        $this->activityTitle = $activity->titulo;
        $this->comentario = $activity->comentario;
        $this->calificacion = $activity->calificacion;
        $this->isOpen = true;
    }

    public function saveFeedback()
    {
        $this->validate([
            'comentario' => 'required|string|max:1000',
            'calificacion' => 'required|string|max:50',
        ]);

        $activity = AcademicActivity::with('apprentice.attendant')->findOrFail($this->activityId);
        $activity->update([
            'comentario' => $this->comentario,
            'calificacion' => $this->calificacion,
        ]);

        // Enviar Correo Electrónico al estudiante o acudiente
        $estudiante = $activity->apprentice;
        $emailRecipient = $estudiante->email ?? optional($estudiante->attendant)->email;

        if ($emailRecipient) {
            \Illuminate\Support\Facades\Mail::to($emailRecipient)->send(
                new \App\Mail\ActivityFeedbackMail($activity, $estudiante->name)
            );
        }

        $this->isOpen = false;
        $this->dispatch('success', 'Comentario y calificación guardados correctamente.');
        $this->dispatch('feedbackUpdated'); // To refresh the table if needed
    }

    public function render()
    {
        return view('livewire.academic-feedback-modal');
    }
}
