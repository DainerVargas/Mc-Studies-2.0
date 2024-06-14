<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
            margin: 0 auto;
            max-width: 600px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 150px;
        }

        .content {
            margin-bottom: 20px;
        }

        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="content">
            <p>Hola, <strong>{{$teacher->name}} {{$teacher->apellido}}</strong></p>
            @php
            $numero = date('m'); 
            $mes = '';
            switch ($numero) {
                case "01":
                    $mes = "Enero";
                    break;
                case "02":
                    $mes = "Febrero";
                    break;
                case "03":
                    $mes = "Marzo";
                    break;
                case "04":
                    $mes = "Abril";
                    break;
                case "05":
                    $mes = "Mayo";
                    break;
                case "06":
                    $mes = "Junio";
                    break;
                case "07":
                    $mes = "Julio";
                    break;
                case "08":
                    $mes = "Agosto";
                    break;
                case "09":
                    $mes = "Septiembre";
                    break;
                case "10":
                    $mes = "Octubre";
                    break;
                case "11":
                    $mes = "Noviembre";
                    break;
                case "12":
                    $mes = "Diciembre";
                    break;  
            }
            $nuevaFecha = date('d', strtotime('+4 days'));    

            @endphp
            <p>Nos complace informarte que hemos procesado tu pago correspondiente a la semana del {{date('d')}} al {{$nuevaFecha}} de {{ $mes }}.</p>
            <ul>
                <li><strong>Fecha de Pago:</strong> {{ date('d-m-Y') }}</li>
                <li><strong>Valor:</strong> ${{ $valor }} pesos.</li>
            </ul>
            <p>Gracias por tu dedicación y excelente trabajo en nuestra academia de aprendizaje de inglés. Si tienes
                alguna pregunta o necesitas más información, no dudes en ponerte en contacto con nosotros.</p>
            <p>Atentamente,<br>
                {{ config('app.name') }}<br>
                Academia de Aprendizaje de Inglés</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Academia de Aprendizaje de Inglés. Todos los derechos reservados.</p>
        </div>
    </div>
</body>

</html>
