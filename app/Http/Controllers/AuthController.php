<?php

namespace App\Http\Controllers;

use App\Mail\ComprobanteMail;
use App\Mail\ConfirmacionMail;
use App\Models\Apprentice;
use App\Models\Attendant;
use App\Models\Informe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function capturePayment(Request $request)
    {
        $name = session()->get('people_data.name');
        $email = session()->get('people_data.email');
        $apellido = session()->get('people_data.apellido');
        $fecha_nacimiento = session()->get('people_data.fecha_nacimiento');
        $telefono = session()->get('people_data.telefono');
        $edad = session()->get('people_data.edad');
        $direccion = session()->get('people_data.direccion');
        $nameAcudiente = session()->get('people_data.nameAcudiente');
        $apellidoAcudiente = session()->get('people_data.apellidoAcudiente');
        $telefonoAcudiente = session()->get('people_data.telefonoAcudiente');
        $emailAcudiente = session()->get('people_data.emailAcudiente');
        $modality_id = session()->get('people_data.modality_id');
        $precio = session()->get('people_data.precio');

        $acudienteID = 1;

        if ($edad < 18) {
            $attendant = Attendant::where('email', $email)->first();
            if ($attendant == null) {
                $acudiente = Attendant::create([
                    'name' => $nameAcudiente,
                    'apellido' => $apellidoAcudiente,
                    'telefono' => $telefonoAcudiente,
                    'email' => $emailAcudiente,
                ]);
                $acudienteID = $acudiente->id;
            }
        }

        $plataforma = 0;

        if ($modality_id != 4) {
            $plataforma = 140000;
        }

        $aprendiz = Apprentice::create([
            'name' => $name,
            'apellido' => $apellido,
            'edad' => $edad,
            'fecha_nacimiento' => $fecha_nacimiento,
            'estado' => 0,
            'valor' => $precio,
            'email' => $email,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'comprobante' => null,
            'plataforma' => $plataforma,
            'attendant_id' => $acudienteID,
            'modality_id' => $modality_id,
        ]);

        if ($modality_id == 3) {
            $precio =  810000;
        } elseif ($modality_id == 2) {
            $precio =  450000;
        } elseif ($modality_id == 1) {
            $precio =  300000;
        }

        $informe = Informe::create([
            'apprentice_id' => $aprendiz->id,
            'abono' => $precio,
            'fecha' => Date::now(),
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
            dd('hubo un erorr. Por favor revisa tu conexion. ');
        }

        return redirect('Registrate')->with('success', 'Pago realizado con éxito.');
    }

    public function cancelPayment()
    {
        return redirect('Registrate')->with('error', 'El pago fue cancelado.');
    }
}
