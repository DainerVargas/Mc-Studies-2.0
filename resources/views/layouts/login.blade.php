@extends('index')
@section('title', 'Login')
@section('login')
    <div class="lp-login-container">
        {{-- Panel Izquierdo: Imagen y Bienvenida --}}
        <div class="lp-image-panel">
            <img src="/images/LoginImage.jpg" alt="Estudiante aprendiendo">
            <div class="lp-overlay">
                <h3>Welcome To Back!</h3>
                <p>Recuerda que cada acción que tomes ayuda a mejorar la experiencia de los usuarios. ¡Sigamos avanzando
                    juntos!</p>
            </div>
        </div>

        {{-- Panel Derecho: Formulario de Login --}}
        <div class="lp-form-panel">
            <div class="lp-login-card">
                <div class="lp-logo-box">
                    <img src="/images/Logo.png" alt="MC Language Studies Logo">
                    <h2>Sing in to MC Studies</h2>
                </div>

                <form action="{{ route('loginPost') }}" method="post">
                    @csrf
                    <div class="lp-input-wrapper">
                        <input type="text" name="usuario" placeholder="Usuario" value="{{ old('usuario') }}" required
                            autocomplete="username">
                        <span class="material-symbols-outlined">person</span>
                        @error('usuario')
                            <span class="lp-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="lp-input-wrapper">
                        <input id="password" type="password" name="password" placeholder="Contraseña" required
                            autocomplete="current-password">
                        <span class="material-symbols-outlined">password</span>
                        @error('password')
                            <span class="lp-error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <a class="lp-forgot-link" href="/Recuperar-Contraseña">¿Haz olvidado la contraseña?</a>

                    <button class="lp-btn-submit" type="submit">INGRESAR</button>
                </form>
            </div>
        </div>
    </div>
@endsection
