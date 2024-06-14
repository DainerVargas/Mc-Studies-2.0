<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Recibido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #05CCD1;
            margin: 0;
        }
        .content {
            color: #333333;
            font-size: 16px;
            line-height: 1.6;
        }
        .contact-info {
            margin-top: 20px;
            text-align: center;
        }
        .contact-info p {
            font-size: 14px;
            color: #007bff;
            margin-bottom: 5px;
        }
        .contact-info a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Gracias por registrarte!</h1>
            <p style="color: #959595;">Academia de Aprendizaje de Inglés MC-Studies</p>
        </div>
        <div class="content">
            <p>Hola, <strong>{{$aprendiz->attendant->name}} {{$aprendiz->attendant->apellido}}</strong>.</p>
            <p>Gracias por registrarte en nuestra academia de aprendizaje de inglés, MC-Studies. Hemos recibido tu registro y pronto nos pondremos en contacto contigo para discutir más detalles sobre nuestros programas y servicios.</p>
            <p>¡Esperamos con ansias poder ayudar a <strong>{{$aprendiz->name}} {{$aprendiz->apellido}} </strong> alcanzar sus metas de aprendizaje de inglés!</p>
        </div>
        <div class="contact-info">
            <p>Para contactarnos:</p>
            <p>Teléfono: <a href="tel:3173961175" style="color: #007bff;">317 396 1175</a></p>
            <p>Correo electrónico: <a href="mailto:info.mcstudies@gmail.com" style="color: #007bff;">info.mcstudies@gmail.com</a></p>
            <p>Sitio web: <a href="http://www.mcstudies.com/" style="color: #007bff;">MC-Studies</a></p>
        </div>
    </div>
</body>
</html>
