<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Descargar Informe</title>
</head>

<style>
    .containerEstado {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .name {
        font-family: Arial, Helvetica, sans-serif;
    }

    .logo {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    img {
        height: 100px;
    }

    .containerConte {
        width: 100%;
        border: none;
        overflow-x: hidden;
        overflow-y: scroll;
        scrollbar-width: none;
        height: 350px;
    }

    .conteTable {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 30px;
        position: relative;
    }

    table {
        width: 80%;
        border: 1px solid gray;
        border-radius: 0.4vw;
        border-collapse: collapse;
    }

    .fixed {
        height: 18px;
        font-size: 18px;
        position: sticky;
        top: 0;
        z-index: 999;
        border: 1px solid gray !important;
        background-color: #dbdbdb;
    }

    .fixed:nth-child(1) {
        height: 32px;
    }

    .td,
    .th {
        padding: 2px;
        box-sizing: border-box;
    }

    .td {
        font-size: 16px;
        border: 1px solid gray;
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 200;
    }

    .color-blue {
        background-color: #05CCD1;
        color: white;
        border: 1px solid #05CCD1;
    }

    .color-green {
        background-color: #99BF51;
    }
</style>

<body>
    <div class="containerEstado">
        <div class="logo">
            <img src="{{ public_path('Logo.png') }}" alt="">
        </div>
        <p class="name">{{ $aprendiz->name . ' ' . $aprendiz->apellido }}</p>
        <div class="containerConte">
            <div class="conteTable">

                @php
                    $precio = 0;
                    $descuento = 0;
                    $totalAbono = 0;
                @endphp
                <table>
                    <tr class="tr">
                        <th class="fixed color-blue" colspan="6">Modalidad - {{ $aprendiz->modality->name }}</th>
                    </tr>
                    <tr>
                        <th class="fixed color-green">Precio Modulo</th>
                        <th class="fixed color-green">Descuento</th>
                        <th class="fixed color-green">Abono</th>
                        <th class="fixed color-green">Pendiente</th>
                        <th class="fixed color-green">Plataforma</th>
                        <th class="fixed color-green">Fecha</th>
                    </tr>
                    @forelse ($informes as $informe)
                        <tr>
                            <td class="td">${{ number_format($informe->apprentice->valor, 0, ',', '.') }}</td>
                            <td class="td">${{ number_format($informe->apprentice->descuento, 0, ',', '.') }}</td>
                            <td class="td">${{ number_format($informe->abono, 0, ',', '.') }}</td>
                            @php
                                $precio = $informe->apprentice->valor;
                                $descuento = $informe->apprentice->descuento;
                                $totalAbono += $informe->abono;
                            @endphp
                            <td class="td">${{ number_format($precio - $descuento - $totalAbono, 0, ',', '.') }}
                            </td>
                            <td class="td">${{ number_format($informe->apprentice->plataforma, 0, ',', '.') }}</td>
                            <td class="td">{{ $informe->fecha ?? 'Sin fecha' }}</td>
                        </tr>
                    @empty
                        <td class="td">No hay na'</td>
                    @endforelse
                    <tr>
                        <td class="td">${{ number_format($precio, 0, ',', '.') }}</td>
                        <td class="td">${{ number_format($descuento, 0, ',', '.') }}</td>
                        <td class="td">${{ number_format($totalAbono, 0, ',', '.') }}</td>
                        <td class="td">${{ number_format($precio - $descuento - $totalAbono, 0, ',', '.') }}</td>
                        <td class="td">${{ number_format($aprendiz->plataforma, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

</body>

</html>
