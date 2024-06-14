<!DOCTYPE html>
<html>
<head>
    <title>Contraseña Restablecida</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #99BF51;
            text-align: center;
        }

        p {
            margin-bottom: 20px;
        }

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #99BF51;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .cta-button:hover{
            background-color: rgb(29, 198, 97);

        }
        
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contraseña Restablecida</h1>
        
        <p>Hola, <strong>{{$usuario->name}}</strong></p>
        
        <p>Tu contraseña ha sido restablecida exitosamente. La nueva contraseña es: <strong>{{ $newPassword }}</strong></p>
        <p>¿Sabes cúal es tu usuario de sesion?, tranquil@, es: <strong>{{ $usuario->usuario }}</strong></p>
        
        <p>Inicia sesión con esta nueva contraseña y cámbiala a una más segura desde tu perfil.</p>
        
        <a class="cta-button" href="{{ route('login') }}">Iniciar Sesión</a>

        <p class="footer">¡Tranquil@!, Mc-Studies protege tu seguridad</p>
    </div>
</body>
</html>

