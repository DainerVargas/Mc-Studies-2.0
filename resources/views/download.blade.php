<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Profesor</title>
    <link rel="stylesheet" href="{{asset('build/assets/app-Be1cidhe.css')}}">
</head>

<body>
    {{-- @vite('resources/sass/app.scss') --}}
    <div class="descarga">
        <div class="container">
            <div class="header">
                <h1>Información del Profesor</h1>
            </div>
            <div class="content">
                <h2>Detalles del Profesor</h2>
                <p><strong>Nombre:</strong> {{ $teacher->name }} {{ $teacher->apellido }}</p>
                <p><strong>Email:</strong> {{ $teacher->email }}</p>
                <p><strong>Telefono:</strong> {{ $teacher->telefono }}</p>
                <h2>Detalles de la cuenta</h2>
                <p><strong>Nombre:</strong> {{ $teacher->accounts[0]->name}}</p>
                <p><strong>Tipo:</strong> {{ $teacher->accounts[0]->type_account }}</p>
                <p><strong>Número:</strong> {{ $teacher->accounts[0]->number }}</p>
            </div>

            <div class="content">
                <h2>Pagos del Profesor</h2>
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
                        @forelse ($teacher->tinforme as $informe)
                            <tr>
                                <td>$ {{ $informe->abono }}</td>
                                <td>{{ $informe->fecha }}</td>
                            </tr>
                            @php
                                $total += $informe->abono;
                            @endphp
                        @empty
                            <td>No hay datos</td>
                        @endforelse
                        <td>Valor total: $ {{ $total}}</td>
                    </tbody>
                </table>

            </div>
            <div class="footer">
                <p>Tu equipo MC Language Studies</p>
            </div>
        </div>
    </div>
</body>

</html>
