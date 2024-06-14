<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Aprendiz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .header,
        .footer {
            text-align: center;
            background-color: #05CCD1;
            color: #fff;
            padding: 10px 0;
        }

        .content {
            padding: 20px;
            background-color: #f9f9f9;
        }

        .content h2 {
            color: #99BF51;
        }

        .content p {
            margin: 10px 0;
        }

        .details {
            margin-top: 20px;
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 8px;
        }

        .details p {
            margin: 5px 0;
            color: #959595;
        }

        .details p strong {
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Información del Aprendiz</h1>
        </div>
        <div class="content">
            <h2>Detalles del Aprendiz</h2>
            <p><strong>Nombre:</strong> {{ $aprendiz->name }} {{ $aprendiz->apellido }}</p>
            <p><strong>Edad:</strong> {{ $aprendiz->edad }}</p>
            <p><strong>Fecha de Nacimiento:</strong> {{ $aprendiz->fecha_nacimiento }}</p>
            <p><strong>Modalidad:</strong> {{ $aprendiz->modality->name }}</p>
        </div>
        <div class="details">
            <h2>Detalles del Acudiente</h2>
            <p><strong>Nombre:</strong> {{ $aprendiz->attendant->name }} {{ $aprendiz->attendant->apellido }}</p>
            <p><strong>Email:</strong> {{ $aprendiz->attendant->email }}</p>
            <p><strong>Teléfono:</strong> {{ $aprendiz->attendant->telefono }}</p>
        </div>
        <div class="footer">
            <p>Tu equipo {{ config('app.name') }}</p>
        </div>
    </div>
</body>

</html>
