<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Descarga de Caja</title>
</head>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: #333;
        margin: 0;
        padding: 0;
        background: #fff;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 2px solid #05CCD1;
    }

    .logo img {
        height: 70px;
    }

    .info {
        text-align: right;
        font-size: 11px;
        line-height: 1.5;
        color: #555;
    }

    .info span {
        font-weight: bold;
        color: #111;
    }

    h2 {
        margin: 0;
        font-size: 20px;
        color: #05CCD1;
    }

    .containerConte {
        padding: 20px;
    }

    .conteTable {
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    th {
        background: #05CCD1;
        color: #fff;
        padding: 10px;
        border: 1px solid #ccc;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }

    tr:nth-child(even) {
        background: #f9f9f9;
    }

    .total {
        background: #99BF51 !important;
        color: #fff;
        font-weight: bold;
        font-size: 13px;
    }

    .total td {
        text-align: right;
        padding-right: 15px;
    }
</style>

<body>
    <header>
        <div class="flex">
            <div class="logo">
                <img src="{{ public_path('Logo.png') }}" alt="Logo">
            </div>
            <div class="info">
                <p><span>NIT:</span> 901809528-9</p>
                <p><span>Teléfono:</span> 3173961175</p>
                <p><span>Email:</span> info@mcstudies.com</p>
            </div>
        </div>
        <div class="flex">
            <h2>Reporte de Caja</h2>
            <p><span>Fecha de generación:</span> {{ date('Y-m-d') }}</p>
        </div>
    </header>

    <div class="containerConte">
        <div class="conteTable">
            <table class="teacher">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nombre</th>
                        <th>valor</th>
                        <th>Metodo</th>
                        <th>Ingreso/Egreso</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @forelse ($pagos as $key => $pago)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            @php
                                $name = $pago->apprentice
                                    ? $pago->apprentice->name . ' ' . $pago->apprentice->apellido
                                    : $pago->egresado;
                            @endphp
                            <td>{{ $name }}</td>
                            <td>${{ number_format($pago->monto, 0, ',', '.') }} </td>
                            @php
                                $total += $pago->monto;
                            @endphp
                            <td>{{ $pago->metodo->name }} </td>
                            <td>{{ $pago->dinero }} </td>
                            <td>
                                {{ $pago->created_at->format('Y-m-d') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="center" colspan="8">
                            </td>
                        </tr>
                    @endforelse
                    <tr class="total">
                        <td colspan="2">Total:</td>
                        <td>${{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
