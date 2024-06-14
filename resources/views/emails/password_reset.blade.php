<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordatorio de Pago</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; color: #333; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <h1 style="color: #007bff;">¡Es hora de seguir aprendiendo!</h1>
        
        <p>Hola, <strong>{{$aprendiz->attendant->name}}</strong>,</p>
        
        <p>Queremos animarte a continuar apoyando a <strong>{{$aprendiz->name}} {{$aprendiz->apellido}}</strong> en su proceso de aprendizaje.</p>
        
        <p>Recuerda que cada día es una oportunidad para crecer y mejorar. Juntos, podemos alcanzar grandes logros.</p>

        <p style="font-size: 18px; color: #28a745;"><strong>No dejes que esta oportunidad pase de largo. ¡Sigue adelante y alcanza tus metas!</strong></p>

        <p>Para cualquier consulta o para discutir opciones de pago, no dudes en ponerte en contacto con nosotros. Estaremos encantados de ayudarte en todo lo que necesites.</p>

        <p style="font-style: italic; color: #666;">Atentamente,<br>El equipo de {{ config('app.name') }}</p>
    </div>

    <div style="margin-top: 20px; text-align: center;">
        <p style="font-size: 14px; color: #666;">Para contactarnos:</p>
        <p style="font-size: 14px; color: #007bff;">Teléfono:3173961175
        </p>
        <p style="font-size: 14px; color: #007bff;">Correo electrónico: info.mcstudies@gmail.com
        </p>
        <p style="font-size: 14px; color: #007bff;">Sitio web: <a href="http://www.mcstudies.com/ ">MC-Studies</a></p>
    </div>
    
</body>
</html>


