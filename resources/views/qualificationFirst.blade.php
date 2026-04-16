<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte Académico</title>
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
            width: 100%;
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

        .result-section p {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 1rem;
        }

        .approved {
            color: green;
        }

        .failed {
            color: red;
        }

        .range-container {
            font-family: 'Nunito', sans-serif;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.08);
        }

        .range-group {
            margin-bottom: 2rem;
        }

        .range-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
        }

        .range-bar {
            appearance: none;
            width: 50%;
            height: 10px;
            border-radius: 5px;
            background: linear-gradient(to right, #4CAF50, #2196F3);
            outline: none;
        }

        .range-bar::-webkit-slider-thumb {
            appearance: none;
            width: 20px;
            height: 20px;
            background: #fff;
            border: 2px solid #2196F3;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
        }

        .consolidated {
            background: #e9f7ef;
            padding: 1rem;
            border: 2px dashed #2ecc71;
            border-radius: 10px;
            margin-top: 2rem;
        }

        .note {
            font-size: 11px;
            margin-top: 10px;
            text-align: center;
        }

        .page-break {
            page-break-before: always;
        }

        .full-page-img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* DISEÑO DE TARJETAS DE RESUMEN (PREMIUM) */
        .cards-summary {
            width: 100%;
            margin-bottom: 20px;
        }

        .cards-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 15px 0;
            margin: 0 -15px;
        }

        .card-custom {
            background: #fff;
            padding: 15px;
            border-radius: 12px;
            border-left: 5px solid #99BF51;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .card-custom .title {
            font-weight: 800;
            font-size: 14px;
            color: #0e869c;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .card-custom .subtitle {
            font-size: 10px;
            color: #666;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .card-custom .number {
            font-size: 24px;
            font-weight: 900;
            margin-bottom: 5px;
        }

        .card-custom .greenA { color: #99BF51; }
        .card-custom .black { color: #333; }

        .card-custom .label {
            font-size: 9px;
            color: #888;
            font-weight: bold;
            display: block;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    @php
        $skills = ['Listening', 'Speaking', 'Reading', 'Writing'];
    @endphp
    <div class="content">
        <div class="header">
            <img src="{{ public_path('headerReporte.png') }}" alt="Logo">
        </div>

        <div class="info_apprentice">
            <strong>Nombre:</strong> {{ $qualifications[0]->apprentice->name }}
            {{ $qualifications[0]->apprentice->apellido }}<br>
           {{-- <strong>Desde:</strong>
            {{ \Carbon\Carbon::parse($qualifications[0]->apprentice->fecha_inicio)->format('d/m/Y') }}
            &nbsp;&nbsp; --}}
            <strong>Fecha:</strong>
            {{ \Carbon\Carbon::parse($qualifications[0]->created_at)->format('d/m/Y') }}
        </div>

        @php
            use App\Models\AssignedActivity;
            use App\Models\AcademicActivity;
            use Carbon\Carbon;

            $keywords = ['worksheet', 'pelicula', 'movie', 'serie', 'series'];
            // Detectar semestre desde la sesión o desde el modelo
            $semester = (int) (session('selectedSemester') ?? $qualifications[0]->semestre);
            $year = (int) (session('selectedYear') ?? $qualifications[0]->year ?? date('Y'));

            // Función para calcular actividades Live para una calificación dada
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

                $asignadasAct = 0; $entregadasAct = 0;
                if ($startDate) {
                    $asignadasAct = AssignedActivity::whereHas('groups', function ($g) use ($groupId) {
                        $g->where('groups.id', $groupId);
                    })->whereBetween('assigned_activities.created_at', [$startDate, $endDate])
                      ->where(function ($g) use ($keywords) { foreach ($keywords as $word) { $g->where('titulo', 'not like', "%{$word}%"); } })
                      ->count();

                    $entregadasAct = AcademicActivity::where('apprentice_id', $studentId)
                      ->whereBetween('fecha', [$startDate, $endDate])
                      ->where(function ($g) use ($keywords) { foreach ($keywords as $word) { $g->where('titulo', 'not like', "%{$word}%"); } })
                      ->count();
                }

                return (object) [
                    'asigAct' => $asignadasAct,
                    'entAct' => $entregadasAct,
                    'asigWork' => $q->worksheet_asignados, // Estáticos
                    'entWork' => $q->worksheet_entregados, // Estáticos
                ];
            };

            $liveCounts = $getLiveCounts($qualifications[0]);
        @endphp

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

            $count = max(count($qualifications), 1);
            $avgListening = $totalListening / $count;
            $avgSpeaking = $totalSpeaking / $count;
            $avgReading = $totalReading / $count;
            $avgWriting = $totalWriting / $count;

            $average = ($avgListening + $avgSpeaking + $avgReading + $avgWriting) / 4;
            $passed = $average >= 75;

            $skillsAvg = [
                'listening' => $avgListening,
                'speaking' => $avgSpeaking,
                'reading' => $avgReading,
                'writing' => $avgWriting,
            ];

            $labels = [
                'listening' => 'listening',
                'speaking' => 'speaking',
                'reading' => 'reading',
                'writing' => 'writing',
            ];

            $desc = $skillsAvg;
            arsort($desc);
            $descKeys = array_keys($desc);

            $asc = $skillsAvg;
            asort($asc);
            $ascKeys = array_keys($asc);

            if ($passed) {
                $keys = array_slice($descKeys, 0, 2);
            } else {
                $keys = array_slice($ascKeys, 0, 2);
            }

            $skill1 = $labels[$keys[0]] ?? '';
            $skill2 = $labels[$keys[1]] ?? '';
        @endphp


        <div class="result-section">
            @if ($passed)
                <p class="approved">
                    El estudiante ha presentado muy buenos resultados, en especial las habilidades de
                    <strong>{{ $skill1 }}</strong> y <strong>{{ $skill2 }}</strong>.
                </p>
            @else
                <p class="failed">
                    El estudiante necesita reforzar un poco más las habilidades de
                    <strong>{{ $skill1 }}</strong> y <strong>{{ $skill2 }}</strong>.
                </p>
            @endif
        </div>

        <div class="cards-summary">
            <table class="cards-table">
                <tr>
                    <td style="width: 50%;">
                        <div class="card-custom">
                            <div class="title">Worksheets entregados</div>
                            <p class="subtitle">(Películas y series asignadas)</p>
                            <div class="number">
                                <span class="greenA">{{ $liveCounts->entWork }} <span class="black">/ {{ $liveCounts->asigWork }}</span></span>
                            </div>
                            <span class="label">COMPLETADAS</span>
                        </div>
                    </td>
                    <td style="width: 50%;">
                        <div class="card-custom">
                            <div class="title">Actividades entregadas</div>
                            <p class="subtitle">(Plataforma de Richmond)</p>
                            <div class="number">
                                <span class="greenA">{{ $liveCounts->entAct }} <span class="black">/ {{ $liveCounts->asigAct }}</span></span>
                            </div>
                            <span class="label">COMPLETADAS</span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>



        <style>
            .bar-container {
                background-color: #e0e0e0;
                border-radius: 20px;
                height: 16px;
                width: 100%;
                overflow: hidden;
                margin-bottom: 10px;
            }

            .bar-fill {
                height: 100%;
                border-radius: 20px;
                background-color: #99BF51;
            }

            .skill-section {
                margin-bottom: 15px;
            }

            .skill-title {
                font-weight: bold;
                font-size: 18px;
                margin-bottom: 8px;
            }

            .bar-label {
                display: flex;
                justify-content: space-between;
                font-size: 14px;
                margin-bottom: 4px;
                width: 100vw;
            }

            .consolidated-box {
                background: #f0fff0;
                border: 2px dashed #2ecc71;
                border-radius: 10px;
                padding: 1rem;
                margin-top: 2rem;
            }
        </style>

        <div class="range-container">
            <h2>Resultados del test</h2>

            @foreach ($skills as $skill)
                <div class="skill-section">
                    <div class="skill-title">{{ $skill }}</div>
                    @foreach ($qualifications as $index => $q)
                        @php $score = $q[strtolower($skill)]; @endphp
                        <div class="bar-label" style="width: {{ $score }}%;">
                            <strong>{{ number_format($score, 2) }}%</strong>
                        </div>
                        <div class="bar-container">
                            <div class="bar-fill" style="width: {{ $score }}%;"></div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="consolidated-box">
                @foreach ($totalesExamen as $i => $promedioExamen)
                    <div class="bar-label" style="width: {{ $promedioExamen }}%;">
                        <strong>Promedio General</strong>
                        <strong>{{ number_format($average, 2) }}%</strong>
                    </div>
                    <div class="bar-container">
                        <div class="bar-fill" style="width: {{ $promedioExamen }}%;"></div>
                    </div>
                @endforeach
            </div>
        </div>
        <p class="note">
            -Mc Studies-
        </p>
    </div>
</body>

</html>
