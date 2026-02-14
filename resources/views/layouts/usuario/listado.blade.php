@extends('layouts.usuario')
@section('title', 'Listado Usuarios')

@section('listado')
    <div class="user-content-wrapper">
        @livewire('listado-usuarios')
    </div>
@endsection
