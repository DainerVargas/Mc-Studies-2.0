<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Group;
use App\Models\Teacher;
use App\Models\Apprentice;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    public function asistencias($userId)
    {
        $teacher = Teacher::findOrFail($userId);
        $user = Auth::user();
        return view('layouts.asistencia', compact('teacher', 'user'));
    }


    public function descargar(Teacher $teacher, $startDate, $endDate, Group $grupo)
    {
        $user = Auth::user();

        // Generar lista de fechas en el rango
        $datesInRange = [];
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        $tempDate = clone $start;
        while ($tempDate <= $end) {
            $datesInRange[] = $tempDate->format('Y-m-d');
            $tempDate->addDay();
        }

        $asistencias = Asistencia::with('apprentice')
            ->where('group_id', $grupo->id)
            ->whereBetween('fecha', [$startDate, $endDate])
            ->get()
            ->groupBy(['apprentice_id', 'fecha']);

        $estudiantes = Apprentice::where('group_id', $grupo->id)->get();

        $pdf = Pdf::loadView('descargaAsistencia', [
            'asistencias' => $asistencias,
            'datesInRange' => $datesInRange,
            'estudiantes' => $estudiantes,
            'grupo' => $grupo,
            'teacher' => $teacher,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        // Configurar papel horizontal para que quepa todo
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download("Reporte Asistencia {$grupo->name}.pdf");
    }
}
