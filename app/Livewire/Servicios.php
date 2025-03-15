<?php

namespace App\Livewire;

use App\Models\Service;
use App\Models\typeService;
use Livewire\Component;

class Servicios extends Component
{
    public $showS = false, $showC = false;
    public $type = 'null', $nameService = '', $services, $typeService, $nameCategory, $name, $valor, $fecha, $type_service_id, $showU, $service_id;

    public function mount()
    {
        $this->fecha = now()->format('Y-m-d');
        $this->services = Service::all();
        $this->typeService = typeService::all();
    }

    public function showService()
    {
        $this->showS = true;
        $this->showC = false;
        $this->showU = false;
    }

    public function close()
    {
        $this->showS = false;
        $this->showC = false;
        $this->showU = false;
        $this->reset(['name', 'valor', 'type_service_id']);
    }
    public function showCategory()
    {
        $this->showS = false;
        $this->showU = false;
        $this->showC = true;
    }
    public function showUpdate(Service $servicio)
    {
        $this->showS = false;
        $this->showU = true;
        $this->showC = false;

        $this->service_id = $servicio->id;
        $this->name = $servicio->name;
        $this->valor = $servicio->valor;
        $this->fecha = $servicio->fecha;
        $this->type_service_id = $servicio->type_service_id;
    }

    public function updateService(Service $servicio){
        $validate = $this->validate(
            [
                'name' => 'required',
                'valor' => 'required|numeric',
                'fecha' => 'required',
                'type_service_id' => 'required|integer',
            ],
            [
                'required' => 'Este campo es requerido',
                'numeric' => 'Ingresa solo números',
                'integer' => 'Debe ser un número entero',
            ]
        );

        if ($validate) {
            $servicio->update($validate);
            $this->services = Service::all();

            $this->reset(['name', 'valor', 'type_service_id']);
            $this->showS = false;
            $this->showC = false;
            $this->showU = false;
            $this->service_id = '';
        }

    }

    public function saveService()
    {
        /* $this->type_service_id = (int) $this->type_service_id; */

        $validate = $this->validate(
            [
                'name' => 'required',
                'valor' => 'required|numeric',
                'fecha' => 'required',
                'type_service_id' => 'required|integer',
            ],
            [
                'required' => 'Este campo es requerido',
                'numeric' => 'Ingresa solo números',
                'integer' => 'Debe ser un número entero',
            ]
        );

        if ($validate) {
            Service::create($validate);
            $this->services = Service::all();

            $this->reset(['name', 'valor', 'type_service_id']);
            $this->showS = false;
            $this->showC = false;
        }
    }

    public function saveCategory()
    {
        $validate = $this->validate([
            'name' => 'required'
        ]);

        if ($validate) {
            typeService::create($validate);
            $this->typeService = typeService::all();
            $this->reset(['name']);
            $this->showS = false;
            $this->showC = false;
        }
    }

    public function delete(Service $service)
    {
        $service->delete();
        $this->services = Service::all();
    }

    public function render()
    {

        $query = Service::query();
        if ($this->nameService != '') {
            $query->where('name', 'LIKE', '%' . $this->nameService . '%')
                ->orWhere('fecha', 'LIKE', '%' . $this->nameService . '%');
        }

        if ($this->type != 'null') {
            $query->where('type_service_id', '=', $this->type);
        }

        $this->services = $query->get();

        return view('livewire.servicios');
    }
}
