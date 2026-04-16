<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #4f46e5;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 30px;
        }

        .footer {
            background-color: #f9fafb;
            color: #6b7280;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            border-top: 1px solid #e5e7eb;
        }

        .activity-details {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }

        .label {
            font-weight: bold;
            color: #4f46e5;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4f46e5;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>MC Studies</h1>
        </div>
        <div class="content">
            <h2>Hola, {{ $studentName }}!</h2>
            <p>Tu profesor ha revisado tu actividad y ha dejado una nueva observacion y calificacion.</p>

            <div class="activity-details">
                <p><span class="label">Actividad:</span> {{ $activity->titulo }}</p>
                <p><span class="label">Calificacion:</span> {{ $activity->calificacion }}</p>
                <p><span class="label">Observacion:</span></p>
                <p>{{ $activity->comentario }}</p>
            </div>

            <p>Puedes ver más detalles ingresando a la plataforma.</p>

            <a href="https://mcstudies.comercioguajiro.com" class="button">Ir a la Plataforma</a>

            <p>Saludos,<br>El equipo de MC Studies</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} MC Studies. Todos los derechos reservados.
        </div>
    </div>
</body>

</html>
