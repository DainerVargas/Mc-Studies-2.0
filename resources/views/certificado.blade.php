<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Certificado de Reconocimiento</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">

    <style>
        @page {
            margin: 40px 60px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f9f3;
            text-align: center;
            color: #333;
        }

        .content {
            width: 100%;
            padding: 40px 60px 40px 0px;
        }

        .logo {
            width: 130px;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 14px;
            color: #777;
            margin-top: 2px;
        }

        h1 {
            font-size: 38px;
            margin: 2px 0 0 0;
            color: #444;
            font-weight: 800;
            letter-spacing: 1px;
        }

        h2 {
            font-size: 22px;
            margin: 0;
            font-weight: 700;
            color: #444;
            padding: 0;
        }

        .text {
            max-width: 80%;
            margin: 20px auto;
            text-align: center;
            font-size: 14px;
            color: #555;
            line-height: 1.6;
            padding: 0;
            align-items: justify;
        }

        .student-name {
            font-weight: 400;
            font-family: 'great vibes', cursive;
            font-size: 50px;
            color: #00a9e0;
            margin: 20px 0;
        }

        .signatures {
            text-align: center;
            margin-top: 60px;
            width: 100%;
        }

        .signature {
            display: inline-block;
            vertical-align: top;
            text-align: center;
            margin: 0 60px;
        }


        .signature img {
            width: 130px;
            height: auto;
        }

        .signature .colunm {
            display: block;
            text-align: center;
            margin-top: 5px;
            line-height: 1.4;
        }

        .signature .colunm strong {
            display: block;
            font-size: 13px;
            color: #333;
        }

        .signature .colunm span {
            display: block;
            font-size: 12px;
            color: #555;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="content">
        <img src="{{ public_path('Logo.png') }}" alt="Logo" class="logo">
        <p class="subtitle">MC Language Studies otorga el siguiente:</p>

        <h1>CERTIFICATE</h1>
        <h2>OF RECOGNITION</h2>

        <p class="text">
            {{ $textReconocimiento }}
        </p>

        <h3 class="student-name">{{ $aprendiz->name }} {{ $aprendiz->apellido }}</h3>

        <div class="signatures">
            <div class="signature">
                <img src="{{ public_path($aprendiz->group->teacher->id.'.png') }}" alt="Firma Docente">
                <div class="colunm">
                    <strong>{{ $aprendiz->group->teacher->name }} {{ $aprendiz->group->teacher->apellido }}</strong>
                    <span>Docente</span>
                </div>
            </div>
            <div class="signature">
                <img src="{{ public_path('19.png') }}" alt="Firma Directora">
                <div class="colunm">
                    <strong>Suleica Builes</strong>
                    <span>Directora</span>
                </div>
            </div>
        </div>

        <p class="footer">Fonseca - La Guajira {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y') }}</p>
    </div>
</body>

</html>
