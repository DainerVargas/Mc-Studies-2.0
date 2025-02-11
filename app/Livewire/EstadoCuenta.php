<?php

namespace App\Livewire;

use App\Models\Informe;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EstadoCuenta extends Component
{
    use WithFileUploads;

    public $aprendiz, $informes;
    public $comprobante, $informeId, $viewComprobante = 0, $urlImage;

    public function mount() {}

    public function updatedComprobante()
    {
        $this->validate([
            'comprobante' => 'image|max:2048',
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

    public function render()
    {
        $this->informes = Informe::where('apprentice_id', $this->aprendiz->id)->get();

        return view('livewire.estado-cuenta');
    }
}
