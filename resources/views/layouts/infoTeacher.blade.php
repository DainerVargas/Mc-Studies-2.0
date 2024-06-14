@extends('Dashboard')
@section('title','Informacion del Profesor')

@section('informacion')
    <div class="conteInformacion">
        @livewire('info-teacher', ['teacher' => $teacher])
    </div>
@endsection