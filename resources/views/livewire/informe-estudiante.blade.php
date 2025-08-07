<div class="componente">
    <div class="links">
        <a wire:click="activar(1)" class="activea{{ $active }}">Aprendices</a>
        <a wire:click="activar(2)" class="activep{{ $active }}">Profesores</a>
        <a wire:click="activar(3)" class="active{{ $active }}">Copia de seguridad</a>
    </div>
    @if ($active == 1)
        <div class="conteFiltro">
            <form style="display: flex; gap: 10px; align-items: center; width: 90%;">
                <div class="conteInput">
                    <label for="filtro">Filtra por el nombre del Estudiante</label>
                    <input type="text" wire:model.live="filtro" placeholder="Nombre del estudiante" style="width: 200px">
                </div>
                <div class="mes">
                    <select wire:model.live="sede_id" title="Filtrar por mes">
                        <option value="" selected>Sedes</option>
                        <option value="1">Fonseca</option>
                        <option value="2">San Juan</option>
                    </select>
                </div>
                <div class="mes">
                    <select wire:model.live="mes" title="Filtrar por mes">
                        <option value="00" selected="">Mes</option>
                        <option value="01">Enero</option>
                        <option value="02">Febrero</option>
                        <option value="03">Marzo</option>
                        <option value="04">Abril</option>
                        <option value="05">Mayo</option>
                        <option value="06">Junio</option>
                        <option value="07">Julio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>

                <div class="year">
                    <span class="material-symbols-outlined" wire:click="previous">
                        skip_previous
                    </span>
                    <p>{{ $year }}</p>
                    <span class="material-symbols-outlined" wire:click="next">
                        skip_next
                    </span>
                </div>

                <div class="mes">
                    <select wire:model.live="estado" title="Filtrar por estado">
                        <option value="0" selected="">Todos</option>
                        <option value="1">Pagado</option>
                        <option value="2">Pendiente</option>
                    </select>
                </div>
                <div class="new_modulo" style="width:170px">
                    <div style="cursor: pointer" class="contelink"
                        wire:confirm="Estas seguro?, Se guardará la información para luego eliminar la información del informe."
                        wire:click="saveInforme">
                        Nuevo Módulo

                    </div>
                    {{-- <select wire:model.live="modulo" title="Filtrar por modulo">
                        <option value="" selected="">Módulo</option>
                        <option value="1">Módulo 1</option>
                        <option value="2">Módulo 2</option>
                    </select> --}}
                </div>

                <div class="contelink" style="width: 250px">
                    <a href="{{ route('descargar', $mes) }}"> Descargar Informe
                        <span class="material-symbols-outlined" title="Descargar documento">
                            download
                        </span>
                    </a>
                </div>
            </form>
        </div>
        <div class="containerConte">
            <div class="conteTable">
                <table class="tableInforme">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Acudiente</th>
                            <th>Estudiante</th>
                            <th>Becado</th>
                            <th>Valor Modulo</th>
                            <th>Descuento</th>
                            <th>Abono</th>
                            <th>Pendiente</th>
                            <th>Plataforma de Pago</th>
                            <th>Abonar</th>
                            <th>Fecha</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                            $totalAbono = 0;
                            $plataforma = 0;
                            $background = 'white';
                            $plataforma = 0;
                            $color = '#000000';
                            $valorModulo = 0;
                            $fechaPlataforma = Date::now()->year;
                        @endphp
                        @forelse ($informes ?? [] as $informe)
                            @php
                                $mes = \Carbon\Carbon::parse($informe->apprentice->fecha_inicio)->month;
                            @endphp
                            @if ($informe->apprentice->estado)
                                @php

                                    $isBecado = $informe->apprentice->becado_id == 1;
                                    if (!$isBecado) {
                                        $value =
                                            $informe->apprentice->valor -
                                            $informe->apprentice->descuento -
                                            $informe->total_abonos;

                                        $totalAbono += $informe->total_abonos;
                                    } else {
                                        $value = 0;
                                    }

                                    if ($informe->total_abonos <= 300000) {
                                        $color = 'red';
                                    }
                                    if ($informe->total_abonos > 300000 && $informe->abono <= 799999) {
                                        $color = 'orange';
                                    }
                                    if ($informe->total_abonos >= 800000) {
                                        $color = 'green';
                                    }
                                @endphp

                                <tr class="{{ $value == 0 ? 'active' : '' }}">
                                    <td style="color: {{ $color }}">{{ $count++ }}
                                    </td>
                                    <td class="relative">
                                        {{ $informe->apprentice->attendant->name }}
                                    </td>
                                    <td>
                                        <a href="{{ route('estadoCuenta', $informe->apprentice->id) }}">
                                            {{ $informe->apprentice->name . ' ' . $informe->apprentice->apellido }}
                                        </a>
                                    </td>
                                    <td class="relative">
                                        {{ $informe->apprentice->becado->name ?? 'N/A' }}
                                    </td>

                                    @php
                                        if ($informe->apprentice->becado_id != 1) {
                                            if ($informe->apprentice->modality_id != 4) {
                                                $valorModulo = $informe->apprentice->modality->valor;
                                            } else {
                                                $valorModulo = $informe->apprentice->valor;
                                            }
                                        }
                                    @endphp
                                    @if ($informe->apprentice->becado_id != 1)
                                        <td>$
                                            {{ number_format($valorModulo , 0, ',', '.') }}
                                        </td>
                                    @else
                                        <td>$
                                            0
                                        </td>
                                    @endif
                                    <td>
                                        <div class="flex">
                                            @if ($informe->apprentice->becado_id != 1)
                                                ${{ number_format($informe->apprentice->descuento, 0, ',', '.') }}
                                                <span wire:click="descuento({{ $informe->apprentice->id }})"
                                                    class="material-symbols-outlined editar"
                                                    title="Actualizar descuento">
                                                    edit
                                                </span>
                                            @else
                                                $ 0
                                            @endif
                                        </div>
                                    </td>

                                    <td style="color: {{ $color }}">
                                        @if ($informe->apprentice->becado_id != 1)
                                            ${{ number_format($informe->total_abonos, 0, ',', '.') }}
                                        @else
                                            $ 0
                                        @endif
                                    </td>

                                    @php
                                        $valueAprendiz = 0;
                                        if ($informe->apprentice->becado_id != 1) {
                                            if ($informe->apprentice->modality_id != 4) {
                                                $valueAprendiz = $informe->apprentice->modality->valor;
                                            } else {
                                                $valueAprendiz = $informe->apprentice->valor;
                                            }
                                            $pendiente =
                                                $valueAprendiz -
                                                $informe->total_abonos -
                                                $informe->apprentice->descuento;

                                            if ($informe->apprentice->fechaPlataforma == $fechaPlataforma) {
                                                $plataforma += $informe->apprentice->plataforma ?? 0;
                                            }
                                        } else {
                                            $pendiente = 0;
                                        }
                                    @endphp
                                    <td>${{ number_format($pendiente, 0, ',', '.') }}
                                    </td>
                                    <td style="color: green">
                                        @if ($informe->apprentice->plataforma == null || $informe->apprentice->plataforma == 0)
                                            <div class="flex">
                                                <button wire:confirm="¿Deseas abonar la plataforma al estudiante?"
                                                    class="update"
                                                    wire:click="plataforma({{ $informe->apprentice->id }})"
                                                    type="button"><span class="material-symbols-outlined">
                                                        payments
                                                    </span> $140000</button>
                                            </div>
                                        @else
                                            ¡Completado!
                                            @if ($informe->apprentice->becado_id != 1)
                                                <span wire:click="activePlataforma({{ $informe->apprentice->id }})"
                                                    class="material-symbols-outlined editar" title="Actualizar fecha">
                                                    edit
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                                    <td style="color: green">
                                        @if ($pendiente != 0)
                                            <div class="flex">
                                                <button class="update"
                                                    wire:click="abonar({{ $informe->apprentice->id }})"
                                                    type="button"><span class="material-symbols-outlined">
                                                        payments
                                                    </span> Abonar</button>
                                            </div>
                                        @else
                                            ¡Completado!
                                        @endif
                                    </td>
                                    @php
                                        $fecha = isset($informe->fecha) ? $informe->fecha : 'Sin fecha';
                                    @endphp
                                    <td>
                                        <div class="flex">
                                            {{ $fecha }} <span 
                                            wire:click="aumentar({{ $informe->id }})"
                                                class="material-symbols-outlined editar" title="Actualizar fecha">
                                                edit
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex">
                                            <form>
                                                <textarea class="observaciones" wire:model.defer="observaciones.{{ $informe->apprentice->id }}" rows="2"></textarea>

                                                <img wire:click="saveObservacion({{ $informe->apprentice->id }})"
                                                    title="Guardar observaciones" class="save"
                                                    src="{{ asset('images/save.png') }}" alt="">
                                            </form>
                                        </div>
                                        <small wire:loading
                                            wire:target="saveObservacion({{ $informe->apprentice->id }})">Cargando...</small>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="12">
                                    <p class="nodatos">No hay datos</p>
                                    <video class="video" src="/videos/video2.mp4" height="180vw" autoplay loop>
                                        <source src="/videos/video2.mp4" type="">
                                    </video>
                                </td>
                            </tr>
                        @endforelse

                        <td colspan="4">Total: </td>
                        <td>${{ number_format($totalModulos - $totalDescuento, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalDescuento, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalAbono, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalPendiente, 0, ',', '.') }}</td>
                        <td>${{ number_format($plataforma, 0, ',', '.') }}</td>
                        <td colspan="3">
                            ${{ number_format($plataforma + $totalModulos - $totalDescuento, 0, ',', '.') }}</td>
                    </tbody>
                </table>

                @if ($viewDescuento == 1)
                    <div class="conteUpdate" id="informe">
                        <div class="close">
                            <span wire:click="ocultar" title="Cerrar" class="material-symbols-outlined">
                                close
                            </span>
                        </div>
                        <form wire:submit="saveDescuento({{ $aprendizArray->id }})">
                            <div class="containerContent">
                                <div class="conteInput">
                                    <input wire:model="nameF" class="input" readonly type="text"
                                        placeholder="nombre">
                                    <label class="label">Estudiante</label>
                                </div>
                                <div class="conteInput">
                                    <input wire:model="descuent" class="input" type="text"
                                        placeholder="Descuento">
                                    <label class="label" for="">Descuento</label>
                                    @if (isset($message))
                                        <small class="errors message" style="color: red">{{ $message }}</small>
                                    @endif
                                </div>
                            </div>
                            <button>Guardar</button>
                        </form>
                    </div>
                @endif

                @if ($vista == 1)
                    <div class="conteUpdate" id="informe">
                        <div class="close">
                            <span wire:click="ocultar" title="Cerrar" class="material-symbols-outlined">
                                close
                            </span>
                        </div>
                        <form wire:submit="guardar({{ $idEstudiante }})">
                            <div class="containerContent">
                                <div class="conteInput">
                                    <input wire:model="nameF" class="input" readonly type="text"
                                        placeholder="nombre">
                                    <label class="label">Estudiante</label>
                                </div>
                                <div class="conteInput">
                                    <input wire:model="fecha" class="input" type="text" placeholder="fecha">
                                    <label class="label" for="">Fecha</label>
                                    @if (isset($message))
                                        <small class="errors message" style="color: red">{{ $message }}</small>
                                    @endif
                                </div>
                            </div>
                            <button>Guardar</button>
                        </form>
                    </div>
                @endif

                @if ($viewplataforma == 1)
                    <div class="conteUpdate" id="informe">
                        <div class="close">
                            <span wire:click="ocultar" title="Cerrar" class="material-symbols-outlined">
                                close
                            </span>
                        </div>
                        <form wire:submit="savePlataforma({{ $idEstudiante }})">
                            <div class="containerContent">
                                <div class="conteInput">
                                    <input wire:model="name" class="input" readonly type="text"
                                        placeholder="nombre">
                                    <label class="label">Estudiante</label>
                                </div>
                                <div class="conteInput">
                                    <input wire:model="fechaPlataforma" class="input" type="text"
                                        placeholder="plataforma">
                                    <label class="label" for="">Año Plataforma (2025)</label>
                                    @if (isset($message))
                                        <small class="errors message" style="color: red">{{ $message }}</small>
                                    @endif
                                </div>
                            </div>
                            <button>Guardar</button>
                        </form>
                    </div>
                @endif

            </div>
        </div>

        @if ($view != 0)
            <div class="conteUpdate" id="informe">
                <div class="close">
                    <span wire:click="ocultar" title="Cerrar" class="material-symbols-outlined">
                        close
                    </span>
                </div>
                <form wire:submit="">
                    <div class="containerContent">
                        <div class="conteInput">
                            <input wire:model="name" class="input" readonly type="text" placeholder="nombre"
                                name="" id="">
                            <label class="label" for="">Estudiante</label>
                        </div>
                        <div class="conteInput">
                            <input wire:model="abono" class="input" type="text" placeholder="nombre"
                                name="abono" id="">
                            <label class="label" for="">Abono</label>
                            @error('abono')
                                <small class="errors" style="color: red">{{ $message }}</small>
                            @enderror
                            @if (isset($message))
                                <small class="errors message" style="color: red">{{ $message }}</small>
                            @endif
                        </div>
                    </div>
                    <button wire:click="save({{ $idEstudiante }})">Abonar</button>
                </form>
            </div>
        @endif
    @elseif($active == 2)
        @livewire('tinforme')
    @else
        <div class="conteFiltro">
            <form>
                <div class="conteInput">
                    <label for="filtro">Filtra por el nombre del Estudiante</label>
                    <input type="text" wire:model.live="nameApprentice" placeholder="Nombre del estudiante">
                </div>
                <div class="mes">
                    <select wire:model.live="month" title="Filtrar por mes">
                        <option value="00" selected="">Mes</option>
                        <option value="01">Enero</option>
                        <option value="02">Febrero</option>
                        <option value="03">Marzo</option>
                        <option value="04">Abril</option>
                        <option value="05">Mayo</option>
                        <option value="06">Junio</option>
                        <option value="07">Julio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>

                <div class="year">
                    <span class="material-symbols-outlined" wire:click="previous">
                        skip_previous
                    </span>
                    <p>{{ $yearCopia }}</p>
                    <span class="material-symbols-outlined" wire:click="next">
                        skip_next
                    </span>
                </div>
                <div class="new_modulo mes">
                    {{-- <div style="cursor: pointer" class="contelink"
                        wire:confirm="Estas seguro?, Se guardará la información para luego eliminar la información del informe."
                        wire:click="saveInforme">
                        Nuevo Módulo

                    </div> --}}
                    <select wire:model.live="module" title="Filtrar por modulo">
                        <option value="" selected="">Módulo</option>
                        <option value="1">Módulo 1</option>
                        <option value="2">Módulo 2</option>
                    </select>
                </div>

                <div class="contelink">
                    <a style="cursor: pointer" wire:click="donwload"> Descargar Informe
                        <span class="material-symbols-outlined" title="Descargar documento">
                            download
                        </span>
                    </a>
                </div>
            </form>
        </div>
        <div class="containerConte">
            <div class="conteTable">
                <table class="tableInforme">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Acudiente</th>
                            <th>Estudiante</th>
                            <th>Becado</th>
                            <th>Valor Modulo</th>
                            <th>Descuento</th>
                            <th>Abono</th>
                            <th>Pendiente</th>
                            <th>Plataforma de Pago</th>
                            <th>Fecha</th>
                            <th>Comprobante</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalModulos = 0;
                            $totalAbono = 0;
                            $totalDescuento = 0;
                            $totalPendiente = 0;
                            $totalplataforma = 0;
                        @endphp

                        @forelse ($securityInforme as $key => $informe)
                            @php
                                $totalModulos += $informe->valor;
                                $totalAbono += $informe->abono;
                                $totalDescuento += $informe->descuento;
                                $totalPendiente += $informe->pendiente;
                                $totalplataforma += $informe->plataforma;
                            @endphp

                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td class="relative">
                                    {{ $informe->acudiente }}
                                </td>
                                <td>
                                    {{ $informe->estudiante }}
                                </td>
                                <td class="relative">
                                    {{ $informe->becado }}
                                </td>
                                <td>$
                                    {{ number_format($informe->valor, 0, ',', '.') }}
                                </td>
                                <td>
                                    <div class="flex">
                                        ${{ number_format($informe->descuento, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td>
                                    ${{ number_format($informe->abono, 0, ',', '.') }}
                                </td>
                                <td>${{ number_format($informe->pendiente, 0, ',', '.') }}
                                </td>
                                <td>${{ number_format($informe->plataforma, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{ $informe->fecha ?? 'Sin fecha' }}
                                </td>
                                @php
                                    $extension = pathinfo($informe->comprobante, PATHINFO_EXTENSION);
                                @endphp
                                <td>
                                    {{-- @if ($extension != 'pdf')
                                    <div style="cursor: pointer" wire:click="show({{ $informe->id }})"
                                     class="flex">
                                                <span class="material-symbols-outlined">
                                                    eye_tracking
                                                </span>
                                                <label>Mostrar</label>
                                            </div>

                                            @else
                                            No hay Comprobante
                                        @endif
                                    @else --}}
                                    @if ($extension)
                                        <a href="{{ asset('users/' . $informe->comprobante) }}"
                                            download="Comprobante de pago-{{ $informe->estudiante }}">
                                            <div class="flex">
                                                <label>Descargar <span class="material-symbols-outlined">
                                                        play_for_work
                                                    </span></label>
                                            </div>
                                        </a>
                                    @else
                                        No hay Comprobante
                                    @endif
                                </td>
                                <td>
                                    <div class="flex">{{ $informe->observacion }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12">
                                    <p class="nodatos">No hay datos</p>
                                    <video class="video" src="/videos/video2.mp4" height="180vw" autoplay loop>
                                        <source src="/videos/video2.mp4" type="">
                                    </video>
                                </td>
                            </tr>
                        @endforelse
                        <td colspan="4">Total: </td>
                        <td>${{ number_format($totalModulos, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalDescuento, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalAbono, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalPendiente, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalplataforma, 0, ',', '.') }}</td>
                        <td colspan="3">
                            ${{ number_format($totalplataforma + $totalModulos, 0, ',', '.') }}</td>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
