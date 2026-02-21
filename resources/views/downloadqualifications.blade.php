<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados Académicos</title>

    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 40px;
            background-color: #f5f7fa;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header img {
            width: 130px;
            height: auto;
        }

        .card {
            background: #ffffff;
            padding: 20px 25px;
            border-radius: 12px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .titulo {
            text-align: center;
            font-size: 1.6rem;
            color: #0a58ca;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .datos-aprendiz {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .datos-aprendiz span {
            display: block;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
        }

        table thead {
            background-color: #05CCD1;
            color: white;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            font-size: 14px;
            border-bottom: 1px solid #e8e8e8;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .promedio {
            font-weight: bold;
            color: #0a58ca;
        }

        .fila-total {
            background: #e8f5e9;
            font-weight: bold;
        }

        .promedio-final {
            color: #198754;
            font-weight: bold;
        }

        .observaciones {
            margin-top: 25px;
            padding: 15px;
            background: #fffef3;
            border-left: 4px solid #ffc107;
            border-radius: 6px;
        }

        .observaciones h4 {
            margin-top: 0;
            margin-bottom: 8px;
            color: #b8860b;
        }
    </style>
</head>

<body>

    <!-- LOGO -->
    <div class="header">
        @if (isset($aprendiz))
            <img src="https://aplicacion.mcstudies.com/Logo.png" alt="Logo">
        @else
            <img src="{{ public_path('Logo.png') }}" alt="Logo">
        @endif
    </div>

    <!-- TARJETA CONTENEDORA -->
    <div class="card">

        <h2 class="titulo">Resultados Académicos</h2>


        <div class="datos-aprendiz">
            <span><strong>Estudiante:</strong> {{ $qualifications[0]->apprentice->name }}
                {{ $qualifications[0]->apprentice->apellido }}</span>
            <span><strong>Profesor:</strong> {{ $qualifications[0]->teacher->name }}
                {{ $qualifications[0]->teacher->apellido }}</span>
            <span><strong>Grupo:</strong> {{ $qualifications[0]->group->name ?? 'Sin Grupo' }}</span>
        </div>

        <!-- TABLA -->
        <table>
            <thead>
                <tr>
                    <th>Resultado</th>
                    <th>Listening</th>
                    <th>Reading</th>
                    <th>Speaking</th>
                    <th>Writing</th>
                    <th>Promedio</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $totalListening = 0;
                    $totalReading = 0;
                    $totalSpeaking = 0;
                    $totalWriting = 0;
                    $count = $qualifications->count();
                @endphp

                @forelse ($qualifications as $qualification)
                    @php
                        $promedioFila =
                            ($qualification->listening +
                                $qualification->reading +
                                $qualification->speaking +
                                $qualification->writing) /
                            4;

                        $totalListening += $qualification->listening;
                        $totalReading += $qualification->reading;
                        $totalSpeaking += $qualification->speaking;
                        $totalWriting += $qualification->writing;

                        $resName =
                            $qualification->resultado == 'final'
                                ? 'Calculado'
                                : 'Resultado ' . $qualification->resultado;
                    @endphp

                    <tr>
                        <td style="text-align: left; padding-left: 20px;">
                            <strong style="color: #0a58ca;">{{ $resName }}</strong>
                        </td>
                        <td>{{ number_format($qualification->listening, 1) }}</td>
                        <td>{{ number_format($qualification->reading, 1) }}</td>
                        <td>{{ number_format($qualification->speaking, 1) }}</td>
                        <td>{{ number_format($qualification->writing, 1) }}</td>
                        <td class="promedio" style="color: {{ $promedioFila >= 75 ? '#198754' : '#dc3545' }}">
                            {{ number_format($promedioFila, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Sin resultados</td>
                    </tr>
                @endforelse

                @if ($count > 0)
                    <tr class="fila-total">
                        <td>Promedio Global</td>
                        <td>{{ number_format($totalListening / $count, 2) }}</td>
                        <td>{{ number_format($totalReading / $count, 2) }}</td>
                        <td>{{ number_format($totalSpeaking / $count, 2) }}</td>
                        <td>{{ number_format($totalWriting / $count, 2) }}</td>
                        <td class="promedio-final">
                            {{ number_format(($totalListening + $totalReading + $totalSpeaking + $totalWriting) / ($count * 4), 2) }}
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>

        <div class="observaciones">
            <h4>Observaciones</h4>
            @foreach ($qualifications as $qualification)
                @if ($qualification->observacion)
                    <div style="margin-bottom: 5px; font-size: 13px;">
                        <strong>{{ $qualification->resultado == 'final' ? 'Final' : 'Periodo ' . $qualification->resultado }}:</strong>
                        {{ $qualification->observacion }}
                    </div>
                @endif
            @endforeach
            @if ($qualifications->whereNotNull('observacion')->where('observacion', '!=', '')->isEmpty())
                <p style="font-size: 13px; color: #666;">No hay observaciones registradas para este periodo.</p>
            @endif
        </div>

    </div>

</body>

</html>
