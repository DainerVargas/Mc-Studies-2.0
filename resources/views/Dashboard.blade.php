<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
        {{-- <link rel="stylesheet" href="{{asset('build/assets/app-hjctGKyo.css')}}"> --}}
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
            <a  href="{{route('listaAprendiz')}}" class="{{ $validat ? 'active' : '' }}">Estudiantes</a>
            @php
            if (request()->routeIs('listaProfesor') == true) {
                $validat = true;
            } else {
                $validat = false;
            }
        @endphp
            <a href="{{route('listaProfesor')}}" class="{{ $validat ? 'active' : '' }}" >Profesores</a>
            <a href="{{route('registro')}}">Registro</a>
            @php
            if (request()->routeIs('grupo') == true) {
                $validat = true;
            } else {
                $validat = false;
            }
        @endphp
            <a href="{{route('grupo')}}" class="{{ $validat ? 'active' : '' }}">Grupos</a>
            @php
            if (request()->routeIs('informe') == true) {
                $validat = true;
            } else {
                $validat = false;
            }
        @endphp
            <a href="{{route('informe')}}" class="{{ $validat ? 'active' : '' }}">Informes</a>
            @php
            if (request()->routeIs('historial') == true) {
                $validat = true;
            } else {
                $validat = false;
            }
        @endphp
            <a href="{{route('historial')}}" class="{{ $validat ? 'active' : '' }}">Historial</a>
        </div>
        <div class="conteUsuario">
            <div class="user">
                <span class="material-symbols-outlined">
                    person
                    </span>
                <a href="{{route('usuario')}}">{{$user->name}}</a>
            </div>
            <div class="logout">
                <a href="{{route('logout')}}">Cerrar Sesion</a>
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
        @yield('usuario')
        @yield('historial')
    </main>

  
</body>
</html>