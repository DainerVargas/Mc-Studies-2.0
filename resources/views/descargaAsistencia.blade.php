<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reporte de Asistencia - {{ $grupo->name }}</title>
    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 10px;
            color: #333;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #05CCD1;
            padding-bottom: 10px;
        }

        .logo {
            width: 150px;
        }

        .company-info {
            text-align: right;
            font-size: 9px;
            line-height: 1.4;
        }

        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: #1a202c;
            margin: 10px 0;
            text-transform: uppercase;
        }

        .filters-info {
            width: 100%;
            margin-bottom: 15px;
            background: #f8fafc;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #e2e8f0;
        }

        .filters-info td {
            border: none;
            padding: 2px 5px;
            text-align: left;
            font-size: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 4px 2px;
            text-align: center;
            word-wrap: break-word;
        }

        th {
            background-color: #05CCD1;
            color: white;
            font-weight: bold;
            font-size: 8px;
        }

        .student-name-col {
            text-align: left;
            padding-left: 5px;
            font-weight: bold;
            background-color: #f1f5f9;
        }

        .status-P {
            color: #166534;
            font-weight: bold;
        }

        .status-A {
            color: #991b1b;
            font-weight: bold;
        }

        .status-T {
            color: #92400e;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 8px;
            text-align: center;
            color: #64748b;
        }

        .legend {
            margin-top: 15px;
            font-size: 8px;
        }

        .legend-item {
            display: inline-block;
            margin-right: 15px;
        }
    </style>
</head>

<body>
    <table class="header">
        <tr>
            <td style="border:none; text-align:left;">
                <img src="{{ public_path('Logo.png') }}" class="logo">
            </td>
            <td class="company-info" style="border:none;">
                <strong>NIT:</strong> 901809528-9<br>
                <strong>Teléfono:</strong> 3173961175<br>
                <strong>Email:</strong> info@mcstudies.com<br>
                <strong>Dirección:</strong> Fonseca - La Guajira
            </td>
        </tr>
    </table>

    <div class="report-title">Reporte General de Asistencia</div>

    <table class="filters-info">
        <tr>
            <td><strong>Grupo:</strong> {{ $grupo->name }}</td>
            <td><strong>Profesor:</strong> {{ $teacher->name }} {{ $teacher->apellido }}</td>
            <td><strong>Periodo:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="width: 25px;">N°</th>
                <th style="width: 140px; text-align:left; padding-left: 5px;">Estudiante</th>
                @foreach ($datesInRange as $dateItem)
                    <th>
                        {{ \Carbon\Carbon::parse($dateItem)->format('d/m') }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($estudiantes as $index => $estudiante)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="student-name-col">{{ $estudiante->name }} {{ $estudiante->apellido }}</td>
                    @foreach ($datesInRange as $dateItem)
                        @php
                            $asistRow = $asistencias[$estudiante->id][$dateItem] ?? null;
                            $asistencia = $asistRow ? $asistRow[0] : null;
                            $status = '-';
                            $class = '';
                            if ($asistencia) {
                                $estado = $asistencia->estado;
                                if ($estado == 'presente') {
                                    $status = 'P';
                                    $class = 'status-P';
                                } elseif ($estado == 'ausente') {
                                    $status = 'A';
                                    $class = 'status-A';
                                } elseif ($estado == 'tarde') {
                                    $status = 'T';
                                    $class = 'status-T';
                                }
                            }
                        @endphp
                        <td class="{{ $class }}">{{ $status }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="legend">
        <strong>Convenciones:</strong>
        <span class="legend-item"><span class="status-P">P:</span> Presente</span>
        <span class="legend-item"><span class="status-A">A:</span> Ausente</span>
        <span class="legend-item"><span class="status-T">T:</span> Tarde</span>
        <span class="legend-item"><span>-:</span> Sin registro</span>
    </div>

    <div class="footer">
        Este documento es un reporte oficial de MC Language Studies generado el {{ date('d/m/Y H:i') }}.
    </div>
</body>

</html>
