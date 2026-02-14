<?php

namespace App\Livewire;

use App\Models\Apprentice;
use App\Models\MetodoPago;
use App\Models\Pago;
use App\Models\Service;
use App\Models\typeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Servicios extends Component
{
    use WithFileUploads;

    public $showServiceModal = false, $showCategoryModal = false, $showPayModal = false, $show = 1;
    public $type = 'null', $nameService = '', $nameEstudiante = '', $services, $typeService, $nameCategory, $name, $valor, $fecha, $type_service_id = null, $date = '', $pay_id = '';
    public $comprobante, $service_id, $metodoPagos, $pagos, $metodo = '', $dinero = '', $dateInicio = '', $dateFinal = '', $estudents, $search = '', $idEstudentCreate, $dateCreate, $montoCreate, $dineroCreate, $metodoCreate, $saldoCaja = 0, $year, $year2;

    public function mount()
    {
        $this->fecha = now()->format('Y-m-d');
        $this->services = Service::all();
        $this->typeService = typeService::all();
        $this->pagos = Pago::whereYear('created_at', date('Y'))->get();
        $this->saldoCaja = Pago::where('dinero', 'Ingresado')->sum('monto') - Pago::where('dinero', 'Egresado')->sum('monto');
        $this->show = Session::get('show', 1);
        $this->metodoPagos = MetodoPago::all();
        $this->estudents = Apprentice::all();
        $this->year = date('Y');
        $this->year2 = date('Y');
    }

    public function view($option)
    {
        Session::put('show', $option);
        $this->js('window.location.reload()');
    }
    public function setServiceIdAndSave($id)
    {
        $this->service_id = $id;
    }

    public function updatedComprobante()
    {
        $this->validate([
            'comprobante' => 'required|mimes:pdf,jpg,jpeg,png',
        ]);

        $filePath = $this->comprobante->store('comprobantes', 'public');
        $service = Service::find($this->service_id);
        if ($service) {
            $service->comprobante = $filePath;
            $service->save();
        }

        $this->comprobante = null;

        session()->flash('message', 'Comprobante guardado con éxito.');
    }
    public function showService()
    {
        $this->showServiceModal = true;
        $this->showCategoryModal = false;
        $this->showPayModal = false;
    }
    public function close()
    {
        $this->showServiceModal = false;
        $this->showCategoryModal = false;
        $this->showPayModal = false;
        $this->reset(['name', 'valor', 'type_service_id', 'pay_id', 'search']);
    }
    public function showCategory()
    {
        $this->showCategoryModal = true;
        $this->showServiceModal = false;
        $this->showPayModal = false;
    }
    public function showUpdate(Service $servicio)
    {
        $this->showServiceModal = true;
        $this->showCategoryModal = false;
        $this->showPayModal = false;

        $this->service_id = $servicio->id;
        $this->name = $servicio->name;
        $this->valor = $servicio->valor;
        $this->fecha = $servicio->fecha;
        $this->type_service_id = $servicio->type_service_id;
    }

    public function next()
    {
        $this->year += 1;
        $this->services = Service::whereYear('fecha', $this->year)->get();
    }

    public function nextpay()
    {
        $this->year2 += 1;
        $this->pagos = Pago::whereYear('created_at', $this->year2)->get();
    }
    public function previous()
    {
        $this->year -= 1;
        $this->services = Service::whereYear('fecha', $this->year)->get();
    }
    public function previouspay()
    {
        $this->year2 -= 1;
        $this->pagos = Pago::whereYear('created_at', $this->year2)->get();
    }

    public function updateService(Service $servicio)
    {
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
            $this->showServiceModal = false;
            $this->showCategoryModal = false;
            $this->showPayModal = false;
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
            $this->showServiceModal = false;
            $this->showCategoryModal = false;
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
            $this->showServiceModal = false;
            $this->showCategoryModal = false;
        }
    }
    public function delete(Service $service)
    {
        if (Auth::user()->rol_id != 1) {
            $this->dispatch('error', 'No tienes permisos para eliminar.');
            return;
        }
        $service->delete();
        $this->services = Service::all();
    }
    public function deletePay($id)
    {
        if (Auth::user()->rol_id != 1) {
            $this->dispatch('error', 'No tienes permisos para eliminar.');
            return;
        }
        $pago = Pago::find($id);
        if ($pago) {
            $pago->delete();
            $this->pagos = Pago::all();
        }
    }
    public function updatedNameEstudiante()
    {
        $this->showpays();
    }
    public function updatedDateInicio()
    {
        $this->showpays();
    }
    public function updatedDateFinal()
    {
        $this->showpays();
    }
    public function updatedMetodo()
    {
        $this->showpays();
    }
    public function updatedDinero()
    {
        $this->showpays();
    }
    public function showpays()
    {
        $query = Pago::query();

        if ($this->nameEstudiante != '') {
            $query->whereHas('apprentice', function ($q) {
                $q->where('name', 'LIKE', '%' . $this->nameEstudiante . '%')
                    ->orWhere('apellido', 'LIKE', '%' . $this->nameEstudiante . '%');
            });
        }

        if (!empty($this->dateInicio) && !empty($this->dateFinal)) {
            $start = \Carbon\Carbon::parse($this->dateInicio)->startOfDay();
            $end = \Carbon\Carbon::parse($this->dateFinal)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        if ($this->metodo != '') {
            $query->where('metodo_pago_id', '=', $this->metodo);
        }

        if ($this->dinero != '') {
            $query->where('dinero', '=', $this->dinero);
        }

        $this->pagos = $query->whereYear('created_at', $this->year2)->get();
    }
    public function showPay($id = null)
    {
        $this->showPayModal = true;
        $pay = Pago::find($id);
        if ($pay) {
            $this->idEstudentCreate = $pay->apprentice_id;
            $this->montoCreate = $pay->monto;
            $this->dateCreate = $pay->created_at->format('Y-m-d');
            $this->metodoCreate = $pay->metodo_pago_id;
            $this->dineroCreate = $pay->dinero;
            $this->pay_id = $pay->id;
            $this->search = $pay->egresado ?? '';
        } else {
            $this->reset(['idEstudentCreate', 'montoCreate', 'dateCreate', 'metodoCreate', 'dineroCreate', 'pay_id', 'search']);
        }
        $this->showServiceModal = false;
        $this->showCategoryModal = false;
    }
    public function updatedSearch()
    {
        $this->estudents = Apprentice::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('apellido', 'LIKE', '%' . $this->search . '%')
            ->get();
    }
    public function createPay($id = null)
    {
        $this->validate([
            'montoCreate' => 'required|numeric',
            'dateCreate' => 'required',
            'metodoCreate' => 'required',
            'dineroCreate' => 'required',
        ]);

        if ($this->dineroCreate == 'Egresado') {
            $this->validate([
                'search' => 'required',
            ]);
        } else {
            $this->validate([
                'idEstudentCreate' => 'required',
            ]);
        }

        $pay = Pago::find($id);

        if ($pay) {
            $pay->apprentice_id = $this->idEstudentCreate;
            $pay->monto = $this->montoCreate;
            $pay->created_at = $this->dateCreate;
            $pay->metodo_pago_id = $this->metodoCreate;
            $pay->dinero = $this->dineroCreate;
            $pay->egresado = $this->search;
            $pay->save();
        } else {
            Pago::create([
                'apprentice_id' => $this->idEstudentCreate,
                'monto' => $this->montoCreate,
                'created_at' => $this->dateCreate,
                'metodo_pago_id' => $this->metodoCreate,
                'dinero' => $this->dineroCreate,
                'egresado' => $this->search,
            ]);
        }
        $this->pagos = Pago::all();
        $this->reset(['idEstudentCreate', 'montoCreate', 'dateCreate', 'metodoCreate', 'dineroCreate', 'search']);
        $this->pay_id = '';
        $this->showPayModal = false;
    }

    public function donwload()
    {

        session()->put('pagos', $this->pagos);
        return redirect()->route('informe.caja',);
    }
    public function render()
    {
        $query = Service::query();
        if ($this->nameService != '') {
            $query->where('name', 'LIKE', '%' . $this->nameService . '%')
                ->orWhere('fecha', 'LIKE', '%' . $this->nameService . '%');
        }

        $query->whereYear('fecha', $this->year);

        if ($this->type != 'null') {
            $query->where('type_service_id', '=', $this->type);
        }

        if ($this->type != 'null') {
            $query->where('type_service_id', '=', $this->type);
        }
        if (!empty($this->date)) {
            $fecha = \Carbon\Carbon::parse($this->date);
            $query->whereYear('fecha', $fecha->year)
                ->whereMonth('fecha', $fecha->month);
        }

        $this->services = $query->get();

        return view('livewire.servicios');
    }
}
