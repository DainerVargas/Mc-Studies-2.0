<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }

        .header img {
            max-width: 120px;
            margin-bottom: 10px;
        }

        .info {
            text-align: center;
            font-size: 14px;
            color: #555;
        }

        .content {
            padding: 20px 0;
            font-size: 16px;
            color: #333;
        }

        .content ul {
            list-style: none;
            padding: 0;
        }

        .content li {
            background: #f8f8f8;
            margin: 8px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://aplicacion.mcstudies.com/Logo.png" alt="Logo">
            <div class="info">
                <p><strong>NIT:</strong> 901809528-9</p>
                <p><strong>Teléfono:</strong> 3173961175</p>
                <p><strong>Email:</strong> info@mcstudies.com</p>
            </div>
        </div>
        
        <div class="content">
            <p>Hola, <strong>{{$teacher->name}} {{$teacher->apellido}}</strong>,</p>
            <p>Nos complace informarte que hemos procesado tu pago.</p>
            <ul>
                <li><strong>Fecha de Pago:</strong> {{ date('d-m-Y') }}</li>
                <li><strong>Valor:</strong> ${{ number_format($valor, 0, ',', '.') }} pesos</li>
            </ul>
            <p>Gracias por tu dedicación y excelente trabajo en nuestra academia de aprendizaje de inglés. Si tienes alguna pregunta o necesitas más información, no dudes en ponerte en contacto con nosotros.</p>
            <p>Atentamente,</p>
            <p><strong>{{ config('app.name') }}</strong><br>Academia de Aprendizaje de Inglés</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Academia de Aprendizaje de Inglés. Todos los derechos reservados.</p>
        </div>
    </div>
</body>

</html>
