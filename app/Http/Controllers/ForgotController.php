<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use App\Mail\RecuperarPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotController extends Controller
{
    public function forgot()
    {
        return view('forgot');
    }

    public function forgotPassword(Request $request){

        $request->validate([
            'email' => 'required|email',
        ],[
            'email' => 'No parece ser un email.',
            'required' => 'Este campo es requerido.',
        ]);

        $email = $request->email;
        $newPassword = 'McStudies-' . Str::random(5);
    
        $user = User::where('email', $email)->first();

        if ($user) {   
            $user->password = Hash::make($newPassword);
        }else{
            return back()->withErrors([
                'email' => "Este usuario no existe."
            ]);
        }

        try {
           /*  Mail::to($email)->send(new RecuperarPasswordMail($newPassword, $user)); */
            Mail::to('dainer2607@gmail.com')->send(new RecuperarPasswordMail($newPassword, $user));
            $user->save();
            
        } catch (\Throwable $th) {
            return back()->withErrors([
                'email' => "Hubo un error, revisa tu conexion.",
            ]);
        }
        
        return back()->withErrors([
            'message' => "Tu nueva contraseña se ha enviado a tu Email: ". $email
        ]);

    }
}
