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
        $query = AcademicActivity::with(['apprentice', 'apprentice.group', 'attendant'])
            ->orderBy('created_at', 'desc');

        $view = $request->get('view', 'recibidas');
        $assignedActivities = collect();

        if ($view === 'asignadas') {
            $assignedQuery = \App\Models\AssignedActivity::with('groups')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc');

            if ($request->filled('search')) {
                $assignedQuery->where('titulo', 'LIKE', '%' . $request->search . '%');
            }

            if ($request->filled('group_id')) {
                $assignedQuery->whereHas('groups', function ($q) use ($request) {
                    $q->where('groups.id', $request->group_id);
                });
            }

            $assignedActivities = $assignedQuery->get();
        } else {
            // Filtrar por grupo si está presente
            if ($request->filled('group_id')) {
                $query->whereHas('apprentice', function ($q) use ($request) {
                    $q->where('group_id', $request->group_id);
                });
            }

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
        }

        // Obtener lista de aprendices para el filtro
        // Si hay un grupo seleccionado, solo mostrar aprendices de ese grupo
        if ($request->filled('group_id')) {
            $aprendices = Apprentice::where('group_id', $request->group_id)->orderBy('name')->get();
        } else {
            $aprendices = Apprentice::orderBy('name')->get();
        }

        $groups = \App\Models\Group::all();

        return view('layouts.listaActividades', [
            'activities' => $activities ?? collect(),
            'assignedActivities' => $assignedActivities,
            'view' => $view,
            'aprendices' => $aprendices,
            'groups' => $groups,
            'user' => $user
        ]);
    }
    public function destroy(\App\Models\AssignedActivity $assignedActivity)
    {
        $user = Auth::user();

        if ($user->rol_id != 1) {
            return redirect()->back()->with('error', 'No tienes permisos para eliminar esta actividad.');
        }

        // Log the deletion
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->rol->name ?? 'Usuario', // Adjust if rol relationship is different
            'action_type' => 'ELIMINAR',
            'entity_type' => 'Actividad',
            'entity_id' => $assignedActivity->id,
            'description' => "Se eliminó la actividad asignada: {$assignedActivity->titulo}",
            'old_values' => $assignedActivity->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $assignedActivity->groups()->detach();
        $assignedActivity->delete();

        return redirect()->back()->with('success', 'Actividad eliminada correctamente.');
    }
}
