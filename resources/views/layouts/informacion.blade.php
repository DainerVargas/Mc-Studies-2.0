@extends('Dashboard')
@section('title','Informacion del aprendiz')

@section('informacion')
    <div class="conteInformacion">
        @livewire('info-aprendiz', ['aprendiz' => $aprendiz])
    </div>
@endsection