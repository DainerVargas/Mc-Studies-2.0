<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe Profesores</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app-hjctGKyo.css') }}">
</head>

<body>
    @vite('resources/sass/app.scss')
    <div class="descarga">
        <div class="container">
            <div class="content">
                @php
                    $total = 0;
                @endphp
                <table width="100%" border="1px">
                    <thead>
                        <tr>
                            <th colspan="4">Informe Estudiantes</th>
                        </tr>
                        <tr>
                            <td colspan="2">MC Language studies</td>
                        </tr>
                        <tr>
                            <td>Fecha:</td>
                            <td>{{ $fecha }}</td>
                        </tr>
                        <tr>
                            <th>No.</th>
                            <th>Profesor</th>
                            <th>Valor Pagado</th>
                            <th>Fecha de Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                            $total = 0;
                        @endphp
                        @forelse ($informes as $informe)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $informe->teacher->name }}</td>
                                <td>${{ $informe->abono }}</td>
                                @php
                                    $total += $informe->abono;
                                    $fecha = isset($informe->fecha) ? $informe->fecha : 'Sin fecha';
                                @endphp
                                <td>{{ $fecha }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <p class="nodatos">No hay datos</p>
                                </td>
                            </tr>
                        @endforelse
    
                        <td colspan="2">Total: </td>
                        <td>${{ $total }}</td>
                    </tbody>
                </table>

            </div>
            <div class="footer">
                <p>Tu equipo {{ config('app.name') }}</p>
            </div>
        </div>
    </div>
</body>

</html>
