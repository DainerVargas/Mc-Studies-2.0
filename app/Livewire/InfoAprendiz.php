<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Attendant;
use App\Models\Group;
use App\Models\Level;
use App\Models\Modality;
use App\Models\Qualification;
use App\Models\Teacher;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class InfoAprendiz extends Component
{
    use WithFileUploads;

    public $aprendiz, $image, $grupos, $modalidades, $fechaActual, $user, $edadActualizada, $view, $qualifications, $viewCertificate, $textReconocimiento;
    public $valor = 0;

    public function mount()
    {
        $this->grupos = Group::all();
        $this->modalidades = Modality::all();
        $fechaNacimiento = new DateTime($this->aprendiz->fecha_nacimiento);
        $hoy = new DateTime();
        $this->edadActualizada = $hoy->diff($fechaNacimiento)->y;
        $this->view = session()->get('view', false);
        $this->viewCertificate = session()->get('viewCertificate', false);

        session()->forget('aprendiz');
        session()->forget('qualifications');
    }

    public function toggleEstado(Apprentice $aprendiz)
    {
        $aprendiz->estado = !$aprendiz->estado;

        if ($aprendiz->estado) {
            $aprendiz->fecha_inicio = date('y-m-d');
            switch ($aprendiz->modality_id) {
                case 1:
                    $fechaFin = Carbon::now()->addMonths(1)->toDateString();
                    $aprendiz->fecha_fin = $fechaFin;
                    break;
                case 2:
                    $fechaFin = Carbon::now()->addMonths(2)->toDateString();
                    $aprendiz->fecha_fin = $fechaFin;
                    break;
                case 3:
                    $fechaFin = Carbon::now()->addMonths(4)->toDateString();
                    $aprendiz->fecha_fin = $fechaFin;
                    break;
            }
        }

        $aprendiz->save();
        $this->aprendiz = $aprendiz;
    }

    public function show($value)
    {
        $this->valor = $value;
    }

    public function showQualification()
    {
        $this->view = !$this->view;
        session()->put('view', $this->view);
    }

    public function showCertificate()
    {
        $this->viewCertificate = !$this->viewCertificate;
        session()->put('viewCertificate', $this->viewCertificate);
        $this->textReconocimiento = '';
    }

    public function generateCertificate($aprendiz)
    {

        $this->validate([
            'textReconocimiento' => 'required|string|max:500',
        ], [
            'textReconocimiento.required' => 'El campo de texto es obligatorio.',
            'textReconocimiento.string' => 'El campo de texto debe ser una cadena de caracteres.',
            'textReconocimiento.max' => 'El campo de texto no debe exceder los 500 caracteres.',
        ]);

        session()->put('textReconocimiento', $this->textReconocimiento);
        return redirect()->route('certificado', compact('aprendiz'));
    }

    public function donwloadQualification()
    {
        session()->put('qualifications', $this->qualifications);

        return redirect()->route('donwloadQualification');
    }

    public function sendQualification()
    {

        session()->put('qualifications', $this->qualifications);
        session()->put('aprendiz', $this->aprendiz);

        return redirect()->route('donwloadQualification');
    }

    public function render()
    {
        $this->user = Auth::user();
        $this->qualifications = Qualification::where('apprentice_id', $this->aprendiz->id)->get();

        $this->fechaActual = Carbon::now()->toDateString();
        return view('livewire.info-aprendiz');
    }
}
