<div class="componente">
    <div class="links">
        <a wire:click="activar(1)" class="activea{{ $active }}">Aprendices</a>
        <a wire:click="activar(2)" class="activep{{ $active }}">Profesores</a>
    </div>
    @if ($active == 1)
        <div class="conteFiltro">
            <form wire:submit="filtrar">
                <div class="conteInput">
                    <label for="filtro">Filtra por el nombre del Estudiante</label>
                    <input type="text" wire:model.live="filtro" placeholder="Nombre del estudiante">
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

                <div class="contelink">
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
                            <th>Valor Modulo</th>
                            <th>Descuento</th>
                            <th>Abono</th>
                            <th>Pendiente</th>
                            <th>Plataforma de Pago</th>
                            <th>Abonar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                            $totalAbono = 0;
                            $plataforma = 0;
                            $color = '#000000';
                            $valorModulo = 0;
                            $fechaPlataforma = Date::now()->year;
                        @endphp
                        @forelse ($informes ?? [] as $informe)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td class="relative">
                                    {{ $informe->apprentice->attendant->name }}
                                </td>
                                <td>
                                    <a href="{{ route('estadoCuenta', $informe->apprentice->id) }}">
                                        {{ $informe->apprentice->name . ' ' . $informe->apprentice->apellido }}
                                    </a>
                                </td>

                                @php
                                    if ($informe->apprentice->modality_id != 4) {
                                        $valorModulo = $informe->apprentice->modality->valor;
                                    } else {
                                        $valorModulo = $informe->apprentice->valor;
                                    }
                                @endphp
                                <td>$
                                    {{ number_format($valorModulo - $informe->apprentice->descuento, 0, ',', '.') }}
                                </td>
                                <td>
                                    <div class="flex">
                                        ${{ number_format($informe->apprentice->descuento, 0, ',', '.') }} <span
                                            wire:click="descuento({{ $informe->apprentice->id }})"
                                            class="material-symbols-outlined editar" title="Actualizar descuento">
                                            edit
                                        </span>
                                    </div>
                                </td>
                                @php
                                    if ($informe->total_abonos <= 300000) {
                                        $color = 'red';
                                    }
                                    if ($informe->total_abonos > 300000 && $informe->abono <= 799999) {
                                        $color = 'orange';
                                    }
                                    if ($informe->total_abonos >= 800000) {
                                        $color = 'green';
                                    }
                                    $totalAbono += $informe->total_abonos;
                                @endphp

                                <td style="color: {{ $color }}">
                                    ${{ number_format($informe->total_abonos, 0, ',', '.') }} </td>
                                @php
                                    $fecha = isset($informe->fecha) ? $informe->fecha : 'Sin fecha';
                                @endphp
                                @php
                                    $valueAprendiz = 0;
                                    if ($informe->apprentice->modality_id != 4) {
                                        $valueAprendiz = $informe->apprentice->modality->valor;
                                    } else {
                                        $valueAprendiz = $informe->apprentice->valor;
                                    }
                                    $pendiente =
                                        $valueAprendiz - $informe->total_abonos - $informe->apprentice->descuento;

                                    if ($informe->apprentice->fechaPlataforma == $fechaPlataforma) {
                                        $plataforma += $informe->apprentice->plataforma ?? 0;
                                    }
                                @endphp
                                <td>${{ number_format($pendiente, 0, ',', '.') }}
                                </td>
                                <td style="color: green">
                                    <div class="flex">
                                        @if ($informe->apprentice->plataforma == null || $informe->apprentice->plataforma == 0)
                                            <button wire:confirm="¿Deseas abonar la plataforma al estudiante?"
                                                class="update" wire:click="plataforma({{ $informe->apprentice->id }})"
                                                type="button"><span class="material-symbols-outlined">
                                                    payments
                                                </span> $140000</button>
                                    </div>
                                @else
                                    ¡Completado!
                        @endif
                        </td>
                        <td style="color: green">
                            @if ($pendiente != 0)
                                <div class="flex">
                                    <button class="update" wire:click="abonar({{ $informe->apprentice->id }})"
                                        type="button"><span class="material-symbols-outlined">
                                            payments
                                        </span> Abonar</button>
                                </div>
                            @else
                                ¡Completado!
                            @endif
                        </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11">
                                <p class="nodatos">No hay datos</p>
                                <video class="video" src="/videos/video2.mp4" height="180vw" autoplay loop>
                                    <source src="/videos/video2.mp4" type="">
                                </video>
                            </td>
                        </tr>
    @endforelse

    <td colspan="3">Total: </td>
    <td>${{ number_format($totalModulos - $totalDescuento, 0, ',', '.') }}</td>
    <td>${{ number_format($totalDescuento, 0, ',', '.') }}</td>
    <td>${{ number_format($totalAbono, 0, ',', '.') }}</td>
    <td>${{ number_format($totalPendiente, 0, ',', '.') }}</td>
    <td>${{ number_format($plataforma, 0, ',', '.') }}</td>
    <td colspan="3">${{ number_format($plataforma + $totalModulos - $totalDescuento, 0, ',', '.') }}</td>
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
                        <input wire:model="nameF" class="input" readonly type="text" placeholder="nombre">
                        <label class="label">Estudiante</label>
                    </div>
                    <div class="conteInput">
                        <input wire:model="descuent" class="input" type="text" placeholder="Descuento">
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
                        <input wire:model="nameF" class="input" readonly type="text" placeholder="nombre">
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
                    <input wire:model="abono" class="input" type="text" placeholder="nombre" name="abono"
                        id="">
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
@else
@livewire('tinforme')
@endif
</div>
