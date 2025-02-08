<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Informe;
use Carbon\Carbon;
use Livewire\Component;

class InformeEstudiante extends Component
{
    public $informes, $info, $view, $name, $idEstudiante, $abono, $message, $message2, $total, $nameF, $fecha, $mes = '00';

    public $active = 1, $viewDescuento = 0, $descuent, $totalDescuento, $totalModulos;
    public $filtro = '';
    public $aprendices, $aprendizArray;
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

    public function descuento(Apprentice $aprendiz)
    {
        $this->viewDescuento = 1;
        $this->view = 0;
        $this->vista = 0;
        $this->aprendizArray = $aprendiz;
        $this->nameF = $this->aprendizArray->name;
        $this->descuent = $this->aprendizArray->descuento;
        $this->aprendices = Apprentice::all();
    }

    public function saveDescuento(Apprentice $aprendiz)
    {
        $this->validate([
            'descuent' => 'required|numeric',
        ], [
            'required' => 'Este campo es requerido.',
            'numeric' => 'Escribe el valor sin puntos o coma.'
        ]);

        $totalAbono = 0;
        $valueAprendiz = 0;

        foreach ($aprendiz->informe as $key => $informe) {
            $totalAbono += $informe->abono;
        }


        if ($aprendiz->modality_id != 4) {
            $valueAprendiz = $aprendiz->modality->valor;
        } else {
            $valueAprendiz = $aprendiz->valor;
        }


        $total = $valueAprendiz - $aprendiz->descuento;
        $pendiente = $valueAprendiz - $totalAbono - $this->descuent;

        /* dd('Total Abono: '.$totalAbono, ' Total Apagar: '. $total , ' Total descuento: '. $aprendiz->descuento, ' value: '. $pendiente, 'descuento ingresado ' . $this->descuent); */

        if ($total != $totalAbono) {
            if ($pendiente <= 0) {
                $this->message = "El descuento sobre pasa el valor del modulo";
            } else {
                $aprendiz->descuento = $this->descuent;
                $aprendiz->save();
                $this->viewDescuento = 0;
                $this->message = "";
            }
        } else {

            $this->message = "El estudiante ya ha completado el pago";
        }
    }

    public function ocultar()
    {
        $this->view = 0;
        $this->vista = 0;
        $this->abono = '';
        $this->message = '';
        $this->viewDescuento = 0;
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
        if ($this->fecha == '') {
            $this->message = 'La fecha es requerida';
            return;
        } else {
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

        if ($this->total <= $totalModulo - $aprendiz->descuento) {
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
        $aprendiz->plataforma = 140000;
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
        $aprendiz->descuento = 0;
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
        $query = Informe::query()->with('apprentice.attendant', 'apprentice.modality');

        if (!empty($this->mes) && $this->mes != '00') {
            $query->whereMonth('fecha', intval($this->mes));
        }

        if (!empty($this->filtro)) {
            $query->whereIn('apprentice_id', function ($subQuery) {
                $subQuery->select('id')
                    ->from('apprentices')
                    ->where('name', 'LIKE', '%' . $this->filtro . '%');
            });
        }
        $this->informes = $query->get();

        $this->totalModulos = $this->informes
            ->unique('apprentice_id') 
            ->sum(fn($informe) => optional($informe->apprentice)->valor ?? 0);

        $informesAgrupados = $query->selectRaw('MIN(id) as id, apprentice_id, MIN(abono) as abono')
            ->groupBy('apprentice_id')
            ->get();

        $this->totalDescuento = $informesAgrupados->sum(fn($informe) => optional($informe->apprentice)->descuento ?? 0);

        return view('livewire.informe-estudiante');
    }
}
