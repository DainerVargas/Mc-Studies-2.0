@extends('layouts.usuario')
@section('title', 'informacion del usuario')

@section('user')
    <div class="user-content-wrapper">
        @livewire('cargar-imagen', ['user' => $user])
    </div>
@endsection
