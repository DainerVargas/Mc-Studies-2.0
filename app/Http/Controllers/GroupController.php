<?php

namespace App\Http\Controllers;

use App\Models\Apprentice;
use App\Models\Group;
use App\Models\History;
use App\Models\Qualification;
use App\Models\Teacher;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filtroName = $request->get('search');
        $estado = $request->get('estado');

        $query = Group::query();

        if ($estado == 'active') {
            $query->where('type_id', 1);
        } elseif ($estado == 'inactive') {
            $query->where('type_id', 2);
        }

        if ($filtroName) {
            $query->where('name', 'LIKE', '%' . $filtroName . '%');
        }

        if ($user->rol_id != 1 && $user->teacher_id) {
            $teacherId = $user->teacher_id;
            $query->where(function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId)
                    ->orWhereHas('tutors', function ($sq) use ($teacherId) {
                        $sq->where('teacher_id', $teacherId);
                    });
            });
        }

        $grupos = $query->get();
        $profesores = Teacher::all();
        $allTutors = Teacher::where('type_teacher_id', 2)->get();
        $types = Type::all();

        return view('layouts.grupo', compact('user', 'grupos', 'profesores', 'allTutors', 'types', 'filtroName', 'estado'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:groups,name',
            'teacher_id' => 'required',
            'type_id' => 'required',
        ], [
            'required' => 'Este campo es requerido.',
            'name.unique' => 'Este nombre ya existe.',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
            'type_id' => $request->type_id,
        ]);

        if ($request->has('tutor_ids')) {
            $group->tutors()->sync($request->tutor_ids);
        }

        $year = Carbon::now()->format('y');
        $mes = Carbon::now()->format('m');

        History::create([
            'name' => $request->name,
            'cantidad' => 0,
            'year' => $year,
            'mes' => $mes,
            'total' => 0,
        ]);

        return back()->with('success', 'Grupo creado correctamente.');
    }

    public function update(Request $request, Group $group)
    {
        if (!$this->canAccessGroup($group)) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|unique:groups,name,' . $group->id,
            'teacher_id' => 'required',
        ], [
            'required' => 'Este campo es requerido.',
            'unique' => 'Este nombre ya existe.',
        ]);

        $oldName = $group->name;
        $group->update([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
        ]);

        if ($request->has('tutor_ids')) {
            $group->tutors()->sync($request->tutor_ids);
        } else {
            $group->tutors()->detach();
        }

        $year = Carbon::now()->format('y');
        $history = History::where('name', $oldName)->where('year', $year)->first();
        if ($history) {
            $history->update(['name' => $request->name]);
        }

        return back()->with('success', 'Grupo actualizado correctamente.');
    }

    public function destroy(Group $group)
    {
        if (Auth::user()->rol_id != 1) {
            abort(403);
        }

        Apprentice::where('group_id', $group->id)->update(['group_id' => null]);
        $group->tutors()->detach();
        $group->delete();

        return back()->with('success', 'Grupo eliminado correctamente.');
    }

    protected function canAccessGroup(Group $group)
    {
        $user = Auth::user();
        if ($user->rol_id == 1) {
            return true;
        }
        if (!$user->teacher_id) {
            return false;
        }
        $teacherId = $user->teacher_id;
        return $group->teacher_id == $teacherId || $group->tutors()->where('teacher_id', $teacherId)->exists();
    }
}
