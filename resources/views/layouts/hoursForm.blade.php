@extends('Dashboard')
@section('title', 'Formulario de Horas')

@section('registerHours')
    <div class="conteListAprendiz">
        @livewire('register-hours-form', ['editId' => $id])
    </div>
@endsection
