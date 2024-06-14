<?php

namespace App\Livewire;

use App\Http\Requests\RegistroRequest;
use App\Mail\ConfirmacionMail;
use App\Models\Apprentice;
use App\Models\Attendant;
use App\Models\Informe;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Livewire\WithFileUploads;

class SelectComprobante extends Component
{

    use WithFileUploads;

    public $name;
    public $apellido;
    public $edad;
    public $fecha_nacimiento;
    public $nameAcudiente;
    public $apellidoAcudiente;
    public $telefono;
    public $email;
    public $modality_id;
    public $imagen;
    public $comprobante;
    public $success;
    public $metodo;

    public function modalidad($value)
    {
        $this->modality_id = $value;
    }

    public function active($valor)
    {
        $this->comprobante = $valor;
    }

    public function store()
    {
        $validaciones = $this->validate([
            'name' => 'required',
            'apellido' => 'required',
            'edad' => 'required',
            'fecha_nacimiento' => 'required',

            'nameAcudiente' => 'required',
            'apellidoAcudiente' => 'required',
            'telefono' => 'required|numeric',
            'email' => 'required|email',

            'modality_id' => 'required',
            'comprobante' => 'nullable'
        ], [

            'name.required' => 'El nombre es requerido',
            'apellido.required' => 'El apellido es requerido',
            'edad.required' => 'La edad es requerida',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es requerida',

            'nameAcudiente.required' => 'El nombre del acudiente es requerido',
            'apellidoAcudiente.required' => 'El apellido del acudiente es requerido',
            'telefono.required' => 'El teléfono es requerido',
            'telefono.numeric' => 'El teléfono debe contener solo números',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no tiene un formato válido',
            'modality_id' => 'La modalidad es requerida',
            'comprobante.image' => 'Es requerida una imagen para el comprobante'
        ]);

        if ($validaciones) {

            if ($this->imagen) {

                $imageName = time() . '.' . $this->imagen->extension();
                $this->imagen->storeAs('/', $imageName);
            } else {
                $imageName = null;
            }
            
            $attendant = Attendant::where('email', $this->email)->first();
            if ($attendant == null) {
                $acudiente = Attendant::create([
                    'name' => $this->nameAcudiente,
                    'apellido' => $this->apellidoAcudiente,
                    'telefono' => $this->telefono,
                    'email' => $this->email,
                ]);
            } else {
                $acudiente = $attendant;
            }

            $estudiante = Apprentice::create([
                'name' => $this->name,
                'apellido' => $this->apellido,
                'edad' => $this->edad,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'estado' => 0,
                'comprobante' => $imageName,
                'attendant_id' => $acudiente->id,
                'modality_id' => $this->modality_id,
            ]);

            $informe = Informe::create([
                'apprentice_id' => $estudiante->id,
                'abono' => 0,
                'fecha' => null,
            ]);

            try {

                Mail::to('dainer2607@gmail.com')->send(new ConfirmacionMail($estudiante));
                
                /* Mail::to('info.mcstudies@gmail.com')->send(new ConfirmacionMail($estudiante)); */

                Mail::to($acudiente->email)->send(new ConfirmacionMail($estudiante));
            } catch (\Throwable $th) {
                dd('hubo un erorr. Por favor revisa tu conexion. ');
            }

            $this->success = '¡Te haz registrado con Exito!, muy pronto resiviras un correo dandote las indicaciones de todo lo relacionado.';

            $this->name = '';
            $this->apellido = '';
            $this->edad = '';
            $this->fecha_nacimiento = '';
            $this->nameAcudiente = '';
            $this->apellidoAcudiente = '';
            $this->telefono = '';
            $this->email = '';
            $this->modality_id = '';
            $this->imagen = '';
            $this->comprobante = '';
        }
    }

    public function render()
    {
        return view('livewire.select-comprobante');
    }
}
