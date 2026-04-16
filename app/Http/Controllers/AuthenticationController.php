<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\Models\Attendant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{


    public function login()
    {
        return view('layouts.login');
    }

    public function loginPost(LoginRequest $request)
    {

        if (Auth::attempt($request->only('usuario', 'password'))) {
            $request->session()->regenerate();
            $request->session()->regenerateToken();

            $user = Auth::user();

            if ($user->rol_id == 5 || $user->rol_id == 6) { // Acudiente o Estudiante
                return redirect()->route('mis_hijos');
            }

            // Administrador y otros roles (Secretaria, Asistente, Profesor)
            return redirect()->route('listaAprendiz');
        }

        return back()->withErrors([
            'password' => 'Usuario o contraseña incorrecta'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function registrar()
    {
        if (Auth::check() && Auth::user()->rol_id != 1) {
            if (Auth::user()->rol_id == 5 || Auth::user()->rol_id == 6) {
                return redirect()->route('mis_hijos');
            }
            return redirect()->route('listaAprendiz');
        }
        return view('registro');
    }

    public function historial()
    {
        $user = Auth::user();
        if ($user->rol_id != 1) {
            return redirect()->route('listaAprendiz');
        }
        $mes = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        /*  dd($year, $mes); */
        return view('layouts.historial', compact('user'));
    }
}
