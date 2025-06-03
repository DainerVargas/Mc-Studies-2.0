<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe Profesores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .descarga {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 900px;
            margin: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #000;
        }

        .titulo {
            background-color: #009C91;
            color: white;
            font-size: 20px;
        }

        .subtitulo {
            font-weight: bold;
            font-size: 16px;
        }

        .fecha {
            font-style: italic;
        }

        .nodatos {
            text-align: center;
            font-weight: bold;
            color: red;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="descarga">
        <div class="container">
            <div class="content">
                @php
                    $total = 0;
                @endphp
                <table>
                    <thead>
                        <tr>
                            <th colspan="5" class="titulo">Informe Profesores</th>
                        </tr>
                        <tr>
                            <td colspan="5" class="subtitulo">MC Language studies</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="fecha">Fecha: {{ $fecha }}</td>
                        </tr>
                        <tr>
                            <th>No.</th>
                            <th>Profesor</th>
                            <th>Valor Pagado</th>
                            <th>Fecha de Pago</th>
                            <th>Periodo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                            $total = 0;
                        @endphp
                        @forelse ($informes as $informe)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $informe->teacher->name }}</td>
                                <td>${{ number_format($informe->abono, 0, ',', '.') }}</td>
                                @php
                                    $total += $informe->abono;
                                    $fecha = isset($informe->fecha) ? $informe->fecha : 'Sin fecha';
                                @endphp
                                <td>{{ $fecha }}</td>
                                <td>{{ $informe->periodo ?? 'No registrado'}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <p class="nodatos">No hay datos</p>
                                </td>
                            </tr>
                        @endforelse

                        <tr>
                            <td colspan="3"><strong>Total:</strong></td>
                            <td colspan="3"><strong>${{ number_format($total, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="footer">
                <p>Tu equipo {{ config('app.name') }}</p>
            </div>
        </div>
    </div>
</body>

</html>
