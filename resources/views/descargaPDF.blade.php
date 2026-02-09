<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Informativo - {{ $aprendiz->name }}</title>
    <style>
        @page {
            margin: 2cm;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .header {
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 20px;
            margin-bottom: 30px;
            display: block;
            width: 100%;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .logo-container {
            display: table-cell;
            vertical-align: middle;
            width: 30%;
        }

        .logo img {
            max-width: 150px;
            height: auto;
        }

        .title-container {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 70%;
        }

        h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            background-color: #f8f9fa;
            border-left: 5px solid #3498db;
            padding: 8px 15px;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .info-item {
            display: table-cell;
            width: 50%;
            padding: 5px 0;
        }

        .label {
            font-weight: bold;
            color: #555;
            width: 140px;
            display: inline-block;
        }

        .value {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #2c3e50;
            color: white;
            text-align: left;
            padding: 12px;
            font-size: 14px;
        }

        td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #fcfcfc;
        }

        .total-row {
            background-color: #f8f9fa !important;
            font-weight: bold;
        }

        .total-row td {
            border-top: 2px solid #2c3e50;
            color: #2c3e50;
            font-size: 16px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 12px;
            background-color: #e1f5fe;
            color: #01579b;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="header-content">
            <div class="logo-container">
                <div class="logo">
                    <img src="{{ public_path('Logo.png') }}" alt="Logo">
                </div>
            </div>
            <div class="title-container">
                <h1>Reporte del Aprendiz</h1>
                <p style="margin: 5px 0 0 0; color: #7f8c8d;">Fecha de generacion: {{ date('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Datos Personales</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Aprendiz:</span>
                <span class="value">{{ $aprendiz->name }} {{ $aprendiz->apellido }}</span>
            </div>
            <div class="info-item">
                <span class="label">Edad:</span>
                <span class="value">{{ $aprendiz->edad }}</span>
            </div>
        </div>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Nacimiento:</span>
                <span class="value">{{ $aprendiz->fecha_nacimiento }}</span>
            </div>
            <div class="info-item">
                <span class="label">Modalidad:</span>
                <span class="value"><span class="status-badge">{{ $aprendiz->modality->name }}</span></span>
            </div>
        </div>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Direccion:</span>
                <span class="value">{{ $aprendiz->direccion }}</span>
            </div>
            @if ($aprendiz->attendant->id == 1)
                <div class="info-item">
                    <span class="label">Contacto:</span>
                    <span class="value">{{ $aprendiz->telefono }} / {{ $aprendiz->email }}</span>
                </div>
            @endif
        </div>
    </div>

    @if ($aprendiz->attendant->id != 1)
        <div class="section">
            <div class="section-title">Informacion del Acudiente</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Nombre:</span>
                    <span class="value">{{ $aprendiz->attendant->name }} {{ $aprendiz->attendant->apellido }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Telefono:</span>
                    <span class="value">{{ $aprendiz->attendant->telefono }}</span>
                </div>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Correo:</span>
                    <span class="value">{{ $aprendiz->attendant->email }}</span>
                </div>
            </div>
        </div>
    @endif

    <div class="section">
        <div class="section-title">Historial de Pagos</div>
        <table>
            <thead>
                <tr>
                    <th>Concepto / Referencia</th>
                    <th>Fecha de Pago</th>
                    <th style="text-align: right;">Monto</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @forelse ($aprendiz->informe as $informe)
                    <tr>
                        <td>Abono realizado</td>
                        <td>{{ $informe->fecha }}</td>
                        <td style="text-align: right;">$ {{ number_format($informe->abono, 2) }}</td>
                    </tr>
                    @php $total += $informe->abono; @endphp
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #999;">No se registraron pagos</td>
                    </tr>
                @endforelse

                @if ($aprendiz->plataforma)
                    <tr>
                        <td>Costo de Plataforma</td>
                        <td>-</td>
                        <td style="text-align: right;">$ {{ number_format($aprendiz->plataforma, 2) }}</td>
                    </tr>
                @endif

                <tr class="total-row">
                    <td colspan="2" style="text-align: right;">TOTAL ACUMULADO</td>
                    <td style="text-align: right;">$ {{ number_format($total + ($aprendiz->plataforma ?? 0), 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Este documento es un reporte informativo generado automaticamente.</p>
        <p><strong>Tu equipo {{ config('app.name') }}</strong></p>
    </div>

</body>

</html>
