<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\Attendant;
use App\Models\Group;
use App\Models\Modality;
use App\Models\Teacher;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class InfoAprendiz extends Component
{


    use WithFileUploads;


    public $aprendiz, $image, $grupos, $modalidades, $fechaActual;
    public $valor  = 0;

    public function mount()
    {
        $this->grupos = Group::all();
        $this->modalidades = Modality::all();
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

    public function render()
    {
        /* dd(Carbon::now()->toDateString() . ' 00:00:00'); */

        $this->fechaActual = Carbon::now()->toDateString();
        return view('livewire.info-aprendiz');
    }
}



/*  public function save(Apprentice $aprendiz){

        $aprendiz->update([
            'name' => $this->name,
            'apellido' => $this->apellido,
            'edad' => $this->edad,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'modality_id' => $this->modality_id,
            'group_id' => $this->group_id,
        ]);

        $acudiente = Attendant::find($aprendiz->attendant->id);

        $acudiente->update([
            'name' => $this->nameAcudiente,
            'apellido' => $this->apellidoAcudiente,
            'email' => $this->email,
            'telefono' => $this->telefono,
        ]);

    } */