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
            margin: 0;
        }

        .content {
            width: 80%;
            margin: 0 auto;
        }

        .header {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100%;
            height: 150px;
        }

        h4 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
            font-size: 18px;
        }

        .cards {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            gap: 20px;
            margin-bottom: 20px;
        }

        .flex {
            display: table;
            margin: 0 auto;
            border-spacing: 20px;
        }

        .flex .card {
            display: table-cell;
            vertical-align: top;
            width: 200px;
        }

        .card {
            background: #f2f2f2;
            border-radius: 10px;
            padding: 20px 30px;
            text-align: center;
            min-width: 220px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        /* Títulos */
        .card .title {
            font-size: 14px;
            font-weight: bold;
            color: #444;
            margin-bottom: 8px;
        }

        .card .title p {
            font-size: 12px;
            font-weight: normal;
            text-align: center;
            color: #777;
            margin: 0;
        }

        /* Número y resultado */
        .card .number {
            font-size: 20px;
            margin-top: 5px;
            background-color: white;
            border-radius: 8px;
            padding: 6px;
        }

        .greenR {
            color: #6bb44b;
            font-weight: bold;
            font-size: 22px;
        }

        .greenA {
            color: #6bb44b;
            font-weight: bold;
            font-size: 19px;
        }

        .green {
           background-color: #6bb44b;
        }


        .black {
            color: #333;
            font-weight: normal;
        }

        .text {
            display: block;
            font-size: 13px;
            color: #888;
            margin-top: 3px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Tarjeta de rendimiento general */
        .cards>.card {
            min-width: 260px;
        }

        .cards>.card .title {
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: 600;
        }

        .cards>.card .number {
            font-size: 28px;
            font-weight: bold;
            color: #6bb44b;
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
            margin-bottom: 10px;
        }

        p {
            text-align: justify;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .red {
            background-color: #e74c3c;
        }

        .range-container {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 12px;
        }

        .skill-section {
            margin-bottom: 5px;
        }

        .skill-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .bar-label {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .bar-container {
            background-color: #e0e0e0;
            border-radius: 20px;
            height: 16px;
            width: 100%;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .bar-fill {
            height: 100%;
            border-radius: 20px;
        }

        .consolidated-box {
            background: #f0fff0;
            border: 2px dashed #2ecc71;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 2rem;
        }

        .note {
            font-size: 11px;
            margin-top: 20px;
            text-align: center;
        }

        .result-image {
            width: 100%;
            margin-top: 30px;
        }

        .average-label {
            font-weight: bold;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    @php
        $skills = ['Listening', 'Speaking', 'Reading', 'Writing'];
        $total = ['Listening' => 0, 'Speaking' => 0, 'Reading' => 0, 'Writing' => 0];
        $totalesExamen = [];

        foreach ($qualifications as $key => $q) {
            foreach ($skills as $skill) {
                $total[$skill] += $q[strtolower($skill)];
            }
            $totalesExamen[$key] = ($q->listening + $q->speaking + $q->reading + $q->writing) / 4;
        }

        $count = max(count($qualifications), 1);
        $promedios = [];
        foreach ($skills as $skill) {
            $promedios[$skill] = $total[$skill] / $count;
        }

        $average = array_sum($promedios) / 4;
        $passed = $average >= 75;
        $allSkillsApproved = collect($promedios)->every(fn($value) => $value >= 75);
    @endphp

    <main class="content">
        @php
            use App\Models\AssignedActivity;
            use App\Models\AcademicActivity;
            use Carbon\Carbon;

            $keywords = ['worksheet', 'pelicula', 'movie', 'serie', 'series'];
            // Priorizamos el semestre de la sesión, si no existe usamos el guardado en el objeto
            $semester = (int) (session('selectedSemester') ?? $qualifications[0]->semestre ?? 1);
            $year = (int) (session('selectedYear') ?? $qualifications[0]->year ?? date('Y'));

            // Función para calcular actividades Live para una calificación dada
            $getLiveCounts = function ($q) use ($keywords, $semester, $year) {
                $result = (int) $q->resultado;
                $groupId = $q->group_id;
                $studentId = $q->apprentice_id;
                $startDate = null;
                $endDate = null;

                if ($semester == 1) {
                    if ($result == 1) {
                        $startDate = Carbon::createFromDate($year, 2, 1)->startOfDay();
                        $endDate = Carbon::createFromDate($year, 3, 31)->endOfDay();
                    } elseif ($result == 2) {
                        $startDate = Carbon::createFromDate($year, 4, 1)->startOfDay();
                        $endDate = Carbon::createFromDate($year, 4, 30)->endOfDay();
                    } elseif ($result == 3) {
                        $startDate = Carbon::createFromDate($year, 5, 1)->startOfDay();
                        $endDate = Carbon::createFromDate($year, 5, 31)->endOfDay();
                    }
                } else {
                    if ($result == 1) {
                        $startDate = Carbon::createFromDate($year, 8, 1)->startOfDay();
                        $endDate = Carbon::createFromDate($year, 9, 30)->endOfDay();
                    } elseif ($result == 2) {
                        $startDate = Carbon::createFromDate($year, 10, 1)->startOfDay();
                        $endDate = Carbon::createFromDate($year, 10, 31)->endOfDay();
                    } elseif ($result == 3) {
                        $startDate = Carbon::createFromDate($year, 11, 1)->startOfDay();
                        $endDate = Carbon::createFromDate($year, 11, 30)->endOfDay();
                    }
                }

                $asignadasAct = 0; $asignadasWork = 0; $entregadasAct = 0; $entregadasWork = 0;

                if ($startDate) {
                    $baseAsig = AssignedActivity::whereHas('groups', function ($g) use ($groupId) {
                        $g->where('groups.id', $groupId);
                    })->whereBetween('created_at', [$startDate, $endDate]);

                    $asignadasWork = (clone $baseAsig)->where(function ($g) use ($keywords) {
                            foreach ($keywords as $word) { $g->orWhere('titulo', 'like', "%{$word}%"); }
                        })->count();
                    $asignadasAct = (clone $baseAsig)->where(function ($g) use ($keywords) {
                            foreach ($keywords as $word) { $g->where('titulo', 'not like', "%{$word}%"); }
                        })->count();

                    $baseEnt = AcademicActivity::where('apprentice_id', $studentId)->whereBetween('fecha', [$startDate, $endDate]);

                    $entregadasWork = (clone $baseEnt)->where(function ($g) use ($keywords) {
                            foreach ($keywords as $word) { $g->orWhere('titulo', 'like', "%{$word}%"); }
                        })->count();
                    $entregadasAct = (clone $baseEnt)->where(function ($g) use ($keywords) {
                            foreach ($keywords as $word) { $g->where('titulo', 'not like', "%{$word}%"); }
                        })->count();
                }

                return (object) [
                    'asigAct' => $asignadasAct,
                    'entAct' => $entregadasAct,
                    'asigWork' => $asignadasWork,
                    'entWork' => $entregadasWork,
                ];
            };

            $liveCounts = $getLiveCounts($qualifications[0]);
        @endphp
        <div class="header">
            <img src="{{ public_path('headerReporte.png') }}" alt="Resultado" class="result-image">
        </div>

        <div class="info_apprentice">
            <strong>Nombre:</strong> {{ $qualifications[0]->apprentice->name }}
            {{ $qualifications[0]->apprentice->apellido }}<br>
            <strong>Fecha:</strong>
            {{ \Carbon\Carbon::parse($qualifications[0]->created_at)->format('d/m/Y') }}
        </div>


        <h4>Rendimiento integral del estudiante</h4>

        <div class="cards">
            <div class="flex">
                <div class="card">
                    <div class="title">
                        <span>Worksheet entregados</span>
                        <p>(Peliculas y series asignadas)</p>
                    </div>
                    <div class="number">
                        <span class="greenA">{{ $qualifications[0]->worksheet_entregados }} <span class="black">/
                                 {{ $qualifications[0]->worksheet_asignados }}</span> </span>
                        <span class="text">COMPLETADAS</span>
                    </div>
                </div>
                <div class="card">
                    <div class="title">
                        <span>Actividades entregadas</span>
                        <p>(Plataforma de Richmond)</p>
                    </div>
                    <div class="number">
                        <span class="greenA">{{ $liveCounts->entAct }} <span class="black">/
                                {{ $liveCounts->asigAct }}</span> </span>
                        <span class="text">COMPLETADAS</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="title">
                    <span>Rendimiento General</span>
                </div>
                <div class="number">
                    <span class="greenR">{{ number_format($average, 2) }}%</span>
                </div>
            </div>
        </div>

        <div class="range-container">
            <h2>Resultados del test</h2>

            @foreach ($skills as $skill)
                <div class="skill-section">
                    <div class="skill-title">{{ $skill }}</div>
                    @foreach ($qualifications as $q)
                        @php $score = $q[strtolower($skill)]; @endphp
                        <div class="bar-label">
                            <span>Puntaje:</span>
                            <strong>{{ number_format($score, 2) }}%</strong>
                        </div>
                        <div class="bar-container">
                            <div class="bar-fill {{ $score < 65 ? 'red' : 'green' }}"
                                style="width: {{ $score }}%;"></div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        <p class="note">-MC Studies-</p>
    </div>
</body>

</html>
