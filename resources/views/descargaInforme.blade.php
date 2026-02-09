<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo de Caja</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background: #fff;
            font-size: 12px;
        }

        /* Container mimicking the receipt border */
        .receipt-container {
            border: 2px solid #bba35a;
            /* Goldish border from image reference */
            border-radius: 15px;
            padding: 15px;
            position: relative;
            margin: 10px;
            min-height: 900px;
        }

        /* Header Layout */
        .header-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .header-logo {
            width: 60%;
            vertical-align: top;
        }

        .header-title-box {
            width: 40%;
            vertical-align: top;
        }

        .title-box {
            background-color: #4CAF50;
            /* Green from reference */
            color: white;
            padding: 10px;
            border-radius: 10px 10px 0 0;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            border: 2px solid #bba35a;
            border-bottom: none;
            text-transform: uppercase;
        }

        .title-sub-box {
            border: 2px solid #bba35a;
            border-top: none;
            border-radius: 0 0 10px 10px;
            height: 30px;
        }

        .company-info {
            font-size: 11px;
            color: #444;
            margin-top: 5px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #4CAF50;
            text-transform: uppercase;
        }

        /* Form Fields Grid */
        .grid-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 15px;
            border: 1px solid #bba35a;
            border-radius: 10px;
            overflow: hidden;
        }

        .grid-td {
            border-right: 1px solid #bba35a;
            border-bottom: 1px solid #bba35a;
            padding: 5px 10px;
            vertical-align: middle;
        }

        .grid-td.label {
            color: #6d6d6d;
            font-weight: bold;
            background-color: #fdfdfd;
            width: 15%;
        }

        .grid-td.value {
            font-weight: bold;
            color: #000;
        }

        .grid-td.no-border-right {
            border-right: none;
        }

        .grid-td.no-border-bottom {
            border-bottom: none;
        }

        .date-box {
            text-align: center;
            width: 40px;
        }

        /* Concept / Table Section */
        .concept-section {
            border: 1px solid #bba35a;
            border-radius: 10px;
            padding: 0;
            margin-bottom: 15px;
            min-height: 300px;
        }

        .concept-header {
            background-color: #fdfdfd;
            color: #6d6d6d;
            font-weight: bold;
            padding: 8px 15px;
            border-bottom: 1px solid #bba35a;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table th {
            background-color: #4CAF50;
            color: white;
            padding: 8px;
            font-size: 10px;
            text-align: center;
            border: 1px solid #fff;
        }

        .details-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            font-size: 11px;
            text-align: center;
        }

        .total-row-highlight {
            background-color: #e8f5e9;
            font-weight: bold;
        }

        /* Footer / Signatures */
        .footer-grid {
            width: 100%;
            margin-top: 30px;
            border-collapse: separate;
            border-spacing: 10px;
        }

        .signature-box {
            border: 1px solid #bba35a;
            border-radius: 10px;
            height: 100px;
            vertical-align: bottom;
            padding: 10px;
            width: 50%;
            position: relative;
        }

        .signature-label {
            position: absolute;
            top: 5px;
            left: 10px;
            font-weight: bold;
            color: #4CAF50;
            font-size: 12px;
        }

        .signature-line {
            border-top: 1px solid #bba35a;
            margin-top: 60px;
            padding-top: 5px;
            font-size: 10px;
        }

        .watermark {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.05;
            z-index: -1;
            width: 400px;
        }
    </style>
</head>

<body>
    @php
        $fechaNacimiento = new DateTime($aprendiz->fecha_nacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($fechaNacimiento)->y;

        // Break down date
        $dateObj = new DateTime($fecha ?? 'now');
        $dia = $dateObj->format('d');
        $mes = $dateObj->format('m');
        $anio = $dateObj->format('Y');

        // Logic for client name
        $clientName = $aprendiz->name . ' ' . $aprendiz->apellido;
        $clientDoc = $aprendiz->documento;
        if ($edad < 18 && $aprendiz->attendant) {
            $clientName = $aprendiz->attendant->name . ' ' . $aprendiz->attendant->apellido;
            $clientDoc = $aprendiz->attendant->documento;
        }
    @endphp

    <div class="receipt-container">
        <!-- Background Logo Watermark -->
        <img src="{{ public_path('Logo.png') }}" class="watermark" alt="Watermark">

        <!-- Header: Logo + Title -->
        <table class="header-table">
            <tr>
                <td class="header-logo">
                    <img src="{{ public_path('Logo.png') }}" style="height: 70px;" alt="Logo">
                    <div class="company-name">MC Language Studies SAS</div>
                    <div class="company-info">
                        <strong>NIT:</strong> 901809528-9<br>
                        Calle 15 # 19-30, Fonseca, La Guajira<br>
                        Tel: 317 396 1175 | info@mcstudies.com
                    </div>
                </td>
                <td class="header-title-box">
                    <div class="title-box">Estado de Cuenta</div>
                    <div class="title-sub-box"></div> <!-- White space below green header -->
                </td>
            </tr>
        </table>

        <!-- Info Grid 1: City, Dates, Number -->
        <table class="grid-table">
            <tr>
                <td class="grid-td label" style="width: 15%;">Ciudad</td>
                <td class="grid-td value" style="width: 35%;">Fonseca, La Guajira</td>
                <td class="grid-td label date-box" style="width: 5%; text-align: center;">D&iacute;a</td>
                <td class="grid-td label date-box" style="width: 5%; text-align: center;">Mes</td>
                <td class="grid-td label date-box" style="width: 10%; text-align: center;">A&ntilde;o</td>
                <td class="grid-td label" style="width: 10%; border-right: none; color: #bba35a;">No.</td>
            </tr>
            <tr>
                <td class="grid-td label no-border-bottom">Cliente</td>
                <td class="grid-td value no-border-bottom" style="font-size: 14px;">{{ $clientName }}</td>
                <td class="grid-td value date-box no-border-bottom">{{ $dia }}</td>
                <td class="grid-td value date-box no-border-bottom">{{ $mes }}</td>
                <td class="grid-td value date-box no-border-bottom">{{ $anio }}</td>
                <td class="grid-td value no-border-bottom no-border-right" style="color: red; font-size: 14px;">
                    {{-- Placeholder or dynamic ID if available --}}
                    {{ $aprendiz->documento }}
                </td>
            </tr>
        </table>

        <!-- Amount Row -->
        <table class="grid-table" style="margin-top: -16px; border-top: none; border-radius: 0 0 10px 10px;">
            <tr>
                <td class="grid-td label" style="width: 15%; border-top: 1px solid #bba35a;">Documento</td>
                <td class="grid-td value" style="border-top: 1px solid #bba35a; border-right: none;">{{ $clientDoc }}
                </td>
            </tr>
        </table>

        <!-- Concept / Details Section -->
        <div class="concept-section">
            <div class="concept-header">Concepto / Detalle de Pagos</div>

            <table class="details-table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Fecha</th>
                        <th>Metodo</th>
                        <th>Vr. M&oacute;dulo</th>
                        <th>Descuento</th>
                        <th>Abono</th>
                        <th>Pendiente</th>`
                        <th>Plataforma</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $precio = 0;
                        $descuento = 0;
                        $totalAbono = 0;
                        $totalPendiente = 0;
                    @endphp

                    @forelse ($informes as $informe)
                        @php
                            if ($informe->apprentice->modality_id != 4) {
                                $valorModulo = $informe->apprentice->modality->valor;
                            } else {
                                $valorModulo = $informe->apprentice->valor;
                            }
                            $rowPrice = $valorModulo;
                            $rowDiscount = $informe->apprentice->descuento;
                            $rowAbono = $informe->abono;
                            $rowPending = $rowPrice - $rowDiscount - $totalAbono - $rowAbono;

                            $precio = $valorModulo;
                            $descuento = $informe->apprentice->descuento;
                            $totalAbono += $informe->abono;
                            $pendiente = $precio - $descuento - $totalAbono;
                        @endphp


                        <tr>
                            <td style="text-align: left; padding-left: 10px;">Pago Cuota / M&oacute;dulo</td>
                            <td>{{ $informe->fecha }}</td>
                            <td>{{ $informe->metodo }}</td>
                            <td>${{ number_format($valorModulo, 0, ',', '.') }}</td>
                            <td>${{ number_format($informe->apprentice->descuento, 0, ',', '.') }}</td>
                            <td>${{ number_format($informe->abono, 0, ',', '.') }}</td>
                            <td>${{ number_format($pendiente, 0, ',', '.') }}</td>
                            <td>${{ number_format($informe->apprentice->plataforma, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 20px;">No hay registros de pagos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <table class="details-table" style="margin-top: 20px; border-top: 2px solid #bba35a;">
                <tr class="total-row-highlight">
                    <td style="text-align: right; width: 40%;">TOTALES ACUMULADOS</td>
                    <td>DTO: ${{ number_format($descuento, 0, ',', '.') }}</td>
                    <td>PAGADO: ${{ number_format($totalAbono, 0, ',', '.') }}</td>

                    @php
                        $saldoPendienteFinal = $precio - $descuento - $totalAbono;
                    @endphp

                    <td style="color: #d32f2f;">DEBE:
                        ${{ number_format($saldoPendienteFinal < 0 ? 0 : $saldoPendienteFinal, 0, ',', '.') }}</td>

                    @if ($count != 0)
                        <td>PLAT: ${{ number_format($aprendiz->plataforma, 0, ',', '.') }}</td>
                    @else
                        <td style="font-size: 10px; color: green;">PLAT. PAGADA</td>
                    @endif
                </tr>
            </table>
        </div>

        <!-- Total Value Box (Mimicking "Valor (en letras)") -->
        <table class="grid-table">
            <tr>
                <td class="grid-td label" style="width: 20%;">Total Pagado</td>
                <td class="grid-td value no-border-right">
                    $ {{ number_format($totalAbono + ($count != 0 ? 0 : $aprendiz->plataforma), 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <!-- Signatures -->
        <table class="footer-grid">
            <tr>
                <td>
                    <div class="signature-box">
                        <div class="signature-label">Firma de Recibido / Cliente</div>
                        <div class="signature-line">
                            C.C. / NIT: {{ $clientDoc }}
                        </div>
                    </div>
                </td>
                <td>
                    <div class="signature-box">
                        <div class="signature-label">Aprobado / MC Language Studies</div>

                        <!-- Digital signature placeholder or stamp -->
                        <div style="text-align: center; margin-top: 10px;">
                            <img src="{{ public_path('Logo.png') }}"
                                style="height: 40px; opacity: 0.5; filter: grayscale(100%);" alt="Sello">
                        </div>

                        <div class="signature-line" style="margin-top: 10px;">
                            Autorizado
                        </div>
                    </div>
                </td>
            </tr>
        </table>

    </div>

</body>

</html>
