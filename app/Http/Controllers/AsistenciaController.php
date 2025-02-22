<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Group;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    public function asistencias(){

        $user = Auth::user();
        return view('layouts.asistencia', compact('user'));
    }


    public function descargar($date,  Group $grupo){

        $user = Auth::user();

        $asistencias = Asistencia::with('apprentice')
        ->where('teacher_id', $user->teacher_id)
        ->where('fecha', $date)
        ->where('group_id', $grupo->id)
        ->get();

    
    $pdf = Pdf::loadView('descargaAsistencia', ['asistencias' => $asistencias]);
    
    return $pdf->download("Registro de Asistencia $grupo->name .pdf");

    }
}
