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
            margin-bottom: 10px;
        }

        .tabla-calificaciones th {
            background: #05CCD1;
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

        .conteBtn{
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: end;
            gap: 15px;
        }

        .conteBtn button{
            padding: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 700;
            color: white;
            border: 1px solid #b1b1b1;
            border-radius: 4px;
        }

        .conteBtn button:hover{
            transform: scale(1.05);
        }

        .btn-send{
            background-color: #05CCD1;
        }
        .btn-donwload{
            background-color: #99BF51;
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

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        /* Contenedor principal */
        .conte_certificate {
            position: relative;
            background: #ffffff;
            width: 520px;
            padding: 30px 35px;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            gap: 25px;
            font-family: 'Poppins', sans-serif;
            animation: fadeIn 0.3s ease-out;
        }

        /* Animación de entrada */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Encabezado */
        .between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e5e5e5;
            padding-bottom: 10px;
        }

        .between h4 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #333;
            letter-spacing: 0.3px;
        }

        .between .material-symbols-outlined {
            cursor: pointer;
            font-size: 22px;
            transition: transform 0.2s, color 0.2s;
        }

        .between .material-symbols-outlined:hover {
            color: #ff5a5f;
            transform: scale(1.1);
        }

        /* Contenido del modal */
        .flex {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        textarea {
            width: 100%;
            min-height: 120px;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
            color: #444;
            outline: none;
            resize: none;
            transition: all 0.2s ease-in-out;
            font-family: 'Poppins', sans-serif;
        }

        textarea:focus {
            border-color: #00a9e0;
            box-shadow: 0 0 0 2px rgba(0, 169, 224, 0.15);
        }

        /* Botón */
        .btn_certi {
            background: linear-gradient(135deg, #00a9e0, #007bbd);
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            border: none;
            border-radius: 8px;
            padding: 10px 22px;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 3px 10px rgba(0, 169, 224, 0.3);
        }

        .btn_certi:hover {
            background: linear-gradient(135deg, #0092c7, #006aa3);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 169, 224, 0.4);
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
                <span wire:click="showCertificate" class="material-symbols-outlined">
                    license
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
                <p>Fecha-Nacimiento: <span>{{ $aprendiz->fecha_nacimiento->format('d/m/Y') }}</span> </p>
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
                <p>Nombre: <span>{{ $aprendiz->attendant->name ?? '' }} {{ $aprendiz->attendant->apellido ?? '' }}</span>
                </p>
                <p>Email: <span>{{ $aprendiz->attendant->email ?? '' }}</span>
                </p>
                <p>Telefono: <span>{{ $aprendiz->attendant->telefono ?? '' }}</span>
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

                <div class="conteBtn">
                    <button class="btn-send" wire:click="sendQualification">Enviar</button>
                    <button class="btn-donwload" wire:click="donwloadQualification">Descargar</button>
                </div>
            </div>
        @endif

        @if ($viewCertificate)
            <div class="overlay">
                <div class="conte_certificate">
                    <div class="between">
                        <span></span>
                        <h4>Describe el reconocimiento</h4>
                        <span wire:click="showCertificate" class="material-symbols-outlined">close</span>
                    </div>

                    <div class="flex">
                        <textarea wire:model="textReconocimiento" placeholder="Escribe aquí el texto del reconocimiento..."></textarea>
                    </div>

                    @error('textReconocimiento')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror

                    <div class="flex">
                        <button class="btn_certi" wire:click="generateCertificate({{ $aprendiz->id }})">
                            Generar Certificado
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
