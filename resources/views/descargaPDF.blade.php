<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Aprendiz</title>
    <link rel="stylesheet" href="{{asset('build/assets/app-Be1cidhe.css')}}">
</head>

<body>
     @vite('resources/sass/app.scss')
    <div class="descarga">
        <div class="container">
            <div class="header">
                <h1>Información del Aprendiz</h1>
            </div>
            <div class="content">
                <h2>Detalles del Aprendiz</h2>
                <p><strong>Nombre:</strong> {{ $aprendiz->name }} {{ $aprendiz->apellido }}</p>
                <p><strong>Edad:</strong> {{ $aprendiz->edad }}</p>
                <p><strong>Fecha de Nacimiento:</strong> {{ $aprendiz->fecha_nacimiento }}</p>
                <p><strong>Dirección:</strong> {{ $aprendiz->direccion }}</p>
                <p><strong>Modalidad:</strong> {{ $aprendiz->modality->name }}</p>
                @if ($aprendiz->attendant->id == 1)
                    <p><strong>Email:</strong> {{ $aprendiz->email }}</p>
                    <p><strong>Telefono:</strong> {{ $aprendiz->telefono }}</p>
                @endif
            </div>
            @if ($aprendiz->attendant->id != 1)
                <div class="details">
                    <h2>Detalles del Acudiente</h2>
                    <p><strong>Nombre:</strong> {{ $aprendiz->attendant->name }} {{ $aprendiz->attendant->apellido }}
                    </p>
                    <p><strong>Email:</strong> {{ $aprendiz->attendant->email }}</p>
                    <p><strong>Teléfono:</strong> {{ $aprendiz->attendant->telefono }}</p>
                </div>
            @endif
            <div class="content">
                <h2>Pagos del Aprendiz</h2>
                @php
                    $total = 0;
                @endphp
                <table width="100%" border="1px">
                    <thead>
                        <tr>
                            <th>Valor</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($aprendiz->informe as $informe)
                            <tr>
                                <td>{{ $informe->abono }}</td>
                                <td>{{ $informe->fecha }}</td>
                            </tr>
                            @php
                                $total += $informe->abono;
                            @endphp
                        @empty
                            <td>No hay datos</td>
                        @endforelse
                        <tr>
                            <td colspan="2">Plataforma: {{$aprendiz->plataforma ?? 0}}</td>
                        </tr>
                        <td colspan="2">Total: {{ $total + $aprendiz->plataforma ?? 0 }}</td>
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
