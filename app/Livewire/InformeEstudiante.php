<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Informe;
use Carbon\Carbon;
use Livewire\Component;

class InformeEstudiante extends Component
{
    public $informes, $info, $view, $name, $idEstudiante, $abono, $message, $message2, $total;

    public $active = 1;
    public $filtro = '';
    public $aprendices;

    public function mount()
    {
        $this->informes = Informe::all();
        $this->aprendices = Apprentice::all();
    }

    public function activar($value)
    {
        $this->active = $value;
    }

    public function abonar(Apprentice $aprendiz)
    {
        $this->view = 1;
        $this->name = $aprendiz->name . ' ' . $aprendiz->apellido;
        $this->idEstudiante = $aprendiz->id;
    }

    public function ocultar()
    {
        $this->view = 0;
        $this->abono = '';
        $this->message = '';
    }

    public function save(Apprentice $aprendiz)
    {
        $validaciones =  $this->validate([
            'abono' => 'required|numeric',
        ], [
            'required' => 'Este campo es requerido.',
            'numeric' => 'Escribe el valor sin puntos o coma.'
        ]);
        $abonoT = 0;
        $inform = Informe::where('apprentice_id', $aprendiz->id)->get();
        foreach ($inform as $valor) {
            $abonoT += $valor->abono;
        }
        $this->total = $abonoT + $this->abono;
        $totalModulo = $aprendiz->modality->valor + 120000; /* 120k plataforma */
        if ($this->total <= $totalModulo) {
            if ($inform[0]->abono != 0) {
                $informe = Informe::create([
                    'apprentice_id' => $inform[0]->apprentice_id,
                    'abono' => $this->abono,
                    'fecha' => Carbon::now()->toDateString(),
                ]);
            } else {
                $inform[0]->update([
                    'abono' =>  $this->abono,
                    'fecha' => Carbon::now()->toDateString(),
                ]);
            }

            $this->view = 0;
            $this->abono = '';
            $this->message = '';
        } else {
            $this->message = "El abono sobre pasa el valor del modulo";
        }
    }

    public function reseter(Informe $informe)
    {
        $informe->abono = 0;
        $informe->fecha = null;
        $informe->save();
        $this->message2 = '';
    }

    public function eliminar(Informe $informe)
    {

        if (!$informe) {
            $this->message2 = "El informe no existe.";
            return;
        }

        $informCount = Informe::where('apprentice_id', $informe->apprentice_id)->count();

        if ($informCount == 1) {
            $this->message2 = "No se puede eliminar el único informe del aprendiz.";
        } else {
            $informe->delete();
            $this->informes = Informe::all();
        }
    }

    public function render()
    {
        $aprendices = Apprentice::where('name', 'LIKE', '%' . $this->filtro . '%')->get();

        $idsAprendices = $aprendices->pluck('id');

        $this->informes = Informe::whereIn('apprentice_id', $idsAprendices)->get();

        return view('livewire.informe-estudiante');
    }
}
