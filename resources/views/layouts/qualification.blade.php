@extends('Dashboard')

@section('title', 'Calificaciones')

@section('qualification')
    <div class="conteListAprendiz">
        @livewire('qualification', ['teacher' => $teacher])
    </div>
@endsection
