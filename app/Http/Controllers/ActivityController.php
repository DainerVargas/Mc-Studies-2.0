<?php

namespace App\Http\Controllers;

use App\Models\AcademicActivity;
use App\Models\Apprentice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Base query con relaciones
        $query = AcademicActivity::with(['apprentice', 'attendant'])
            ->orderBy('created_at', 'desc');

        // Filtar por nombre de actividad si está presente
        if ($request->filled('search')) {
            $query->where('titulo', 'LIKE', '%' . $request->search . '%');
        }

        // Filtrar por fecha si está presente
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        // Filtrar por aprendiz si está presente
        if ($request->filled('aprendiz_id')) {
            $query->where('apprentice_id', $request->aprendiz_id);
        }

        // Obtener actividades
        $activities = $query->get();

        // Obtener lista de aprendices para el filtro
        $aprendices = Apprentice::orderBy('name')->get();

        return view('layouts.listaActividades', [
            'activities' => $activities,
            'aprendices' => $aprendices,
            'user' => $user
        ]);
    }
}
