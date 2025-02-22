<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Descargar Informe</title>
</head>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-bottom: 2px solid #ddd;
    }

    .logo img {
        height: 80px;
    }

    .info {
        text-align: right;
        margin-top: -80px;
    }

    .info p {
        margin: 5px 0;
        color: #444;
    }

    .info span {
        font-weight: bold;
    }

    .container {
        padding: 20px;
    }

    .student-info {
        margin-bottom: 20px;
        padding: 10px;
        background: #f7f7f7;
        border-radius: 5px;
    }

    .student-info p {
        margin: 5px 0;
        margin-top: 20px;
    }

    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    th {
        background: #05CCD1;
        color: white;
    }

    .total-row {
        background: #99BF51;
        font-weight: bold;
    }
</style>

<body>
    <header>
        <div class="logo">
            <img src="{{ public_path('Logo.png') }}" alt="Logo">
        </div>
        <div class="info">
            <p><span>NIT:</span> 901809528-9</p>
            <p><span>Teléfono:</span> 3173961175</p>
            <p><span>Email:</span> info@mcstudies.com</p>
        </div>
    </header>

    <div class="container">
        <p><strong>Fecha:</strong> {{ $fecha }}</p>

        <div class="student-info">
            <p><strong>Estudiante:</strong> {{ $aprendiz->name . ' ' . $aprendiz->apellido }}</p>
            <p><strong>Grupo:</strong> {{ $aprendiz->group->name ?? 'Sin grupo' }}</p>
            <p><strong>Modalidad:</strong> {{ $aprendiz->modality->name }}</p>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Precio Modulo</th>
                        <th>Descuento</th>
                        <th>Abono</th>
                        <th>Pendiente</th>
                        <th>Plataforma</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $precio = 0;
                        $descuento = 0;
                        $totalAbono = 0;
                    @endphp

                    @forelse ($informes as $informe)
                        <tr >
                            <td>${{ number_format($informe->apprentice->valor, 0, ',', '.') }}</td>
                            <td>${{ number_format($informe->apprentice->descuento, 0, ',', '.') }}</td>
                            <td>${{ number_format($informe->abono, 0, ',', '.') }}</td>
                            @php
                                $precio = $informe->apprentice->valor;
                                $descuento = $informe->apprentice->descuento;
                                $totalAbono += $informe->abono;
                            @endphp
                            <td>${{ number_format($precio - $descuento - $totalAbono, 0, ',', '.') }}</td>
                            <td>${{ number_format($informe->apprentice->plataforma, 0, ',', '.') }}</td>
                            <td>{{ $informe->fecha ?? 'Sin fecha' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay registros</td>
                        </tr>
                    @endforelse

                    <tr class="total-row">
                        <td>${{ number_format($precio, 0, ',', '.') }}</td>
                        <td>${{ number_format($descuento, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalAbono, 0, ',', '.') }}</td>
                        <td>${{ number_format($precio - $descuento - $totalAbono, 0, ',', '.') }}</td>
                        @if ($count != 0)
                            <td>${{ number_format($aprendiz->plataforma, 0, ',', '.') }}</td>
                            <td>${{ number_format($totalAbono + $aprendiz->plataforma + $informe->apprentice->descuento, 0, ',', '.') }}
                            </td>
                        @else
                            <td>El estudiante ya pagó la plataforma</td>
                            <td>${{ number_format($totalAbono + $informe->apprentice->descuento, 0, ',', '.') }}
                            </td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>


</html>
