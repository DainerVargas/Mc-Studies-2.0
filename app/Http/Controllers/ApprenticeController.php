<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use App\Mail\RecordatorioVirtualMail;
use App\Mail\SendMail;
use App\Models\Apprentice;
use App\Models\Informe;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApprenticeController extends Controller
{
    public function lista()
    {
        $user = Auth::user();

        return view('layouts.listaAprendiz', compact('user'));
    }

    public function info(Apprentice $aprendiz)
    {
        $user = Auth::user();

        return view('layouts.informacion', compact('user', 'aprendiz'));
    }

    public function sendEmails()
    {
        $aprendices = Apprentice::all();
        $dia_semana = date("N");
        foreach ($aprendices as $key => $aprendiz) {
            if (Carbon::now()->toDateString() . ' 00:00:00' >= $aprendiz->fecha_fin && $aprendiz->fecha_inicio != null && $aprendiz->estado != true) {
                $aprendiz->estado = false;
                $aprendiz->fecha_inicio = null;
                $aprendiz->fecha_fin = null;
                $aprendiz->save();

                if ($aprendiz->email != null) {
                    $email = $aprendiz->email;
                } else {
                    $email = $aprendiz->attendant->email;
                }

                try {
                    /*  Mail::to($email)->send(new PasswordResetMail($aprendiz)); */
                    Mail::to('dainer2607@gmail.com')->send(new PasswordResetMail($aprendiz));
                } catch (\Throwable $th) {
                    return 'hubo un erorr. Por favor revisa tu conexion.';
                }
            }

            /* if ($dia_semana == 3) {
                 Mail::to('dainer2607@gmail.com')->send(new RecordatorioVirtualMail($aprendiz));
                Mail::to($aprendiz->attendant->email)->send(new RecordatorioVirtualMail($aprendiz));
            } */
        }
    }

    public function estado(Apprentice $aprendiz)
    {
        $user = Auth::user();

        return view('layouts.estadoCuenta', compact('aprendiz', 'user'));
    }

    public function sendEmail()
    {
        $user = Auth::user();
        return view('layouts.sendEmail', compact('user'));
    }

    public function send()
    {
        $asunto = session()->get('asunto');
        $text = session()->get('text');
        $selectEstudents = session()->get('selectEstudents');

        $estudiantes = Apprentice::whereIn('id', $selectEstudents)->get();

        foreach ($estudiantes as $estudiant) {

            if ($estudiant->edad >= 18) {
                $email = $estudiant->email;
            } else {
                $email = $estudiant->attendant->email;
            }


            if (!empty($email)) {
                try {
                    Mail::to($email)->send(new SendMail($asunto, $text));
                    return redirect()->route('sendEmail')->with('success', 'Email enviado satisfactoriamente');
                } catch (\Throwable $th) {
                    return redirect()->route('sendEmail')->with('error', 'Ha ocurrido un error');
                }
            }
        }
    }

    public function qualification(Teacher $teacher)
    {
        $user = Auth::user();
        return view('layouts.qualification', compact('user', 'teacher'));
    }
}
