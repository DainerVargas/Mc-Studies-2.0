<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('layouts.grupo', compact('user'));
    }
}
