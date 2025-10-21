<div class="componente">
    <style>
        /* Contenedor general */
        .calificaciones-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 25px 35px;
            width: 90%;
            max-width: 800px;
            font-family: 'Poppins', sans-serif;
        }

        .calificaciones-container h4 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.4rem;
            color: #0a58ca;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .calificaciones-container .between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .between span {
            cursor: pointer;
            transform: scale(1.1);
        }

        /* Tabla */
        .tabla-calificaciones {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            background-color: #fff;
        }

        .tabla-calificaciones th {
            background: #0a58ca;
            color: #fff;
            font-weight: 600;
            padding: 12px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .tabla-calificaciones td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            color: #333;
        }

        .tabla-calificaciones tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .tabla-calificaciones tr:hover {
            background-color: #f0f8ff;
            transition: 0.3s ease;
        }

        /* Estilo para promedio por fila */
        .tabla-calificaciones td.promedio {
            font-weight: bold;
            color: #0a58ca;
        }

        /* Fila final (promedios globales) */
        .tabla-calificaciones tr.fila-total {
            background: #e8f5e9;
            font-weight: bold;
            border-top: 2px solid #0a58ca;
        }

        .tabla-calificaciones td.promedio-final {
            color: #198754;
            font-weight: bold;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            .calificaciones-container {
                width: 95%;
                padding: 20px;
            }

            .tabla-calificaciones th,
            .tabla-calificaciones td {
                padding: 8px;
                font-size: 0.9rem;
            }
        }
    </style>
    <div class="headerInfo">
        <div class="back">
            <a href="{{ route('listaAprendiz') }}">
                <img title="Go back" src="/images/atras.png" alt="">
            </a>
            <div class="conteImage">
                @if ($aprendiz->imagen)
                    <img class="perfilImg" src="{{ asset('users/' . $aprendiz->imagen) }}" alt="">
                @else
                    <img class="perfilImg" src="{{ asset('images/perfil.png') }}" alt="">
                @endif
            </div>
        </div>
        <div class="nameTeacher">
            @php
                if ($aprendiz->group_id == null) {
                    $profesor = 'Sin profesor';
                } elseif ($aprendiz->group->teacher_id != null) {
                    $profesor = $aprendiz->group->teacher->name . ' ' . $aprendiz->group->teacher->apellido;
                } else {
                    $profesor = 'Sin profesor';
                }
            @endphp
            <p>Profesor: <span>{{ $profesor }}</span></p>
        </div>
        @if ($user->rol_id == 1)
            <div class="estado">
                @if ($aprendiz->estado == 1)
                    <div class="active">
                        <p class="textestado">Active</p>
                    </div>
                    <div class="botonActive">
                        <button wire:click="toggleEstado({{ $aprendiz->id }})"
                            wire:confirm="¿Quieres deshabilitar al aprendiz: {{ $aprendiz->name }}?"></button>
                    </div>
                @else
                    <div class="inactive">
                        <p class="textestado">Inactive</p>
                    </div>
                    <div class="botonInactive">
                        <button wire:click="toggleEstado({{ $aprendiz->id }})"
                            wire:confirm="¿Quieres habilitar al aprendiz: {{ $aprendiz->name }}?"></button>
                    </div>
                @endif
            </div>
        @else
            <div>

            </div>
        @endif
    </div>

    <div class="mainInfo">
        <div class="infoEstado">
            <p class="name">{{ $aprendiz->name }} {{ $aprendiz->apellido }}</p>
            <p>{{ $aprendiz->modality->name }}</p>

            <div class="eye">
                @if ($aprendiz->group_id == null)
                    <p>Sin Grupo</p>
                @else
                    <p>{{ $aprendiz->group->name }}</p>
                @endif

                <span title="Visualizar comprobante de pago" wire:click="show(1)" class="material-symbols-outlined">
                    visibility
                </span>
                <a href="{{ route('donwload', $aprendiz->id) }}">
                    <span class="material-symbols-outlined" title="Descargar documento">
                        download
                    </span>
                </a>
                <span title="Ver calificación" wire:click="showQualification" class="material-symbols-outlined">
                    rewarded_ads
                </span>

                @if ($aprendiz->comprobante == null && $valor == 1)
                    <small>No hay comprobante de pago</small>
                @endif
            </div>
            <div class="estado">
                <span>Estatus:</span>
                @if ($aprendiz->estado == 0)
                    <button class="inactive">Inactive</button>
                @else
                    <button class="active">active</button>
                @endif
            </div>
        </div>
        <div class="informacion">
            <p class="title">Información Personal</p>
            <div class="datos">
                <p>Nombre: <span>{{ $aprendiz->name }}</span> </p>
                <p>Apellido: <span>{{ $aprendiz->apellido }}</span> </p>
                <p>Edad: <span>{{ $edadActualizada }}</span> </p>
                <p>Fecha-Nacimiento: <span>{{ $aprendiz->fecha_nacimiento }}</span> </p>
                <p>Dirección:
                    <span>{{ isset($aprendiz->direccion) ? $aprendiz->direccion : 'No hay dirección' }}</span>
                </p>
                <p>Sede: <span>{{ $aprendiz->sede->sede }}</span> </p>
                @if ($aprendiz->edad > 17)
                    <p>Documento: <span>{{ $aprendiz->documento ?? 'No hay documento' }}</span></p>
                @endif
                <p>Fecha-Inicio: <span>{{ $aprendiz->fecha_inicio }}</span></p>
                <p>Fecha-Finalización: <span>{{ $aprendiz->fecha_fin }}</span></p>
            </div>
        </div>
        <div class="infoAcudiente">
            <p class="title">Información Acudiente</p>
            <div class="datos">
                <p>Nombre: <span>{{ $aprendiz->attendant->name }} {{ $aprendiz->attendant->apellido }}</span>
                </p>
                <p>Email: <span>{{ $aprendiz->attendant->email }}</span>
                </p>
                <p>Telefono: <span>{{ $aprendiz->attendant->telefono }}</span>
                </p>
                @if ($aprendiz->edad < 18)
                    <p>Documento: <span>{{ $aprendiz->attendant->documento ?? 'No hay documento' }}</span></p>
                @endif
            </div>
            @if ($user->rol_id == 1)
                <a href="{{ route('viewUpdate', $aprendiz->id) }}"><button> Ir Actualizar <span
                            class="material-symbols-outlined">
                            directions_run
                        </span> </button></a>
            @endif
        </div>
        @if ($valor > 0)
            <div class="absolute">
                @if ($aprendiz->comprobante == 'Sin comprobante' || $aprendiz->comprobante == null)
                @else
                    <img src="/users/{{ $aprendiz->comprobante }}" alt="">
                    <span wire:click="show(0)" class="material-symbols-outlined close" title="Cerrar">
                        close
                    </span>
                    <a href="/users/{{ $aprendiz->comprobante }}" download="">
                        <span class="material-symbols-outlined download" title="Descargar">
                            download
                        </span>
                    </a>
                @endif
            </div>
        @endif

        @if ($view)
            <div class="calificaciones-container">
                <div class="between">
                    <span></span>
                    <h4>Calificaciones</h4>
                    <span wire:click="showQualification" style="color: red" class="material-symbols-outlined">
                        close
                    </span>
                </div>

                <table class="tabla-calificaciones">
                    <thead>
                        <tr>
                            <th>Resultado</th>
                            <th>Listening</th>
                            <th>Reading</th>
                            <th>Speaking</th>
                            <th>Writing</th>
                            <th>Promedio Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $totalListening = 0;
                            $totalReading = 0;
                            $totalSpeaking = 0;
                            $totalWriting = 0;
                            $count = $qualifications->count();
                        @endphp

                        @forelse ($qualifications as $qualification)
                            @php
                                $promedioFila =
                                    ($qualification->listening +
                                        $qualification->reading +
                                        $qualification->speaking +
                                        $qualification->writing) /
                                    4;

                                $totalListening += $qualification->listening;
                                $totalReading += $qualification->reading;
                                $totalSpeaking += $qualification->speaking;
                                $totalWriting += $qualification->writing;

                                $resultado = match ($qualification->semestre) {
                                    1 => 'Resultado 1',
                                    2 => 'Resultado 2',
                                    3 => 'Resultado 3',
                                    default => 'Resultado',
                                };
                            @endphp

                            <tr>
                                <td>{{ $resultado }}</td>
                                <td>{{ $qualification->listening }}</td>
                                <td>{{ $qualification->reading }}</td>
                                <td>{{ $qualification->speaking }}</td>
                                <td>{{ $qualification->writing }}</td>
                                <td class="promedio">{{ number_format($promedioFila, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Sin Resultados</td>
                            </tr>
                        @endforelse

                        @if ($count > 0)
                            <tr class="fila-total">
                                <td>Promedio Global</td>
                                <td>{{ number_format($totalListening / $count, 2) }}</td>
                                <td>{{ number_format($totalReading / $count, 2) }}</td>
                                <td>{{ number_format($totalSpeaking / $count, 2) }}</td>
                                <td>{{ number_format($totalWriting / $count, 2) }}</td>
                                <td class="promedio-final">
                                    {{ number_format(($totalListening + $totalReading + $totalSpeaking + $totalWriting) / ($count * 4), 2) }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
