<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte Grupal de Calificaciones</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #334155;
            margin: 0;
            padding: 20px;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #99BF51;
            padding-bottom: 15px;
        }

        .logo {
            width: 150px;
            margin-bottom: 10px;
        }

        h1 {
            color: #0f172a;
            font-size: 20px;
            margin: 0;
            text-transform: uppercase;
        }

        .meta-info {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            background: #f8fafc;
            padding: 10px;
            border-radius: 8px;
        }

        .meta-item {
            display: table-cell;
            width: 33%;
        }

        .meta-label {
            font-weight: bold;
            color: #64748b;
            display: block;
            font-size: 9px;
            text-transform: uppercase;
        }

        .meta-value {
            font-size: 12px;
            color: #0f172a;
            font-weight: 600;
        }

        /* Tabla de Estudiantes */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th {
            background-color: #99BF51;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            padding: 8px;
            font-size: 9px;
        }

        td {
            padding: 7px;
            border-bottom: 1px solid #e2e8f0;
            text-align: center;
        }

        .student-name {
            text-align: left;
            font-weight: 600;
        }

        /* Resumen Gráfico (Barras) */
        .summary-container {
            margin-top: 20px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 10px;
        }

        .summary-title {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #0f172a;
            border-left: 5px solid #99BF51;
            padding-left: 12px;
        }

        .skill-bar-row {
            margin-bottom: 15px;
            width: 100%;
        }

        .skill-table {
            width: 100%;
            border: none;
            margin-bottom: 5px;
        }

        .skill-table td {
            border: none;
            padding: 0;
            text-align: left;
            font-size: 12px;
        }

        .skill-name {
            font-weight: 600;
            color: #334155;
        }

        .skill-percent {
            font-weight: bold;
            color: #99BF51;
            text-align: right !important;
        }

        .bar-bg {
            background-color: #f1f5f9;
            height: 14px;
            border-radius: 7px;
            width: 100%;
            position: relative;
        }

        .bar-fill {
            height: 14px;
            background-color: #99BF51;
            border-radius: 7px;
            display: block;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-top: 15px;
        }

        .stat-card {
            display: table-cell;
            text-align: center;
            padding: 10px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: 800;
            color: #166534;
        }

        .stat-label {
            font-size: 10px;
            color: #15803d;
        }

        .footer {
            margin-top: 30px;
            font-size: 9px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>

<body>

    @php
        $avgListening = $qualifications->avg('listening');
        $avgSpeaking = $qualifications->avg('speaking');
        $avgReading = $qualifications->avg('reading');
        $avgWriting = $qualifications->avg('writing');

        $totalGeneral = ($avgListening + $avgSpeaking + $avgReading + $avgWriting) / 4;

        $studentsCount = $qualifications->count();
        $approvedCount = $qualifications
            ->filter(function ($q) {
                return ($q->listening + $q->speaking + $q->reading + $q->writing) / 4 >= 75;
            })
            ->count();
    @endphp

    <div class="header">
        <img src="{{ public_path('Logo.png') }}" class="logo">
        <h1>Informe Evaluativo Grupal</h1>
    </div>

    <div class="meta-info">
        <div class="meta-item">
            <span class="meta-label">Grupo</span>
            <span class="meta-value">{{ session('groupName') }}</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Periodo / Reporte</span>
            <span class="meta-value">{{ session('selectedResultName') }} (Semestre
                {{ session('selectedSemester') }})</span>
        </div>
        <div class="meta-item" style="text-align: right;">
            <span class="meta-label">Profesor</span>
            <span class="meta-value">{{ session('nameTeacher') }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="text-align: left; width: 35%;">Estudiante</th>
                <th style="width: 12%;">Listening</th>
                <th style="width: 12%;">Writing</th>
                <th style="width: 12%;">Reading</th>
                <th style="width: 12%;">Speaking</th>
                <th style="width: 12%;">Promedio</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($qualifications as $index => $q)
                @php
                    $promedio = ($q->listening + $q->writing + $q->reading + $q->speaking) / 4;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="student-name">{{ $q->apprentice->name ?? 'Estudiante no encontrado' }} {{ $q->apprentice->apellido ?? '' }}</td>
                    <td>{{ number_format($q->listening, 1) }}%</td>
                    <td>{{ number_format($q->writing, 1) }}%</td>
                    <td>{{ number_format($q->reading, 1) }}%</td>
                    <td>{{ number_format($q->speaking, 1) }}%</td>
                    <td style="font-weight: bold; color: {{ $promedio >= 75 ? '#166534' : '#b91c1c' }}">
                        {{ number_format($promedio, 1) }}%
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-container">
        <div class="summary-title">Resumen de Habilidades del Grupo</div>

        <div class="skill-bar-row">
            <table class="skill-table">
                <tr>
                    <td class="skill-name">Listening (Comprensión Auditiva)</td>
                    <td class="skill-percent">{{ number_format($avgListening, 1) }}%</td>
                </tr>
            </table>
            <div class="bar-bg">
                <div class="bar-fill" style="width: {{ $avgListening }}%;"></div>
            </div>
        </div>

        <div class="skill-bar-row">
            <table class="skill-table">
                <tr>
                    <td class="skill-name">Writing (Expresión Escrita)</td>
                    <td class="skill-percent">{{ number_format($avgWriting, 1) }}%</td>
                </tr>
            </table>
            <div class="bar-bg">
                <div class="bar-fill" style="width: {{ $avgWriting }}%;"></div>
            </div>
        </div>

        <div class="skill-bar-row">
            <table class="skill-table">
                <tr>
                    <td class="skill-name">Reading (Comprensión Lectora)</td>
                    <td class="skill-percent">{{ number_format($avgReading, 1) }}%</td>
                </tr>
            </table>
            <div class="bar-bg">
                <div class="bar-fill" style="width: {{ $avgReading }}%;"></div>
            </div>
        </div>

        <div class="skill-bar-row">
            <table class="skill-table">
                <tr>
                    <td class="skill-name">Speaking (Expresión Oral)</td>
                    <td class="skill-percent">{{ number_format($avgSpeaking, 1) }}%</td>
                </tr>
            </table>
            <div class="bar-bg">
                <div class="bar-fill" style="width: {{ $avgSpeaking }}%;"></div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card" style="width: 48%; margin-right: 4%;">
                <div class="stat-value">{{ number_format($totalGeneral, 1) }}%</div>
                <div class="stat-label">Promedio General del Grupo</div>
            </div>
            <div class="stat-card" style="width: 48%;">
                <div class="stat-value">{{ $approvedCount }} / {{ $studentsCount }}</div>
                <div class="stat-label">Estudiantes con Promedio Sugerido (+75%)</div>
            </div>
        </div>
    </div>

    <div class="footer">
        Informe generado automáticamente por Mc Studies &bull; {{ now()->format('d/m/Y H:i') }}
    </div>

</body>

</html>
