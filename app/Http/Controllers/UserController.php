<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class UserController extends Controller
{

    use WithFileUploads;

    public function usuario()
    {
        $user = Auth::user();
        return view('layouts.usuario.informacion', compact('user'));
    }

    public function updateInfo(UpdateRequest $request, User $user)
    {
        if (isset($request->image)) {
            $path = $request->image->store('/');
            $foto = basename($path);
        } else {
            $foto = $user->image;
        }

        $usuario = User::find($user->id);

        $usuario->name = $request->name;
        $usuario->usuario  = $request->usuario;
        $usuario->image  = $foto;
        $usuario->email  = $request->email;
        $usuario->save();

        return back()->withErrors([
            'message' => 'Se ha actualizado correctamente.'
        ]);
    }

    public function actualizar()
    {
        $user = Auth::user();
        return view('layouts.usuario.actualizar', compact('user'));
    }

    public function updateUser(PasswordRequest $request, User $user)
    {

        if (!Hash::check($request->antigua, $user->password)) {
            return back()->withErrors([
                'antigua' => 'Contraseña incorrecta.'
            ])->withInput();
        }

        $usuario = User::find($user->id);
        $usuario->password = Hash::make($request->nueva);
        $usuario->save();

        return back()->withErrors([
            'message' => 'Contraseña Actualizada Correctamente.'
        ]);
    }

    public function agregar()
    {
        $user = Auth::user();
        if ($user->rol_id != 1) {
            return redirect()->route('listaAprendiz');
        }
        $teachers = \App\Models\Teacher::all();
        $attendants = \App\Models\Attendant::all();
        $rols = \App\Models\Rol::all();
        return view('layouts.usuario.anadir', compact('user', 'teachers', 'attendants', 'rols'));
    }

    public function storeUser(Request $request)
    {
        if (Auth::user()->rol_id != 1) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'usuario' => 'required|unique:users,usuario',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'type' => 'required',
            'image' => 'nullable|image|max:2048'
        ], [
            'required' => 'Este campo es requerido',
            'email' => 'Eso no parece ser un email',
            'unique' => '¡Ups!, ya existe',
            'password.min' => 'Requerido minimo 8 caracteres.',
            'password.regex' => 'Requerido al menos una letra minúscula, mayúscula y un número.',
            'max' => 'La imagen es demasiado pesada'
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('users'), $imageName);
        }

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->usuario = $request->usuario;
        $usuario->password = Hash::make($request->password);
        $usuario->image = $imageName;
        $usuario->rol_id = $request->type;
        $usuario->teacher_id = $request->teacher_id;
        $usuario->attendant_id = $request->attendant_id;
        $usuario->save();

        return back()->with('message', '🎉 ¡Registro Exitoso! 🎉');
    }

    public function listado()
    {
        $user = Auth::user();
        if ($user->rol_id != 1) {
            return redirect()->route('listaAprendiz');
        }
        return view('layouts.usuario.listado', compact('user'));
    }

    public function history(Request $request)
    {
        $user = Auth::user();
        if ($user->rol_id != 1) {
            return redirect()->route('listaAprendiz');
        }
        $category = $request->get('category');

        $query = \App\Models\ActivityLog::query();

        // Mapping de categorías a entity_type
        if ($category) {
            switch ($category) {
                case 'student':
                    $query->whereIn('entity_type', ['Estudiante', 'Descuento', 'Informe']);
                    break;
                case 'teachers':
                    $query->whereIn('entity_type', ['Profesor']);
                    break;
                case 'services':
                    $query->whereIn('entity_type', ['Servicio']);
                    break;
                case 'payments':
                    $query->whereIn('entity_type', ['Pagos', 'Abono']);
                    break;
                case 'cashier':
                    $query->whereIn('entity_type', ['Caja']);
                    break;
            }
        }

        $logs = $query->latest()->paginate(20);

        return view('layouts.usuario.history', compact('user', 'logs', 'category'));
    }
}
