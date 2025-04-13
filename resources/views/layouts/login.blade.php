@extends('index')
@section('title', 'Login')
@section('login')
    <div class="conteLogin">
        <div class="conteImagen">
            <img src="/images/LoginImage.jpg" alt="">
            <div class="background">
            </div>
            <div class="text">
                <h3>Welcome To Back!</h3>
                <p>Recuerda que cada acción que tomes ayuda a mejorar la experiencia de los usuarios.
                    ¡Sigamos avanzando juntos!
                </p>
            </div>
        </div>
        <div class="conteFormLogin">
            <div class="infoLogo">
                <img class="logo" src="/images/Logo.png" alt="Logo de la academia">
                <p>Sing in to MC Studies</p>
            </div>
            <form action="{{ route('loginPost') }}" method="post">
                @csrf
                <div class="conte">
                    <input class="input" type="text" name="usuario" placeholder="Usuario" value="{{ old('usuario') }}">
                    <span class="material-symbols-outlined absolute">
                        person
                    </span>
                    @error('usuario')
                        <small class="errors">{{ $message }}</small>
                    @enderror
                </div>
                <div class="conte contePassword">
                    <input class="input" id="password" type="password" name="password" placeholder="Contraseña"
                        value="{{ old('password') }}">
                    <span class="material-symbols-outlined absolute">
                        password
                    </span>
                    @error('password')
                        <small class="errors">{{ $message }}</small>
                    @enderror
                    {{-- <span class="material-symbols-outlined show" id="eye"> visibility_off </span> --}}
                </div>
                <a class="forgot" href="/Recuperar-Contraseña">¿Haz olvidado la contraseña?</a>
                <div class="conteButton">
                    <button class="btnLogin" type="submit">INGRESAR</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const eye = document.getElementById('eye');
        const password = document.getElementById('password');
        let count = 0;
        eye.addEventListener('click', () => {
            count++;
            if (count === 1) {
                eye.innerHTML = "visibility";
                password.type = "text";
            } else {
                eye.innerHTML = "visibility_off";
                password.type = "password";
                count = 0;
            }
        });
    </script>
@endsection
