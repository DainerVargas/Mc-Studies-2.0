<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RECUPERAR CONTRASEÑAS</title>
    <link rel="stylesheet" href="{{asset('build/assets/app-Be1cidhe.css')}}">
</head>

<body class="forgotBody">
    <div class="conteLogin">
        <div class="conteFormLogin">
            <div class="infoLogo">
                <img class="logo" src="/images/Logo.png" alt="Logo de la academia">
                <p>Recupera tu contraseña</p>
            </div>
            <form action="{{ route('forgotPassword') }}" method="post">
                @csrf
                <div class="conteInput">
                    <input class="input" type="text" name="email" placeholder="user" value="{{ old('email') }}">
                    @error('email')
                        <small class="errors">{{ $message }}</small>
                    @enderror
                    @error('message')
                        <small class="errors" style="color:green">{{ $message }}</small>
                    @enderror
                    <label class="label" for="">Email</label>

                </div>

                <div class="conteButton">
                    <button class="btnLogin" id="top" type="submit">Recuperar Contraseña</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
