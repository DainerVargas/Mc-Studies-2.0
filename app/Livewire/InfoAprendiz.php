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

    public $aprendiz, $image, $grupos, $modalidades, $fechaActual, $user, $edadActualizada, $view, $qualifications;
    public $valor = 0;

    public function mount()
    {
        $this->grupos = Group::all();
        $this->modalidades = Modality::all();
        $fechaNacimiento = new DateTime($this->aprendiz->fecha_nacimiento);
        $hoy = new DateTime();
        $this->edadActualizada = $hoy->diff($fechaNacimiento)->y;
        $this->view = session()->get('view', false);
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

    public function render()
    {
        $this->user = Auth::user();
        $this->qualifications = Qualification::where('apprentice_id', $this->aprendiz->id)->get();

        $this->fechaActual = Carbon::now()->toDateString();
        return view('livewire.info-aprendiz');
    }
}
