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

        .green {
            background-color: #99BF51;
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

    <div class="content">
        <div class="header">
            <img src="{{ public_path('headerReporte.png') }}" alt="Resultado" class="result-image">
        </div>

        <div class="info_apprentice">
            <strong>Nombre:</strong> {{ $qualifications[0]->apprentice->name }} {{ $qualifications[0]->apprentice->apellido }}<br>
            <strong>Desde:</strong> {{ \Carbon\Carbon::parse($qualifications[0]->apprentice->fecha_inicio)->format('d/m/Y') }}
            &nbsp;&nbsp;
            <strong>Hasta:</strong> {{ \Carbon\Carbon::parse($qualifications[0]->apprentice->fecha_fin)->format('d/m/Y') }}
        </div>

        @if ($passed)
            <p><strong>{{ $qualifications[0]->apprentice->name }}{{ $qualifications[0]->apprentice->apellido }}</strong> ha demostrado un nivel de inglés acorde a los requisitos de su curso, evidenciando un sólido desempeño en las cuatro habilidades fundamentales del idioma. Su comprensión oral y escrita es clara y precisa, lo que le permite captar la información con facilidad y responder de manera adecuada en diversos contextos.
            </p>
            <p>
                Asimismo, su expresión oral es fluida y estructurada, mostrando confianza al comunicarse en inglés. En cuanto a la escritura, es capaz de redactar textos coherentes y bien organizados, utilizando una gramática adecuada y un vocabulario variado.
            </p>
        @else
            <p><strong>{{ $qualifications[0]->apprentice->name }}{{ $qualifications[0]->apprentice->apellido }}</strong> ha enfrentado dificultades en las cuatro habilidades del idioma: Listening, Speaking, Reading y Writing, lo que ha afectado su desempeño en el curso. Debido a esto, no ha logrado alcanzar el nivel esperado y requiere un refuerzo significativo en su aprendizaje del inglés.
            </p>
            <p>
                Se recomienda una mayor práctica diaria a través de lectura, escucha y ejercicios específicos que le permitan fortalecer su comprensión y expresión en el idioma. Actividades como escuchar audios en inglés con subtítulos, leer textos adaptados a su nivel y practicar la escritura con oraciones y párrafos sencillos pueden ser de gran ayuda.
            </p>
        @endif

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
                            <div class="bar-fill {{ $score < 65 ? 'red' : 'green' }}" style="width: {{ $score }}%;"></div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="consolidated-box">
                <div class="average-label">
                    <span>Promedio General</span>
                    <strong style="color: {{ $average < 75 ? '#e74c3c' : '#333' }}">{{ number_format($average, 2) }}%</strong>
                </div>
                <div class="bar-container">
                    <div class="bar-fill {{ $average < 75 ? 'red' : 'green' }}" style="width: {{ $average }}%;"></div>
                </div>
            </div>
        </div>

        @if ($passed)
            @if ($allSkillsApproved)
                <p>
                    Dado su desempeño, ha logrado aprobar satisfactoriamente las cuatro habilidades lingüísticas esenciales:
                    Listening, Speaking, Reading y Writing, demostrando así un progreso constante en su aprendizaje del idioma.
                </p>
            @else
                <p>
                    El estudiante ha aprobado el curso, demostrando progreso general en el aprendizaje del idioma. Sin embargo, se recomienda continuar reforzando las habilidades con menor rendimiento para lograr un dominio más sólido.
                </p>
            @endif
        @else
            <p>
                Asimismo, es importante que participe activamente en conversaciones en inglés para mejorar su fluidez y confianza.
            </p>
            <p>
                Con dedicación y esfuerzo constante, <strong>{{ $qualifications[0]->apprentice->name }}{{ $qualifications[0]->apprentice->apellido }}</strong> podrá superar estas dificultades y avanzar en su dominio del inglés. ¡Ánimo, el progreso es posible con práctica y perseverancia!
            </p>
        @endif

        <p class="note">-MC Studies-</p>
    </div>
</body>

</html>
