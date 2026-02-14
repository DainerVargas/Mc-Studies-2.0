<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Informe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EstadoCuenta extends Component
{
    use WithFileUploads;

    public $aprendiz, $informes;
    public $comprobante, $informeId, $viewComprobante = 0, $urlImage;

    public $message2, $aprendices, $count;

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
        $user = Auth::user();

        if ($user->rol_id == 1) {
            $informe->abono = 0;
            $informe->urlImage = null;
            $informe->save();
        } else {
            $this->message2 = 'No existe este informe o  no estas autorizado para restablecer este informe';
        }
        $this->aprendices = Apprentice::all();
    }

    public function eliminar(Informe $informe)
    {
        if (Auth::user()->rol_id != 1) {
            $this->message2 = "No tienes permisos para eliminar este registro.";
            return;
        }

        if (!$informe) {
            $this->message2 = "El informe no existe.";
            return;
        }

        $informCount = Informe::where('apprentice_id', $informe->apprentice_id)->count();

        if ($informCount == 1) {
            $this->message2 = "No se puede eliminar el único informe del aprendiz.";
        } else {
            $informe->delete();
            $this->informes = Informe::where('apprentice_id', $this->aprendiz->id)->get();
        }
    }

    public function render()
    {
        $this->informes = Informe::where('apprentice_id', $this->aprendiz->id)->get();

        $year = Date::now()->year;

        $this->count = $this->informes->where('fechaRegistro', $year)->count();

        $user = Auth::user();

        return view('livewire.estado-cuenta', ['user' => $user]);
    }
}
