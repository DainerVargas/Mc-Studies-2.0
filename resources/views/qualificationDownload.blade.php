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

        /* Estilos para tarjetas de actividades (añadido para consistencia) */
        .cards-summary {
            width: 100%;
            margin-bottom: 20px;
            display: block;
        }

        .cards-table {
            width: 100%;
            border: none;
            border-collapse: separate;
            border-spacing: 15px 0;
        }

        .cards-table td {
            border: none;
            padding: 0;
            width: 50%;
        }

        .card-custom {
            background: #f2f2f2;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .card-custom .title {
            font-size: 13px;
            font-weight: bold;
            color: #444;
            margin-bottom: 5px;
        }

        .card-custom .subtitle {
            font-size: 10px;
            color: #777;
            margin: 0;
            font-weight: normal;
        }

        .card-custom .number {
            font-size: 18px;
            background-color: white;
            border-radius: 6px;
            padding: 5px;
            margin-top: 8px;
            display: inline-block;
            width: 80%;
        }

        .greenA {
            color: #6bb44b;
            font-weight: bold;
        }

        .black {
            color: #333;
            font-weight: normal;
        }

        .card-custom .label {
            display: block;
            font-size: 10px;
            color: #888;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    @php
        use App\Models\AssignedActivity;
        use App\Models\AcademicActivity;
        use Carbon\Carbon;

        $keywords = ['worksheet', 'pelicula', 'movie', 'serie', 'series'];
        // Priorizamos el semestre de la sesión, si no existe usamos el guardado en el objeto
        $semester = (int) (session('selectedSemester') ?? $qualifications[0]->semestre ?? 1);
        $year = (int) (session('selectedYear') ?? $qualifications[0]->year ?? date('Y'));

        // Función para calcular actividades Live
        $getLiveCounts = function ($q) use ($keywords, $semester, $year) {
            $result = (int) $q->resultado;
            $groupId = $q->group_id;
            $studentId = $q->apprentice_id;
            $startDate = null; $endDate = null;

            if ($semester == 1) {
                if ($result == 1) { $startDate = Carbon::createFromDate($year, 2, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 3, 31)->endOfDay(); }
                elseif ($result == 2) { $startDate = Carbon::createFromDate($year, 4, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 4, 30)->endOfDay(); }
                elseif ($result == 3) { $startDate = Carbon::createFromDate($year, 5, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 5, 31)->endOfDay(); }
            } else {
                if ($result == 1) { $startDate = Carbon::createFromDate($year, 8, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 9, 30)->endOfDay(); }
                elseif ($result == 2) { $startDate = Carbon::createFromDate($year, 10, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 10, 31)->endOfDay(); }
                elseif ($result == 3) { $startDate = Carbon::createFromDate($year, 11, 1)->startOfDay(); $endDate = Carbon::createFromDate($year, 11, 30)->endOfDay(); }
            }

            $asigAct = 0; $asigWork = 0; $entAct = 0; $entWork = 0;
            if ($startDate) {
                $baseAsig = AssignedActivity::whereHas('groups', function ($g) use ($groupId) {
                    $g->where('groups.id', $groupId);
                })->whereBetween('assigned_activities.created_at', [$startDate, $endDate]);
                $asigWork = (clone $baseAsig)->where(function ($g) use ($keywords) { foreach ($keywords as $word) { $g->orWhere('titulo', 'like', "%{$word}%"); } })->count();
                $asigAct = (clone $baseAsig)->where(function ($g) use ($keywords) { foreach ($keywords as $word) { $g->where('titulo', 'not like', "%{$word}%"); } })->count();

                $baseEnt = AcademicActivity::where('apprentice_id', $studentId)->whereBetween('fecha', [$startDate, $endDate]);
                $entWork = (clone $baseEnt)->where(function ($g) use ($keywords) { foreach ($keywords as $word) { $g->orWhere('titulo', 'like', "%{$word}%"); } })->count();
                $entAct = (clone $baseEnt)->where(function ($g) use ($keywords) { foreach ($keywords as $word) { $g->where('titulo', 'not like', "%{$word}%"); } })->count();
            }
            return (object) ['asigAct' => $asigAct, 'entAct' => $entAct, 'asigWork' => $asigWork, 'entWork' => $entWork];
        };

        // Recalcular totales live para el resumen superior
        $totalLiveActAsig = 0; $totalLiveActEnt = 0;
        $totalWorkAsig = 0; $totalWorkEnt = 0;
        foreach ($qualifications as $q) {
            $c = $getLiveCounts($q);
            $totalLiveActAsig += $c->asigAct; $totalLiveActEnt += $c->entAct;
            $totalWorkAsig += $q->worksheet_asignados; $totalWorkEnt += $q->worksheet_entregados;
        }
    @endphp

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

            $totalActividadesAsignadas = 0;
            $totalActividadesEntregadas = 0;
            $totalWorksheetsAsignados = 0;
            $totalWorksheetsEntregados = 0;

            $totalesExamen = [];

            foreach ($qualifications as $key => $qualification) {
                $totalListening += $qualification->listening;
                $totalSpeaking += $qualification->speaking;
                $totalReading += $qualification->reading;
                $totalWriting += $qualification->writing;

                $totalActividadesAsignadas += $qualification->actividades_asignados;
                $totalActividadesEntregadas += $qualification->actividades_entregados;
                $totalWorksheetsAsignados += $qualification->worksheet_asignados;
                $totalWorksheetsEntregados += $qualification->worksheet_entregados;

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

        <!-- Resumen de Actividades y Worksheets -->
        <div class="cards-summary">
            <table class="cards-table">
                <tr>
                    <td>
                        <div class="card-custom">
                            <div class="title">Worksheet entregados</div>
                            <p class="subtitle">(Películas y series asignadas)</p>
                            <div class="number">
                                <span class="greenA">{{ $totalWorkEnt }}</span>
                                <span class="black">/ {{ $totalWorkAsig }}</span>
                            </div>
                            <span class="label">COMPLETADAS</span>
                        </div>
                    </td>
                    <td>
                        <div class="card-custom">
                            <div class="title">Actividades entregadas</div>
                            <p class="subtitle">(Plataforma de Richmond)</p>
                            <div class="number">
                                <span class="greenA">{{ $totalLiveActEnt }}</span>
                                <span class="black">/ {{ $totalLiveActAsig }}</span>
                            </div>
                            <span class="label">COMPLETADAS</span>
                        </div>
                    </td>
                </tr>
            </table>
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
                        <td>Actividades Asig./Ent.</td>
                        @foreach ($qualifications as $q)
                            @php $c = $getLiveCounts($q); @endphp
                            <td>{{ $c->asigAct }} / {{ $c->entAct }}</td>
                        @endforeach
                        <td>{{ $totalLiveActAsig }} / {{ $totalLiveActEnt }}</td>
                    </tr>
                    <tr>
                        <td>Worksheets Asig./Ent.</td>
                        @foreach ($qualifications as $q)
                            <td>{{ $q->worksheet_asignados }} / {{ $q->worksheet_entregados }}</td>
                        @endforeach
                        <td>{{ $totalWorkAsig }} / {{ $totalWorkEnt }}</td>
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

            @if ($qualifications[0]->observacion)
                <div style="margin-top: 20px;">
                    <h2>Observaciones:</h2>
                    <p>{{ $qualifications[0]->observacion }}</p>
                </div>
            @endif
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
