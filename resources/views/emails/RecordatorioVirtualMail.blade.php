<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordatorio de Clase Virtual</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 8px;
        }
        .header {
            background-color: #05CCD1;
            padding: 10px 20px;
            color: #fff;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
        }
        .details {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .details ul {
            list-style: none;
            padding: 0;
        }
        .details li {
            margin-bottom: 10px;
            color: #959595;
        }
        .details li strong {
            color: #333;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #99BF51;
            color: #fff;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Recordatorio de Clase Virtual</h1>
        </div>
        <div class="content">
            <p>Hola {{ $aprendiz->attendant->name}},</p>
            <p>Este es un recordatorio sobre la clase virtual de inglés para {{ $aprendiz->name }} {{ $aprendiz->apellido }} qué se llevará a cabo este miércoles.</p>

            <div class="details">
                <p><strong>Detalles de la clase:</strong></p>
                <ul>
                    <li><strong>Día:</strong> Miércoles</li>
                    <li><strong>Hora:</strong> 3:00</li>
                    <li><strong>Plataforma:</strong> Nombre de la plataforma</li>
                </ul>
            </div>

            <p>Por favor asegúrese de que {{ $aprendiz->name }} esté preparado y tenga todo lo necesario para la clase. Si tiene alguna pregunta o necesita asistencia, no dude en contactarnos.</p>
            <p>¡Esperamos ver a {{ $aprendiz->name }} {{ $aprendiz->apellido }} en la clase!</p>
        </div>
        <div class="footer">
            <p>Saludos cordiales,</p>
            <p>Tu equipo {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
