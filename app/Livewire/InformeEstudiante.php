<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Informe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Livewire\Component;

class InformeEstudiante extends Component
{
    public $informes, $info, $view, $name, $idEstudiante, $abono, $message, $message2, $total, $nameF, $fecha, $mes = '00';

    public $active = 1, $viewDescuento = 0, $descuent, $totalDescuento, $totalPendiente, $totalModulos, $observaciones = [], $viewplataforma = 0, $fechaPlataforma;
    public $filtro = '';
    public $aprendices, $aprendizArray;
    public $vista = 0;
    public $year = 0;

    public function mount()
    {
        $this->observaciones = Apprentice::pluck('observacion', 'id')->toArray();

        $this->year = Date::now()->year;
        $this->informes = Informe::where('fechaRegistro', $this->year)->get();
        $this->aprendices = Apprentice::all();
    }
    public function next()
    {
        $this->year += 1;
    }
    public function previous()
    {
        $this->year -= 1;
    }

    public function activePlataforma(Apprentice $aprendiz)
    {
        $this->viewplataforma = 1;
        $this->view = 0;
        $this->vista = 0;
        $this->viewDescuento = 0;
        $this->name = $aprendiz->name . ' ' . $aprendiz->apellido;
        $this->idEstudiante = $aprendiz->id;
        $this->fechaPlataforma = $aprendiz->fechaPlataforma;
        $this->aprendices = Apprentice::all();
    }

    public function savePlataforma(Apprentice $aprendiz)
    {
        if ($this->fechaPlataforma == '') {
            $this->message = 'La fecha es requerida';
            return;
        } else {
            $aprendiz->fechaPlataforma = $this->fechaPlataforma;
            $aprendiz->save();
            $this->viewplataforma = 0;
        }
    }

    public function activar($value)
    {
        $this->active = $value;
    }

    public function abonar(Apprentice $aprendiz)
    {
        $this->view = 1;
        $this->vista = 0;
        $this->viewDescuento = 0;
        $this->viewplataforma = 0;
        $this->name = $aprendiz->name . ' ' . $aprendiz->apellido;
        $this->idEstudiante = $aprendiz->id;
        $this->aprendices = Apprentice::all();
    }

    public function descuento(Apprentice $aprendiz)
    {
        $this->viewDescuento = 1;
        $this->viewplataforma = 0;
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
            if ($pendiente < 0) {
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
        $this->viewplataforma = 0;
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

    public function saveObservacion($id)
    {
        $this->validate([
            "observaciones.$id" => 'required'
        ]);

        $aprendiz = Apprentice::find($id);
        if ($aprendiz) {
            $aprendiz->update([
                'observacion' => $this->observaciones[$id]
            ]);
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

        if ($this->abono != 0) {

            if ($this->total <= $totalModulo - $aprendiz->descuento) {
                if ($inform[0]->abono != 0) {
                    $informe = Informe::create([
                        'apprentice_id' => $inform[0]->apprentice_id,
                        'abono' => $this->abono,
                        'fecha' => Date::now(),
                        'fechaRegistro' => Date::now()->year,
                    ]);
                } else {
                    $inform[0]->update([
                        'abono' =>  $this->abono,
                        'fecha' => Date::now(),
                    ]);
                }

                $this->view = 0;
                $this->abono = '';
                $this->message = '';
            } else {
                $this->message = "El abono sobre pasa el valor del modulo";
            }
        } else {
            $this->message = "El abono debe ser mayor a 0";
        }
    }

    public function plataforma(Apprentice $aprendiz)
    {
        $aprendiz->plataforma = 140000;
        $aprendiz->save();
        $this->informes = Informe::all();
        $this->aprendices = Apprentice::all();
    }

    public function render()
    {
        $query = Informe::query()->with('apprentice.attendant', 'apprentice.modality');

        if (!empty($this->mes) && $this->mes != '00') {
            $query->whereNotNull('fecha')
                ->whereMonth('fecha', intval($this->mes))
                ->whereYear('fechaRegistro', $this->year);
        }

        if (!empty($this->filtro)) {
            $query->whereHas('apprentice', function ($subQuery) {
                $subQuery->where(function ($query) {
                    $query->where('name', 'LIKE', '%' . $this->filtro . '%')
                        ->orWhere('apellido', 'LIKE', '%' . $this->filtro . '%');
                })
                    ->whereNotNull('fechaRegistro')
                    ->whereYear('fechaRegistro', $this->year);
            });
        }

        $informesAgrupados = $query->selectRaw('apprentice_id, SUM(abono) as total_abonos')
            ->groupBy('apprentice_id')
            ->get();

        $this->informes = $query->selectRaw('MIN(id) as id, apprentice_id, MIN(fecha) as fecha')
            ->groupBy('apprentice_id')
            ->with('apprentice')
            ->whereNotNull('fechaRegistro')
            ->whereYear('fechaRegistro', $this->year)
            ->get();

        foreach ($this->informes as $informe) {
            $informe->total_abonos = $informesAgrupados
                ->where('apprentice_id', $informe->apprentice_id)
                ->first()->total_abonos ?? 0;
        }

        $this->totalModulos = $this->informes
            ->sum(fn($informe) => optional($informe->apprentice)->valor ?? 0);

        $this->totalDescuento = $this->informes
            ->sum(fn($informe) => optional($informe->apprentice)->descuento ?? 0);

        $this->totalPendiente = $this->informes
            ->sum(
                fn($informe) => (optional($informe->apprentice)->valor ?? 0)
                    - $informe->total_abonos
                    - (optional($informe->apprentice)->descuento ?? 0)
            );


        return view('livewire.informe-estudiante');
    }
}
