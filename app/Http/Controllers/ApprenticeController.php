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
    public function lista(Request $request)
    {
        $user = Auth::user();

        if ($user->rol_id == 5) {
            return redirect()->route('mis_hijos');
        }

        // Sedes and Groups for filters
        if ($user->rol_id != 4) {
            $gruposSelect = \App\Models\Group::all();
        } else {
            $gruposSelect = \App\Models\Group::where('teacher_id', $user->teacher_id)->get();
        }

        // Base Query
        if (isset($user->teacher_id)) {
            $gruposIds = \App\Models\Group::where('teacher_id', $user->teacher_id)->pluck('id');
            $query = Apprentice::whereIn('group_id', $gruposIds);
        } else {
            $query = Apprentice::query();
        }

        // Apply Search Filter
        if ($request->has('name') && $request->name != '') {
            $words = preg_split('/\s+/', strtolower(trim($request->name)));

            $query->where(function ($q) use ($words) {
                foreach ($words as $word) {

                    if (strlen($word) <= 4) {
                        continue;
                    }

                    $term = '%' . $word . '%';

                    $q->orWhere(function ($subQ) use ($term) {
                        $subQ->where('name', 'LIKE', $term)
                            ->orWhere('apellido', 'LIKE', $term);
                    });
                }
            });
        }

        // Apply Group Filter
        if ($request->has('grupo') && $request->grupo != 'all') {
            if ($request->grupo == 'none') {
                $query->whereNull('group_id');
            } else {
                $query->where('group_id', $request->grupo);
            }
        }

        // Apply Sede Filter
        if ($request->has('sede') && $request->sede != '') {
            $query->where('sede_id', $request->sede);
        }

        // Apply Status Filter
        if ($request->has('estado') && $request->estado != 'all') {
            $status = $request->estado == 'active' ? 1 : 0;
            $query->where('estado', $status);
        }

        $aprendices = $query->get();

        return view('layouts.listaAprendiz', compact('user', 'aprendices', 'gruposSelect'));
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
        $documento = session()->get('documento');

        $estudiantes = Apprentice::whereIn('id', $selectEstudents)->get();

        foreach ($estudiantes as $estudiant) {
            try {
                $email = $estudiant->edad >= 18 ? $estudiant->email : $estudiant->attendant->email;
                Mail::to('dainer2607@gmail.com')->send(new SendMail($asunto, $text, $documento));
            } catch (\Throwable $th) {

                return redirect()->route('sendEmail')->with('error', 'Ha ocurrido un error');
            }
        }

        return redirect()->route('sendEmail')->with('success', 'Emails enviados satisfactoriamente');
    }

    public function qualification(Teacher $teacher)
    {
        $user = Auth::user();
        return view('layouts.qualification', compact('user', 'teacher'));
    }
    public function destroy(Apprentice $aprendiz)
    {
        $informes = Informe::where('apprentice_id', $aprendiz->id)->get();

        foreach ($informes as $informe) {
            $informe->delete();
        }

        $nombre = $aprendiz->name;
        $aprendiz->delete();

        return redirect()->route('listaAprendiz')->with('messageSuccess', "Aprendiz $nombre eliminado correctamente.");
    }
}
