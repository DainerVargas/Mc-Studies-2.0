@extends('Dashboard')

@section('title', 'informacion del usuario')

@section('usuario')
    <div class="conteInfoUser">
        <div class="links">
            @php
                if (request()->routeIs('usuario') == true) {
                    $validat = true;
                } else {
                    $validat = false;
                }
            @endphp
            <a class="{{ $validat ? 'active' : '' }}" href="{{ route('usuario') }}">Información</a>
            @php
                if (request()->routeIs('actualizar') == true) {
                    $validat = true;
                } else {
                    $validat = false;
                }
            @endphp
            <a class="{{ $validat ? 'active' : '' }}" href="{{ route('actualizar') }}">Actualizar Contraseña</a>
            @if ($user->id == 1)
                @php
                    if (request()->routeIs('agregar') == true) {
                        $validat = true;
                    } else {
                        $validat = false;
                    }
                @endphp
                <a class="{{ $validat ? 'active' : '' }}" href="{{ route('agregar') }}">Añadir Usuario</a>
                @php
                    if (request()->routeIs('listado') == true) {
                        $validat = true;
                    } else {
                        $validat = false;
                    }
                @endphp
                <a class="{{ $validat ? 'active' : '' }}" href="{{ route('listado') }}">Lista de Usuario</a>
            @endif
        </div>
        <div class="contenedor">
            @yield('user')
            @yield('actualizar')
            @yield('anadir')
            @yield('listado')
        </div>
    </div>
@endsection
