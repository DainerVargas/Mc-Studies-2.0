@extends('index')
@section('title', 'Recuperar Contraseña')
@section('login')
    <div class="lp-login-container">
        {{-- Panel Izquierdo: Imagen y Bienvenida --}}
        <div class="lp-image-panel">
            <img src="/images/LoginImage.jpg" alt="Recuperación de cuenta">
            <div class="lp-overlay">
                <h3>¿Olvidaste tu acceso?</h3>
                <p>No te preocupes, ingresa tu correo electrónico y te enviaremos las instrucciones para que puedas volver a
                    entrar.</p>
            </div>
        </div>

        {{-- Panel Derecho: Formulario de Recuperación --}}
        <div class="lp-form-panel">
            <div class="lp-login-card">
                <div class="lp-logo-box">
                    <img src="/images/Logo.png" alt="MC Language Studies Logo">
                    <h2>Recupera tu contraseña</h2>
                </div>

                <form action="{{ route('forgotPassword') }}" method="post">
                    @csrf
                    <div class="lp-input-wrapper">
                        <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}"
                            required autocomplete="email">
                        <span class="material-symbols-outlined">mail</span>

                        @error('email')
                            <span class="lp-error-text">{{ $message }}</span>
                        @enderror

                        @if (session('messageSuccess'))
                            <span class="lp-success-text">{{ session('messageSuccess') }}</span>
                        @endif
                    </div>

                    <button class="lp-btn-submit" type="submit">ENVIAR INSTRUCCIONES</button>

                    <a class="lp-forgot-link" href="{{ route('login') }}" style="margin-top: 1rem;">
                        Volver al inicio de sesión
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
