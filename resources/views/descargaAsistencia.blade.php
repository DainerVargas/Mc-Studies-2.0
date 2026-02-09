<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Descarga de Asistencia</title>
</head>
<style>
    body {
        font-family: 'DejaVu Sans', sans-serif;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-bottom: 2px solid #ddd;
    }

    .logo img {
        height: 80px;
    }

    .info {
        text-align: right;
        margin-top: -80px;
    }

    .info p {
        margin: 5px 0;
        color: #444;
    }

    .info span {
        font-weight: bold;
    }

    .container {
        padding: 20px;
    }

    .student-info {
        margin-bottom: 20px;
        padding: 10px;
        background: #f7f7f7;
        border-radius: 5px;
    }

    .student-info p {
        margin: 5px 0;
        margin-top: 20px;
    }

    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    th {
        background: #05CCD1;
        color: white;
    }

    .total-row {
        background: #99BF51;
        font-weight: bold;
    }
</style>

<body>
    <header>
        <div class="logo">
            <img src="{{ public_path('Logo.png') }}" alt="Logo">
        </div>
        <div class="info">
            <p><span>NIT:</span> 901809528-9</p>
            <p><span>Teléfono:</span> 3173961175</p>
            <p><span>Email:</span> info@mcstudies.com</p>
        </div>
    </header>

    <div class="container">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Estudiantes</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asistencias as $index => $asistencia)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $asistencia->apprentice->name }} {{ $asistencia->apprentice->apellido }}</td>
                            <td>{{ $asistencia->fecha }}</td>
                            @php
                                $color = '';
                                if ($asistencia->estado == 'presente') {
                                    $color = 'green';
                                } elseif ($asistencia->estado == 'ausente') {
                                    $color = 'orange';
                                } elseif ($asistencia->estado == 'tarde') {
                                    $color = 'red';
                                }

                            @endphp
                            <td style="color: {{ $color }}"">{{ $asistencia->estado }}</td>
                            <td>{{ $asistencia->observaciones ?? 'No tiene ninguna observacion' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</body>

</html>
