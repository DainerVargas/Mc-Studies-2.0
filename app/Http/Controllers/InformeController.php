<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformeController extends Controller
{
    public function informe(){
        $user = Auth::user();

        return view('layouts.informe', compact('user'));
    }
}
