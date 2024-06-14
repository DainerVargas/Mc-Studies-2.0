@extends('layouts.usuario')
@section('title', 'informacion del usuario')

@section('user')
    @livewire('cargar-imagen', ['user' => $user])
@endsection
