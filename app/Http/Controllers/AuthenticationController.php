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

    public function index()
    {
        return view('layouts.login');
    }

    public function login()
    {
        return view('layouts.login');
    }

    public function loginPost(LoginRequest $request)
    {

        if (Auth::attempt($request->only('usuario', 'password'))) {

            $request->session()->regenerate();
            $request->session()->regenerateToken();

            return redirect()->route('listaAprendiz');
        }

        return back()->withErrors([
            'password' => 'Usuario o contraseña incorrecta'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }

    public function registrar()
    {
        return view('registro');
    }

    public function historial()
    {
        $user = Auth::user();
        $mes = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
       /*  dd($year, $mes); */
        return view('layouts.historial', compact('user'));
    }
}
