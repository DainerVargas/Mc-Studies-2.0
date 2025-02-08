<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe de los estudiantes</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app-Be1cidhe.css') }}">
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
                                <th>Descuento</th>
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
                                    <td>{{ $informe->apprentice->name }} {{$informe->apprentice->apellido}}</td>
                                    @php
                                    if ($informe->apprentice->modality_id != 4) {
                                        $valorModulo = $informe->apprentice->modality->valor;
                                    } else {
                                        $valorModulo = $informe->apprentice->valor;
                                    }
                                @endphp
                                <td>$
                                    {{ number_format($valorModulo - $informe->apprentice->descuento, 0, ',', '.') }}
                                </td>
                                    <td>${{ $informe->apprentice->descuento }}</td>
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
                                    <td>${{ $pendiente - $informe->apprentice->descuento}} </td>
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
                                <td>${{ $totalModulos - $totalDescuento }}</td>
                                <td>${{ $totalDescuento }}</td>
                                <td>${{ $total }}</td>
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
