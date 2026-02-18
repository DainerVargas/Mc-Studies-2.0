<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #334155;
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #99BF51;
            padding: 30px;
            text-align: center;
            color: white;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
        }

        .content {
            padding: 40px;
        }

        .greeting {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1e293b;
        }

        .details-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 30px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 8px;
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .label {
            font-weight: 600;
            color: #64748b;
        }

        .value {
            font-weight: 700;
            color: #1e293b;
        }

        .total-row {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
        }

        .total-label {
            font-size: 18px;
            font-weight: 800;
            color: #1e293b;
        }

        .total-value {
            font-size: 20px;
            font-weight: 800;
            color: #99BF51;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #94a3b8;
            background-color: #f8fafc;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Notificación de Pago</h1>
        </div>
        <div class="content">
            <p class="greeting">Hola, {{ $registerHour->teacher->name }} {{ $registerHour->teacher->apellido }}</p>
            <p>Se ha registrado un pago por las horas docentes trabajadas. Aquí están los detalles del reporte:</p>

            <div class="details-card">
                <div class="detail-item">
                    <span class="label">Horas Totales:</span>
                    <span class="value">{{ $registerHour->horas }}h</span>
                </div>
                <div class="detail-item">
                    <span class="label">Método de Pago:</span>
                    <span class="value">{{ $metodoPago }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Precio por Hora:</span>
                    <span class="value">${{ number_format($registerHour->teacher->precio_hora) }}</span>
                </div>
                <div class="detail-item total-row">
                    <span class="total-label">Monto Total:</span>
                    <span
                        class="total-value">${{ number_format($registerHour->horas * $registerHour->teacher->precio_hora) }}</span>
                </div>
            </div>

            <p>Si tienes alguna pregunta sobre este pago, por favor contacta con la administración.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Mc Studies. Todos los derechos reservados.
        </div>
    </div>
</body>

</html>
