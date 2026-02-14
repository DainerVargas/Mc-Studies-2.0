<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Login')</title>

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
    <link rel="stylesheet" href="{{ asset('build/assets/app-Be1cidhe.css') }}">
</head>
@vite('resources/sass/app.scss')

<!-- Service Worker Registration -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then((registration) => {
                    console.log('✅ Service Worker registrado:', registration.scope);
                })
                .catch((error) => {
                    console.log('❌ Error al registrar Service Worker:', error);
                });
        });
    }
</script>

<body>
    <main>
        @yield('login')
    </main>
</body>

</html>
