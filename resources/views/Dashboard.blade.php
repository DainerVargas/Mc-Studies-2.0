<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <!-- PWA Meta Tags -->
    <meta name="description" content="Sistema de gestión académica para MC Language Studies">
    <meta name="theme-color" content="#4f46e5">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="MC Studies">

    <!-- App Icons -->
    <link rel="icon" type="image/png" href="{{ asset('Logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('Logo.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('Logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('Logo.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('Logo.png') }}">

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-DnEp5ElW.css') }}">
</head>

<body>
    @vite('resources/sass/app.scss')
    @php
        $user = Illuminate\Support\Facades\Auth::user();
    @endphp
    <header class="main-header fixed-header">
        <div class="header-container">
            <div class="conteImage">
                <a href="Lista-Aprendiz"><img src="/images/Logo.png" alt=""></a>
            </div>

            <button class="burger-menu" onclick="toggleMenu()">
                <span class="material-symbols-outlined">menu</span>
            </button>

            <nav class="nav-links" id="navLinks">
                <div class="mobile-header">
                    <span>Menú</span>
                    <button class="close-menu" onclick="toggleMenu()">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="links-group">
                    @if ($user->rol_id == 5)
                        <a href="{{ route('mis_hijos') }}"
                            class="{{ request()->routeIs('mis_hijos') || request()->routeIs('informacion') ? 'active' : '' }}">Mi(s)
                            Hijo(s)</a>
                        <a href="{{ route('actividades') }}"
                            class="{{ request()->routeIs('actividades') ? 'active' : '' }}">Actividades</a>
                        <a href="{{ route('reuniones') }}"
                            class="{{ request()->routeIs('reuniones') ? 'active' : '' }}" style="position: relative;">
                            Reunión
                            @php
                                if ($user->attendant) {
                                    $attendantMeetings = \App\Models\Reunion::where(
                                        'attendant_id',
                                        $user->attendant->id,
                                    )
                                        ->where('estado', 'pendiente')
                                        ->count();
                                } else {
                                    $attendantMeetings = 0;
                                }
                            @endphp
                            @if ($attendantMeetings > 0)
                                <span class="notification-badge">{{ $attendantMeetings }}</span>
                            @endif
                        </a>
                    @else
                        @php
                            $validat = request()->routeIs('listaAprendiz');
                        @endphp
                        <a href="{{ route('listaAprendiz') }}" class="{{ $validat ? 'active' : '' }}">Estudiantes</a>

                        @if (!isset($user->teacher_id))
                            @php
                                $validat = request()->routeIs('listaProfesor');
                            @endphp
                            <a href="{{ route('listaProfesor') }}"
                                class="{{ $validat ? 'active' : '' }}">Trabajadores</a>
                            <a href="{{ route('registro') }}">Registro</a>
                            @php
                                $validat = request()->routeIs('grupo');
                            @endphp
                            <a href="{{ route('grupo') }}" class="{{ $validat ? 'active' : '' }}">Grupos</a>
                            @php
                                $validat = request()->routeIs('historial');
                            @endphp
                            <a href="{{ route('historial') }}" class="{{ $validat ? 'active' : '' }}">Historial</a>
                            @php
                                $validat = request()->routeIs('informe');
                            @endphp
                            <a href="{{ route('informe') }}" class="{{ $validat ? 'active' : '' }}">Pagos</a>

                            @if ($user->rol_id != 4)
                                @php
                                    $validat = request()->routeIs('servicios');
                                @endphp
                                <a href="{{ route('servicios') }}" class="{{ $validat ? 'active' : '' }}">Caja</a>
                                @php
                                    $validat = request()->routeIs('reuniones');
                                @endphp
                                <a href="{{ route('reuniones') }}" class="{{ $validat ? 'active' : '' }}"
                                    style="position: relative;">
                                    Reuniones
                                    @php
                                        $pendingCount = \App\Models\Reunion::where('estado', 'pendiente')->count();
                                    @endphp
                                    @if ($pendingCount > 0)
                                        <span class="notification-badge">{{ $pendingCount }}</span>
                                    @endif
                                </a>
                            @endif
                        @else
                            @php
                                $validat = request()->routeIs('asistencia');
                            @endphp
                            <a href="{{ route('asistencias', $user->teacher_id) }}"
                                class="{{ $validat ? 'active' : '' }}">Registro de Asistencia</a>
                            @php
                                $validat = request()->routeIs('qualification');
                            @endphp
                            <a href="{{ route('qualification', $user->teacher_id) }}"
                                class="{{ $validat ? 'active' : '' }}">Registro de calificaciones</a>
                        @endif
                    @endif
                </div>

                <div class="conteUsuario">
                    <div class="user">
                        <span class="material-symbols-outlined">person</span>
                        @if ($user->rol_id == 4)
                            <a href="{{ route('usuario') }}">{{ $user->teacher->name }}</a>
                        @else
                            <a href="{{ route('usuario') }}">{{ $user->name }}</a>
                        @endif
                    </div>
                    <div class="logout">
                        <a href="{{ route('logout') }}">
                            <span class="material-symbols-outlined"
                                style="vertical-align: middle; font-size: 1.2rem; margin-right: 5px;">logout</span>
                            Cerrar Sesión
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <script>
        function toggleMenu() {
            const nav = document.getElementById('navLinks');
            nav.classList.toggle('active');
        }
    </script>

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
        @yield('send')
        @yield('qualification')
        @yield('registerHours')
        @if (
            !$__env->hasSection('listaAprendiz') &&
                !$__env->hasSection('informacion') &&
                !$__env->hasSection('listaProfesor') &&
                !$__env->hasSection('grupo') &&
                !$__env->hasSection('update') &&
                !$__env->hasSection('informe') &&
                !$__env->hasSection('estadoCuenta') &&
                !$__env->hasSection('usuario') &&
                !$__env->hasSection('historial') &&
                !$__env->hasSection('asistencia') &&
                !$__env->hasSection('servicios') &&
                !$__env->hasSection('send') &&
                !$__env->hasSection('qualification') &&
                !$__env->hasSection('registerHours'))
            {{ $slot ?? '' }}
        @endif

        <!-- PWA Install Prompt -->
        @include('components.pwa-install-prompt')
    </main>

    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('✅ Service Worker registrado:', registration.scope);

                        // Verificar actualizaciones cada 30 minutos
                        setInterval(() => {
                            registration.update();
                        }, 1800000);
                    })
                    .catch((error) => {
                        console.log('❌ Error al registrar Service Worker:', error);
                    });
            });

            // Manejar actualizaciones del service worker
            navigator.serviceWorker.addEventListener('controllerchange', () => {
                window.location.reload();
            });
        }

        // Detectar si la app está instalada
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            window.deferredPrompt = e;
            console.log('💡 La app puede ser instalada');
        });

        // Detectar cuando la app se instala
        window.addEventListener('appinstalled', () => {
            console.log('✅ App instalada exitosamente');
            window.deferredPrompt = null;
        });
    </script>

</body>

</html>
