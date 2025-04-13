<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe de los estudiantes</title>
    {{-- <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .descarga {
            margin: 20px;
            padding: 20px;
            border: 1px solid #f1f1f1;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .content {
            padding: 20px;
        }
        .tableInforme {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .tableInforme th,
        .tableInforme td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: center;
        }
        .tableInforme th {
            background-color: #009C91;
            color: white;
        }
        .tableInforme tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
        .nodatos {
            text-align: center;
            color: red;
        }
        .totalRow {
            font-weight: bold;
        }
    </style> --}}
</head>
<body>
    <main>
        <div class="descarga">
            <div class="container">
                <div class="content">
                    <table class="tableInforme" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th colspan="10" style="background-color: #009C91; color: white; font-size: 18px; text-align: center;">
                                    Informe Estudiantes
                                </th>
                            </tr>
                            <tr>
                                <th colspan="10" style="text-align: center; padding: 10px 0; font-size: 16px;">
                                    MC Language studies
                                </th>
                            </tr>
                            <tr>
                                <th colspan="10" style="text-align: center; padding-bottom: 10px;">
                                    Fecha: {{ $fecha }}
                                </th>
                            </tr>
                
                            <tr style="background-color: #009C91; color: white;">
                                <th>No.</th>
                                <th>Acudiente</th>
                                <th>Estudiante</th>
                                <th>Módulo</th>
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
                            @endphp
                            @forelse ($informes ?? [] as $informe)
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td class="relative">{{ $informe->apprentice->attendant->name }}</td>
                                    <td>{{ $informe->apprentice->name }} {{$informe->apprentice->apellido}}</td>
                                    @php
                                        $valorModulo = $informe->apprentice->modality->valor ?? $informe->apprentice->valor;
                                    @endphp
                                    <td>${{ number_format($valorModulo - $informe->apprentice->descuento, 0, ',', '.') }}</td>
                                    <td>${{ $informe->apprentice->descuento }}</td>
                                    <td>${{ $informe->abono }}</td>
                                    @php
                                        $fecha = $informe->fecha ?? 'Sin fecha';
                                    @endphp
                                    <td>{{ $fecha }}</td>
                                    @php
                                        $totalAbonos = $informes->where('apprentice_id', $informe->apprentice->id)->sum('abono');
                                        $pendiente = ($valorModulo - $totalAbonos - $informe->apprentice->descuento);
                                    @endphp
                                    <td>${{ number_format($pendiente, 0, ',', '.') }}</td>
                                    <td>${{ number_format($informe->apprentice->plataforma ?? 0, 0, ',', '.') }}</td>
                                    <td>-----</td>
                                </tr>
                                @php
                                    $total += $informe->abono;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <p class="nodatos">No hay datos</p>
                                    </td>
                                </tr>
                            @endforelse
                            <tr class="totalRow">
                                <td colspan="3">Total:</td>
                                <td>${{ number_format($totalModulos - $totalDescuento, 0, ',', '.') }}</td>
                                <td>${{ number_format($totalDescuento, 0, ',', '.') }}</td>
                                <td>${{ number_format($total, 0, ',', '.') }}</td>
                                <td></td>
                                <td>${{ number_format($plataforma, 0, ',', '.') }}</td>
                                <td>${{ number_format($plataforma + $totalModulos, 0, ',', '.') }}</td>
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
