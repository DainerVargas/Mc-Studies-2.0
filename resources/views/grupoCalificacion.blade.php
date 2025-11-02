<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Calificaciones</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            width: 120px;
            height: auto;
            object-fit: contain;
        }

        h1 {
            color: #99BF51;
            font-size: 26px;
            text-align: center;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        .group-info {
            display: inline-flex;
            justify-content: space-around;
            align-items: center;
            width: 100%;
            text-align: center;
            font-size: 14px;
            background-color: #eef3e8;
            border-radius: 8px;
            padding: 10px 0;
            margin-bottom: 25px;
        }

        .group-info p {
            margin: 0;
            font-weight: 600;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
        }

        thead {
            background-color: #99BF51;
            color: white;
        }

        th,
        td {
            text-align: center;
            padding: 10px;
            font-size: 13px;
            border-bottom: 1px solid #eee;
        }

        tbody tr:nth-child(even) {
            background-color: #f6f8f6;
        }

        .high {
            color: #05CCD1;
            font-weight: bold;
        }

        .low {
            color: #d9534f;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 12px;
            color: #666;
        }

        /* Estilo decorativo extra */
        .line {
            width: 80px;
            height: 4px;
            background-color: #99BF51;
            margin: 10px auto 30px;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ public_path('Logo.png') }}" alt="Encabezado">
    </div>

    <h1>Reporte de Calificaciones</h1>
    <div class="line"></div>

    <div class="group-info">
        <p><strong>Grupo:</strong> {{ $groupName }}</p>
        <p><strong>Profesor:</strong> {{ $nameTeacher }}</p>
        <p><strong>Tipo de Grupo:</strong> {{ $typeGroup }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Semestre</th>
                <th>Listening</th>
                <th>Writing</th>
                <th>Reading</th>
                <th>Speaking</th>
                <th>Global</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($qualifications as $semestre => $data)
                <tr>
                    <td>{{ $semestre }}</td>
                    <td class="{{ $data['listening'] >= 75 ? 'high' : 'low' }}">
                        {{ number_format($data['listening'], 1) }}%</td>
                    <td class="{{ $data['writing'] >= 75 ? 'high' : 'low' }}">{{ number_format($data['writing'], 1) }}%
                    </td>
                    <td class="{{ $data['reading'] >= 75 ? 'high' : 'low' }}">{{ number_format($data['reading'], 1) }}%
                    </td>
                    <td class="{{ $data['speaking'] >= 75 ? 'high' : 'low' }}">
                        {{ number_format($data['speaking'], 1) }}%</td>
                    <td class="{{ $data['global'] >= 75 ? 'high' : 'low' }}">{{ number_format($data['global'], 1) }}%
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

</body>

</html>
