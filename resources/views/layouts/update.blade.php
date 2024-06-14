@extends('Dashboard')
@section('title', 'Actualizar-Imformación')

@section('update')
    @livewire('selecte-image', ['aprendiz' => $aprendiz])
@endsection
