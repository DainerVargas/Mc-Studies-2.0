@extends('Dashboard')

@section('title', 'informacion del usuario')

@section('usuario')
    <div class="user-layout-container">
        <div class="user-sidebar">
            <a class="{{ request()->routeIs('usuario') ? 'active' : '' }}" href="{{ route('usuario') }}">
                <span class="material-symbols-outlined" style="margin-right: 10px;">person</span>
                Información
            </a>

            <a class="{{ request()->routeIs('actualizar') ? 'active' : '' }}" href="{{ route('actualizar') }}">
                <span class="material-symbols-outlined" style="margin-right: 10px;">lock_reset</span>
                Actualizar Contraseña
            </a>

            @if ($user->rol_id == 1)
                <a class="{{ request()->routeIs('agregar') ? 'active' : '' }}" href="{{ route('agregar') }}">
                    <span class="material-symbols-outlined" style="margin-right: 10px;">group_add</span>
                    Añadir Usuario
                </a>
                
                <a class="{{ request()->routeIs('listado') ? 'active' : '' }}" href="{{ route('listado') }}">
                    <span class="material-symbols-outlined" style="margin-right: 10px;">list_alt</span>
                    Lista de Usuarios
                </a>

                <a class="{{ request()->routeIs('history') ? 'active' : '' }}" href="{{ route('history') }}">
                    <span class="material-symbols-outlined" style="margin-right: 10px;">history</span>
                    Historial de acciones
                </a>
            @endif
        </div>

        <div class="user-content-area">
            @yield('user')
            @yield('actualizar')
            @yield('anadir')
            @yield('listado')
            @yield('history')
        </div>
    </div>
@endsection
