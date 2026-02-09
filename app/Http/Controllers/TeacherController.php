<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{

    public function lista()
    {
        $user = Auth::user();

        return view('layouts.listaProfesores', compact('user'));
    }

    public function infoteacher(Teacher $teacher)
    {
        $user = Auth::user();

        return view('layouts.infoTeacher', compact('teacher', 'user'));
    }

    public function tiempo()
    {
        $profesores = Teacher::all();
        foreach ($profesores as $key => $value) {
            $value->estado = false;
            $value->save();
        }
    }

    public function registerHours()
    {

        $user = Auth::user();
        return view('layouts.registerHours', compact('user'));
    }

    public function comprobante(Teacher $teacher)
    {
        return view('emails.comprobante', compact('teacher'));
    }

    public function hoursDetails(Teacher $teacher, Request $request)
    {
        $user = Auth::user();
        $query = $teacher->RegisterHours();

        if ($request->mes) {
            $query->where(function ($q) use ($request) {
                $q->whereMonth('lunes', $request->mes)
                    ->orWhereMonth('martes', $request->mes)
                    ->orWhereMonth('miercoles', $request->mes)
                    ->orWhereMonth('jueves', $request->mes)
                    ->orWhereMonth('viernes', $request->mes)
                    ->orWhereMonth('sabado', $request->mes);
            });
        }

        if ($request->anio) {
            $query->where(function ($q) use ($request) {
                $q->whereYear('lunes', $request->anio)
                    ->orWhereYear('martes', $request->anio)
                    ->orWhereYear('miercoles', $request->anio)
                    ->orWhereYear('jueves', $request->anio)
                    ->orWhereYear('viernes', $request->anio)
                    ->orWhereYear('sabado', $request->anio);
            });
        }

        if ($request->semana) {
            $query->where(function ($q) use ($request) {
                $q->whereRaw("WEEK(lunes) = ?", [$request->semana])
                    ->orWhereRaw("WEEK(martes) = ?", [$request->semana])
                    ->orWhereRaw("WEEK(miercoles) = ?", [$request->semana])
                    ->orWhereRaw("WEEK(jueves) = ?", [$request->semana])
                    ->orWhereRaw("WEEK(viernes) = ?", [$request->semana])
                    ->orWhereRaw("WEEK(sabado) = ?", [$request->semana]);
            });
        }

        $hoursDetails = $query->orderByDesc('updated_at')->get();
        $availableYears = range(date('Y'), 2020);

        session()->put('hoursDetails', $hoursDetails);

        return view('layouts.teacherHours', compact('teacher', 'user', 'hoursDetails', 'availableYears'));
    }

    public function hoursForm($id = null)
    {
        $user = Auth::user();
        $profesores = Teacher::all();
        $registerHour = $id ? \App\Models\RegisterHours::find($id) : null;

        return view('layouts.hoursForm', compact('user', 'profesores', 'registerHour', 'id'));
    }
}
