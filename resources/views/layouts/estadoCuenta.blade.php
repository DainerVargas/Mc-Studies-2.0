@extends('Dashboard')

@section('title', 'Estado de Cuenta - {{ $aprendiz->name }}')

@section('estadoCuenta')
    @livewire('estado-cuenta', ['aprendiz' => $aprendiz])
@endsection
