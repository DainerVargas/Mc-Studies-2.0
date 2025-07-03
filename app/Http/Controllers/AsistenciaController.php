<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Group;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    public function asistencias($userId){
        $teacher = Teacher::findOrFail($userId);
        $user = Auth::user();
        return view('layouts.asistencia', compact('teacher', 'user'));
    }


    public function descargar(Teacher $teacher,  $date,  Group $grupo){

        $user = Auth::user();

        $asistencias = Asistencia::with('apprentice')
        ->where('teacher_id', $teacher->id)
        ->where('fecha', $date)
        ->where('group_id', $grupo->id)
        ->get();

    
    $pdf = Pdf::loadView('descargaAsistencia', ['asistencias' => $asistencias]);
    
    return $pdf->download("Registro de Asistencia $grupo->name .pdf");

    }
}
