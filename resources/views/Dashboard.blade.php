<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-BvbZW79v.css') }}"> --}}
    <link rel="icon" type="image/png" href="{{ asset('Logo.png') }}">
</head>

<body>
    @vite('resources/sass/app.scss')
    <header class="principal">
        <div class="conteImage">
            <a href="Lista-Aprendiz"><img src="/images/Logo.png" alt=""></a>
        </div>
        <div class="links">
            @php
                if (request()->routeIs('listaAprendiz') == true) {
                    $validat = true;
                } else {
                    $validat = false;
                }
            @endphp
            <a href="{{ route('listaAprendiz') }}" class="{{ $validat ? 'active' : '' }}">Estudiantes</a>

            @if (!isset($user->teacher_id))
                @php
                    if (request()->routeIs('listaProfesor') == true) {
                        $validat = true;
                    } else {
                        $validat = false;
                    }
                @endphp
                <a href="{{ route('listaProfesor') }}" class="{{ $validat ? 'active' : '' }}">Trabajadores</a>
                <a href="{{ route('registro') }}">Registro</a>
                @php
                    if (request()->routeIs('grupo') == true) {
                        $validat = true;
                    } else {
                        $validat = false;
                    }
                @endphp
                <a href="{{ route('grupo') }}" class="{{ $validat ? 'active' : '' }}">Grupos</a>
                @php
                    if (request()->routeIs('informe') == true) {
                        $validat = true;
                    } else {
                        $validat = false;
                    }
                @endphp
                <a href="{{ route('informe') }}" class="{{ $validat ? 'active' : '' }}">Informes</a>
                @php
                    if (request()->routeIs('historial') == true) {
                        $validat = true;
                    } else {
                        $validat = false;
                    }
                @endphp
                <a href="{{ route('historial') }}" class="{{ $validat ? 'active' : '' }}">Historial</a>

                @if ($user->rol_id == 1)
                @php
                    if (request()->routeIs('servicios') == true) {
                        $validat = true;
                    } else {
                        $validat = false;
                    }
                @endphp
                    <a href="{{ route('servicios') }}" class="{{ $validat ? 'active' : '' }}">Servicios</a>
                @endif
            @else
                @php
                    if (request()->routeIs('asistencia') == true) {
                        $validat = true;
                    } else {
                        $validat = false;
                    }
                @endphp
                <a href="{{ route('asistencias') }}" class="{{ $validat ? 'active' : '' }}">Registro de Asistencia</a>
            @endif
        </div>
        <div class="conteUsuario">
            <div class="user">
                <span class="material-symbols-outlined">
                    person
                </span>
                @if ($user->rol_id == 4)
                    <a href="{{ route('usuario') }}">{{ $user->teacher->name }}</a>
                @else
                    <a href="{{ route('usuario') }}">{{ $user->name }}</a>
                @endif
            </div>
            <div class="logout">
                <a href="{{ route('logout') }}">Cerrar Sesion</a>
            </div>
        </div>
    </header>

    <main>
        @yield('listaAprendiz')
        @yield('informacion')
        @yield('listaProfesor')
        @yield('grupo')
        @yield('update')
        @yield('informe')
        @yield('estadoCuenta')
        @yield('usuario')
        @yield('historial')
        @yield('asistencia')
        @yield('servicios')
    </main>

</body>

</html>
