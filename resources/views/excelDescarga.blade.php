<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe de los estudiantes</title>
    {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-hjctGKyo.css') }}"> --}}
</head>

<body>
    @vite('resources/sass/app.scss')
    <main>
        <div class="descarga">
            <div class="container">
                <div class="content">
                    <table class="tableInforme">
                        <thead>
                            <tr>
                                <th colspan="10">Informe Estudiantes</th>
                            </tr>
                            <tr>
                                <td colspan="4">MC Language studies</td>
                            </tr>
                            <tr>
                                <td>Fecha:</td>
                                <td>{{ $fecha }}</td>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>Acudiente</th>
                                <th>Estudiante</th>
                                <th>Modulo</th>
                                <th>Abono</th>
                                <th>Fecha</th>
                                <th>Pendiente</th>
                                <th>Plataforma</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 1;
                                $total = 0;
                                $totalModulos = 0;
                                $plataforma = 0;

                                foreach ($aprendices as $valor) {
                                    if ($valor->modality->id == 4) {
                                        $totalModulos += $valor->valor;
                                    } else {
                                        $totalModulos += $valor->modality->valor;
                                    }
                                    $plataforma += $valor->plataforma ?? 0;
                                }
                            @endphp
                            @forelse ($informes ?? [] as $informe)
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td class="relative">
                                        {{ $informe->apprentice->attendant->name }}
                                    </td>
                                    <td>{{ $informe->apprentice->name }}</td>
                                    @if ($informe->apprentice->modality->id == 4)
                                        <td>${{ $informe->apprentice->valor }}</td>
                                    @else
                                        <td>${{ $informe->apprentice->modality->valor }}</td>
                                    @endif
                                    <td>${{ $informe->abono }}</td>
                                    @php
                                        $fecha = isset($informe->fecha) ? $informe->fecha : 'Sin fecha';
                                    @endphp
                                    <td>{{ $fecha }}</td>
                                    @php
                                        $totalAbonos = $informes
                                            ->where('apprentice_id', $informe->apprentice->id)
                                            ->sum('abono');
                                        if ($informe->apprentice->modality->id == 4) {
                                            $pendiente = $informe->apprentice->valor - $totalAbonos;
                                        } else {
                                            $pendiente = $informe->apprentice->modality->valor - $totalAbonos;
                                        }

                                    @endphp
                                    <td>${{ $pendiente }} </td>
                                    <td>${{ $informe->apprentice->plataforma ?? 0 }} </td>
                                    <td>-----</td>
                                </tr>
                                @php
                                    $total += $informe->abono;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <p class="nodatos">No hay datos</p>
                                    </td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="3">Total: </td>
                                <td>${{ $totalModulos }}</td>
                                <td>${{ $total }}</td>
                                <td></td>
                                <td></td>
                                <td>${{ $plataforma }}</td>
                                <td>${{ $plataforma + $totalModulos }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="footer">
                    <p>Tu equipo {{ config('app.name') }}</p>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
