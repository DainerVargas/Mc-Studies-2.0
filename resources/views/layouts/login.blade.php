@extends('index')
@section('title', 'Login')
@section('login')
    <div class="conteLogin">
        <div class="conteFormLogin">
            <div class="infoLogo">
                <img class="logo" src="/images/Logo.png" alt="Logo de la academia">
                <p>Sing in to your account</p>
            </div>
            <form action="{{ route('loginPost') }}" method="post">
                @csrf
                <div class="conteInput">
                    <input class="input" type="text" name="usuario" placeholder="user" value="{{ old('usuario') }}">
                    @error('usuario')
                        <small class="errors">{{ $message }}</small>
                    @enderror
                    <label class="label" for="">Usuario</label>
                </div>
                <div class="conteInput contePassword">
                    <input class="input" id="password" type="password" name="password" placeholder="password"
                        value="{{ old('password') }}">
                    @error('password')
                        <small class="errors">{{ $message }}</small>
                    @enderror
                    <span class="material-symbols-outlined show" id="eye"> visibility_off </span>
                    <label class="label" for="">Contraseña</label>
                </div>
                <a class="forgot" href="/Recuperar-Contraseña">¿Haz olvidado la contraseña?</a>
                <div class="conteButton">
                    <button class="btnLogin" type="submit">Iniciar Sesion</button>
                </div>
            </form>
        </div>
        <div class="conteImagen">
            <img src="/images/imagenLogin.png" alt="">
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
