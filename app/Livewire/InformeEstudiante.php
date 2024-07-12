<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Informe;
use Carbon\Carbon;
use Livewire\Component;

class InformeEstudiante extends Component
{
    public $informes, $info, $view, $name, $idEstudiante, $abono, $message, $message2, $total, $nameF, $fecha;

    public $active = 1;
    public $filtro = '';
    public $aprendices;
    public $vista = 0;

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
        $this->vista = 0;
        $this->name = $aprendiz->name . ' ' . $aprendiz->apellido;
        $this->idEstudiante = $aprendiz->id;
        $this->aprendices = Apprentice::all();
    }

    public function ocultar()
    {
        $this->view = 0;
        $this->vista = 0;
        $this->abono = '';
        $this->message = '';
    }
    public function aumentar(Informe $informe)
    {
        $this->view = 0;
        $this->nameF = $informe->apprentice->name;
        $this->fecha = $informe->fecha;
        $this->idEstudiante = $informe->id;
        $this->vista = 1;

    }

    public function guardar(Informe $informe)
    {
        if($this->fecha == ''){
            $this->message = 'La fecha es requerida';
            return;
        }else{
            $informe->fecha = $this->fecha;
            $informe->save();
            $this->vista = 0;
        }
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
        if ($aprendiz->modality->id == 4) {

            $totalModulo = $aprendiz->valor;
        } else {
            $totalModulo = $aprendiz->modality->valor;
        }

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

    public function plataforma(Apprentice $aprendiz)
    {

        $aprendiz->plataforma = 120000;
        $aprendiz->save();
        $this->informes = Informe::all();
        $this->aprendices = Apprentice::all();
    }

    public function reseter(Informe $informe, Apprentice $aprendiz)
    {
        $informe->abono = 0;
        $informe->fecha = null;
        $informe->save();
        $aprendiz->plataforma = null;
        $aprendiz->save();
        $this->message2 = '';
        $this->aprendices = Apprentice::all();
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
        $this->aprendices = Apprentice::all();
    }

    public function render()
    {
        $aprendices = Apprentice::where('name', 'LIKE', '%' . $this->filtro . '%')->get();

        $idsAprendices = $aprendices->pluck('id');

        $this->informes = Informe::whereIn('apprentice_id', $idsAprendices)->get();

        return view('livewire.informe-estudiante');
    }
}
