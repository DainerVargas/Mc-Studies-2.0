@extends('Dashboard')

@section('title', 'Registro de Asistencias')

@section('asistencia')
    <div class="conteListAprendiz">
        @livewire('asistencia', ['teacher' => $teacher])
    </div>
@endsection
