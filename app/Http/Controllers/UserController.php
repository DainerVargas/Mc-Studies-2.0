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
        return view('layouts.usuario.anadir', compact('user'));
    }
    
    public function listado(){
        
        $user = Auth::user();
        return view('layouts.usuario.listado', compact('user'));
    }
}
