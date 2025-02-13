<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Informe;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EstadoCuenta extends Component
{
    use WithFileUploads;

    public $aprendiz, $informes;
    public $comprobante, $informeId, $viewComprobante = 0, $urlImage;

    public $message2, $aprendices;

    public function mount() {}

    public function updatedComprobante()
    {
        $this->validate([
            'comprobante' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $filePath = $this->comprobante->store('comprobantes', 'public');

        $informe = Informe::find($this->informeId);
        if ($informe) {
            $informe->urlImage = $filePath;
            $informe->save();
        }

        $this->comprobante = null;
        $this->informeId = null;

        session()->flash('message', 'Comprobante guardado con éxito.');
    }

    public function setInformeId($id)
    {
        $this->informeId = $id;
    }

    public function show($id)
    {
        $informe = Informe::find($id);

        if ($informe) {
            $this->viewComprobante = 1;
            $this->urlImage = $informe->urlImage;
        }
    }

    public function close()
    {
        $this->viewComprobante = 0;
    }

    public function reseter(Informe $informe, Apprentice $aprendiz)
    {

        if ($informe) {

            $informe->abono = 0;
            $informe->fecha = null;
            $informe->urlImage = null;
            $informe->save();

            $aprendiz->descuento = 0;
            $aprendiz->save();
        } else {
            $this->message2 = 'No existe este informe';
        }
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
    }

    public function render()
    {
        $this->informes = Informe::where('apprentice_id', $this->aprendiz->id)->get();

        return view('livewire.estado-cuenta');
    }
}
