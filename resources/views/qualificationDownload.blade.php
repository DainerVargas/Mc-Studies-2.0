<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte Final Académico</title>
    <style>
        body {
            font-family: "Work Sans", sans-serif;
            color: #333;
            font-size: 12px;
            padding: 0;
            /* Sin padding global para evitar saltos */
        }

        .content {
            width: 80%;
            margin: 0 auto;
        }

        .header {
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header img {
            width: 200px;
            display: block;
            margin: 0 auto 20px auto;
        }

        .info_apprentice {
            background: #cdcdcd;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 12px;
        }

        h2 {
            color: #0e869c;
            font-size: 14px;
            margin-bottom: 5px;
        }

        p {
            text-align: justify;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .result-section {
            margin-top: 10px;
            font-size: 13px;
        }

        .result-section p {
            margin: 5px 0;
        }

        .approved {
            color: green;
            font-weight: bold;
        }

        .failed {
            color: red;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 5px;
            text-align: center;
        }

        th {
            background: #0e869c;
            color: #fff;
        }

        .table-container {
            margin-top: 10px;
        }

        .note {
            font-size: 11px;
            margin-top: 10px;
        }

        .page-break {
            page-break-before: always;
        }

        .full-page-img {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
</head>

<body>
    <!-- CONTENIDO PRINCIPAL - PÁGINA 1 -->
    <div class="content">
        <!-- Logo -->
        <div class="header">
            <img src="{{ public_path('Logo.png') }}" alt="Logo">
        </div>

        <!-- Datos del estudiante -->
        <div class="info_apprentice">
            <strong>Nombre:</strong> {{ $qualifications[0]->apprentice->name }}
            {{ $qualifications[0]->apprentice->apellido }}<br>
            {{-- <strong>Desde:</strong>
            {{ \Carbon\Carbon::parse($qualifications[0]->apprentice->fecha_inicio)->format('d/m/Y') }}
            &nbsp;&nbsp; --}}
            <strong>Fecha:</strong>
            {{ \Carbon\Carbon::parse($qualifications[0]->created_at)->format('d/m/Y') }}
        </div>

        <!-- Descripción nivel -->
        <section>
            <h2>✅ Nivel de inicio del módulo ({{ $semestre }} semestre):</h2>
            <p><strong>{{ $qualifications[0]->apprentice->level->name }}</strong></p>
            <p>{{ $qualifications[0]->apprentice->level->description }}</p>

            <h2>✅ Nivel para el segundo semestre:</h2>
            <p>Corresponde al nivel en el que el estudiante continuará durante la segunda etapa, de acuerdo con su
                rendimiento académico.</p>
        </section>

        @php
            $totalListening = 0;
            $totalSpeaking = 0;
            $totalReading = 0;
            $totalWriting = 0;

            $totalesExamen = [];

            foreach ($qualifications as $key => $qualification) {
                $totalListening += $qualification->listening;
                $totalSpeaking += $qualification->speaking;
                $totalReading += $qualification->reading;
                $totalWriting += $qualification->writing;

                if (!isset($totalesExamen[$key])) {
                    $totalesExamen[$key] = 0;
                }

                $totalesExamen[$key] +=
                    $qualification->listening +
                    $qualification->speaking +
                    $qualification->reading +
                    $qualification->writing;
            }

            foreach ($totalesExamen as $key => $total) {
                $totalesExamen[$key] = $total / 4;
            }

            $avgListening = $totalListening / count($qualifications);
            $avgSpeaking = $totalSpeaking / count($qualifications);
            $avgReading = $totalReading / count($qualifications);
            $avgWriting = $totalWriting / count($qualifications);

            $average = ($avgListening + $avgSpeaking + $avgReading + $avgWriting) / 4;
            $passed = $average >= 75;
        @endphp

        <div class="result-section">
            @if ($passed)
                <p class="approved">{{ $qualifications[0]->apprentice->level->aprobado }}</p>
            @else
                <p class="failed">{{ $qualifications[0]->apprentice->level->desaprobado }}</p>
            @endif
        </div>


        <div class="table-container">
            <h2>Desempeño preliminar</h2>
            <table>
                <thead>
                    <tr>
                        <th>Habilidad</th>
                        @foreach ($qualifications as $key => $q)
                            <th>Resultado {{ $key + 1 }}° examen</th>
                        @endforeach
                        <th>Consolidado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Listening</td>
                        @foreach ($qualifications as $q)
                            <td>{{ number_format($q->listening, 2) }}%</td>
                        @endforeach
                        <td>{{ number_format($avgListening, 2) }}%</td>
                    </tr>
                    <tr>
                        <td>Speaking</td>
                        @foreach ($qualifications as $q)
                            <td>{{ number_format($q->speaking, 2) }}%</td>
                        @endforeach
                        <td>{{ number_format($avgSpeaking, 2) }}%</td>
                    </tr>
                    <tr>
                        <td>Reading</td>
                        @foreach ($qualifications as $q)
                            <td>{{ number_format($q->reading, 2) }}%</td>
                        @endforeach
                        <td>{{ number_format($avgReading, 2) }}%</td>
                    </tr>
                    <tr>
                        <td>Writing</td>
                        @foreach ($qualifications as $q)
                            <td>{{ number_format($q->writing, 2) }}%</td>
                        @endforeach
                        <td>{{ number_format($avgWriting, 2) }}%</td>
                    </tr>
                    <tr>
                        <td><strong>Consolidado Final</strong></td>
                        @foreach ($totalesExamen as $promedioExamen)
                            <td><strong>{{ number_format($promedioExamen, 2) }}%</strong></td>
                        @endforeach
                        <td><strong>{{ number_format($average, 2) }}%</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p class="note">
            Nota: Es importante que el estudiante haya aprobado satisfactoriamente los módulos en el nivel indicado,
            con un promedio anual de al menos del 75% para avanzar al siguiente nivel.
        </p>
    </div>

    <!-- IMÁGENES EN PÁGINAS COMPLETAS -->
    <div class="page-break">
        <img class="full-page-img" src="{{ public_path('nivel.jpg') }}" alt="Nivel">
    </div>

    <div class="page-break">
        <img class="full-page-img" src="{{ public_path('info.jpg') }}" alt="Info">
    </div>

</body>

</html>
