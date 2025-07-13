<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe de los estudiantes</title>
</head>


<style>
    .footer{
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100vw;
    }
</style>
<body>
    <main>
        <div class="descarga">
            <div class="container">
                <div class="content">
                    <table class="tableInforme" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th colspan="11"
                                    style="background-color: #009C91; color: white; font-size: 18px; text-align: center;">
                                    Informe Estudiantes
                                </th>
                            </tr>
                            <tr>
                                <th colspan="11" style="text-align: center; padding: 10px 0; font-size: 16px;">
                                    MC Language studies
                                </th>
                            </tr>
                            <tr>
                                <th colspan="11" style="text-align: center; padding-bottom: 10px;">
                                    Fecha: {{ $fecha }}
                                </th>
                            </tr>

                            <tr style="background-color: #009C91; color: white;">
                                <th>No.</th>
                                <th>Acudiente</th>
                                <th>Estudiante</th>
                                <th>Becado</th>
                                <th>Valor Modulo</th>
                                <th>Descuento</th>
                                <th>Abono</th>
                                <th>Pendiente</th>
                                <th>Plataforma de Pago</th>
                                <th>Fecha</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $totalModulos = 0;
                                $totalAbono = 0;
                                $totalDescuento = 0;
                                $totalPendiente = 0;
                                $totalplataforma = 0;
                            @endphp

                            @forelse ($securityInforme as $key => $informe)
                                @php
                                    $totalModulos += $informe->valor;
                                    $totalAbono += $informe->abono;
                                    $totalDescuento += $informe->descuento;
                                    $totalPendiente += $informe->pendiente;
                                    $totalplataforma += $informe->plataforma;
                                @endphp

                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td class="relative">
                                        {{ $informe->acudiente }}
                                    </td>
                                    <td>
                                        {{ $informe->estudiante }}
                                    </td>
                                    <td class="relative">
                                        {{ $informe->becado }}
                                    </td>
                                    <td>$
                                        {{ number_format($informe->valor, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <div class="flex">
                                            ${{ number_format($informe->descuento, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        ${{ number_format($informe->abono, 0, ',', '.') }}
                                    </td>
                                    <td>${{ number_format($informe->pendiente, 0, ',', '.') }}
                                    </td>
                                    <td>${{ number_format($informe->plataforma, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        {{ $informe->fecha ?? 'Sin fecha' }}
                                    </td>
                                    <td>
                                        <div class="flex">{{ $informe->observacion }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                            <td colspan="4">Total: </td>
                            <td>${{ number_format($totalModulos, 0, ',', '.') }}</td>
                            <td>${{ number_format($totalDescuento, 0, ',', '.') }}</td>
                            <td>${{ number_format($totalAbono, 0, ',', '.') }}</td>
                            <td>${{ number_format($totalPendiente, 0, ',', '.') }}</td>
                            <td>${{ number_format($totalplataforma, 0, ',', '.') }}</td>
                            <td colspan="3">
                                ${{ number_format($totalplataforma + $totalModulos, 0, ',', '.') }}</td>
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
