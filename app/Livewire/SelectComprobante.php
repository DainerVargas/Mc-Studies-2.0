<?php

namespace App\Livewire;

use App\Http\Requests\RegistroRequest;
use App\Mail\ConfirmacionMail;
use App\Models\Apprentice;
use App\Models\Attendant;
use App\Models\Informe;
use App\Services\MercadoPagoService;
use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Livewire\WithFileUploads;

class SelectComprobante extends Component
{

    use WithFileUploads;

    public $name, $apellido, $edad, $telefono, $email, $direccion, $valor, $precio;
    public $fecha_nacimiento;
    public $nameAcudiente;
    public $apellidoAcudiente;
    public $telefonoAcudiente;
    public $emailAcudiente;
    public $modality_id;
    public $imagen;
    public $comprobante;
    public $success, $error;
    public $metodo;

    public function modalidad($value)
    {
        if ($value == 4 && $this->valor == '') {
            $this->error = 'Ingrese el valor de la modalidad.';
            return;
        } else {
            $this->error = '';
        }
        $this->modality_id = $value;
    }

    public function active($valor)
    {
        $this->comprobante = $valor;
    }

    public function validacion()
    {
        $validaciones = $this->validate([
            'name' => 'required',
            'apellido' => 'required',
            'edad' => 'required',
            'direccion' => 'required',
            'fecha_nacimiento' => 'required',
            'modality_id' => 'required',
            'comprobante' => 'nullable'
        ], [

            'name.required' => 'El nombre es requerido',
            'apellido.required' => 'El apellido es requerido',
            'edad.required' => 'La edad es requerida',
            'direccion.required' => 'La dirección es requerida',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es requerida',

            'nameAcudiente.required' => 'El nombre del acudiente es requerido',
            'apellidoAcudiente.required' => 'El apellido del acudiente es requerido',
            'telefonoAcudiente.required' => 'El teléfono es requerido',
            'telefonoAcudiente.numeric' => 'El teléfono debe contener solo números',
            'emailAcudiente.required' => 'El email es requerido',
            'emailAcudiente.email' => 'El email no tiene un formato válido',
            'modality_id' => 'La modalidad es requerida',
            'comprobante.image' => 'Es requerida una imagen para el comprobante'
        ]);

        if ($this->edad >= 18) {
            $this->validate([
                'telefono' => 'required|numeric',
                'email' => 'required|email',
            ], [
                'telefono.required' => 'El teléfono es requerido',
                'telefono.numeric' => 'El teléfono debe contener solo números',
                'email.required' => 'El email es requerido',
                'email.email' => 'El email no tiene un formato válido',
            ]);
        } else {
            $this->validate([
                'nameAcudiente' => 'required',
                'apellidoAcudiente' => 'required',
                'telefonoAcudiente' => 'required|numeric',
                'emailAcudiente' => 'required|email',

            ], [
                'nameAcudiente.required' => 'El nombre del acudiente es requerido',
                'apellidoAcudiente.required' => 'El apellido del acudiente es requerido',
                'telefonoAcudiente.required' => 'El teléfono es requerido',
                'telefonoAcudiente.numeric' => 'El teléfono debe contener solo números',
                'emailAcudiente.required' => 'El email es requerido',
                'emailAcudiente.email' => 'El email no tiene un formato válido',
            ]);
        }
    }

    public function createApprentice()
    {
        $this->validacion();

        $acudienteID = 1;

        if ($this->edad < 18) {
            $attendant = Attendant::where('email', $this->email)->first();
            if ($attendant == null) {
                $acudiente = Attendant::create([
                    'name' => $this->nameAcudiente,
                    'apellido' => $this->apellidoAcudiente,
                    'telefono' => $this->telefonoAcudiente,
                    'email' => $this->emailAcudiente,
                ]);
                $acudienteID = $acudiente->id;
            }
        }

        $plataforma = 0;

        $aprendiz = Apprentice::create([
            'name' => $this->name,
            'apellido' => $this->apellido,
            'edad' => $this->edad,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'estado' => 0,
            'valor' => $this->valor,
            'email' => $this->email,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'comprobante' => null,
            'plataforma' => $plataforma,
            'attendant_id' => $acudienteID,
            'modality_id' => $this->modality_id,
        ]);

        $informe = Informe::create([
            'apprentice_id' => $aprendiz->id,
            'abono' => 0,
            'fecha' => null,
        ]);

        try {
            /*  if ($estudiante->email != null) {
                    Mail::to($estudiante->email)->send(new ConfirmacionMail($estudiante));
                } else {
                    Mail::to($acudiente->email)->send(new ConfirmacionMail($estudiante));
                } */

            /*  Mail::to('info@mcstudies.com')->send(new ConfirmacionMail($estudiante)); */

            Mail::to('dainer2607@gmail.com')->send(new ConfirmacionMail($aprendiz));
        } catch (\Throwable $th) {
            return redirect('Registrate')->with('messageError', 'Hubo un erorr. Por favor revisa tu conexion.');
        }

        return redirect('Registrate')->with('messageSuccess', 'Registro satisfactorio.');
    }

    public function stores()
    {

        $this->validacion();

        if ($this->modality_id == 3) {
            /* $this->precio =  950000; */
            $this->precio =  5000;
        } elseif ($this->modality_id == 2) {
            /*  $this->precio =  590000; */
            $this->precio =  4000;
        } elseif ($this->modality_id == 1) {
            /* $this->precio =  440000; */
            $this->precio =  3000;
        } elseif ($this->modality_id == 4) {
            $this->precio = $this->valor;
        }

        $mercadoPagoService = new  MercadoPagoService;
        $paymentUrl = $mercadoPagoService->createPaymentPreference($this->precio, "Pago de la modalidad. Mc-Studies |", 1);

        session()->put('people_data', [
            'name' => $this->name,
            'apellido' => $this->apellido,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'edad' => $this->edad,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'nameAcudiente' => $this->nameAcudiente,
            'apellidoAcudiente' => $this->apellidoAcudiente,
            'telefonoAcudiente' => $this->telefonoAcudiente,
            'emailAcudiente' => $this->emailAcudiente,
            'estado' => 0,
            'modality_id' => $this->modality_id,
            'precio' => $this->precio,
        ]);

        try {
            return redirect()->away($paymentUrl);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.select-comprobante');
    }
}
