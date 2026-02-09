<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Horas</title>
</head>
<style>
    @page {
        margin: 40px 50px;
    }

    body {
        font-family: 'DejaVu Sans', sans-serif;
        color: #333;
        font-size: 13px;
        line-height: 1.5;
    }

    .content {
        width: 100%;
    }

    /* Encabezado */
    .header {
        display: flex;
        justify-content: center;
        align-items: center;
        border-bottom: 2px solid #99BF51;
        padding-bottom: 10px;
        margin-bottom: 25px;
    }

    .logo {
        width: 120px;
        height: auto;
    }

    /* Informaci贸n del profesor */
    .info_teacher {
        font-size: 14px;
        margin-bottom: 20px;
        padding: 10px 15px;
        background-color: #f8f9fa;
        border: 1px solid #e5e5e5;
        border-radius: 6px;
        line-height: 1.6;
    }

    h4 {
        text-align: center;
        color: #99BF51;
        font-size: 18px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    /* Tabla principal */
    .conte_table {
        margin-top: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        font-size: 13px;
    }

    thead {
        background-color: #99BF51;
        color: white;
    }

    th {
        padding: 10px;
        border: 1px solid #e0e0e0;
        text-transform: capitalize;
    }

    td {
        padding: 8px;
        text-align: center;
        border: 1px solid #e0e0e0;
    }

    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tbody tr:hover {
        background-color: #f1f9ee;
    }

    /* Total general */
    tfoot td,
    tr:last-child td {
        background-color: #f5f7f5;
        font-weight: bold;
        border-top: 2px solid #99BF51;
    }

    /* Nota final */
    .note {
        text-align: center;
        font-style: italic;
        color: #99BF51;
        margin-top: 30px;
        font-size: 14px;
    }
</style>

<body>
    <div class="content">
        <div class="header">
            <img src="{{ public_path('Logo.png') }}" alt="Logo" class="logo">
        </div>

        <div class="info_teacher">
            <strong>Nombre:</strong> {{ $teacher->name ?? ''}} {{ $teacher->apellido ?? '' }}<br>
            <strong>Fecha:</strong>
            {{ $fecha }}
        </div>

        <h4>Registro de Horas</h4>

        <div class="conte_table">
            <table>
                <thead>
                    <tr>
                        <th>lunes</th>
                        <th>martes</th>
                        <th>miercoles</th>
                        <th>jueves</th>
                        <th>viernes</th>
                        <th>sabado</th>
                        <th>Pago</th>
                        <th>Horas</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPrice = 0;
                    @endphp
                    @forelse ($hoursDetails ?? [] as $detail)
                        <tr>
                            <td>
                                <p>{{ $detail->lunes ?? '---' }}</p>
                            </td>
                            <td>
                                <p>{{ $detail->martes ?? '---' }}</p>
                            </td>
                            <td>
                                <p>{{ $detail->miercoles ?? '---' }}</p>
                            </td>
                            <td>
                                <p>{{ $detail->jueves ?? '---' }}</p>
                            </td>
                            <td>
                                <p>{{ $detail->viernes ?? '---' }}</p>
                            </td>
                            <td>
                                <p>{{ $detail->sabado ?? '---' }}</p>
                            </td>
                            <td>
                                @if ($detail->pago)
                                    <p style="color: green">Completado</p>
                                @else
                                    <p style="color: orange">Pendiente</p>
                                @endif
                            </td>
                            <td>{{ $detail->horas }}</td>
                            @php
                                $totalPrice += $detail->horas * $detail->teacher->precio_hora;
                            @endphp
                            <td>{{ number_format($detail->horas * $detail->teacher->precio_hora, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No se encontraron registros de horas.</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="8" style="text-align: right; font-weight: bold;">Total General:</td>
                        <td style="font-weight: bold;">{{ number_format($totalPrice, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="note">-MC Studies-</p>
    </div>
</body>

</html>
