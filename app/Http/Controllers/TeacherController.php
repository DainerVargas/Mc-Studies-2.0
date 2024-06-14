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

    public function comprobante(Teacher $teacher)
    {
        return view('emails.comprobante', compact('teacher'));
    }
}
