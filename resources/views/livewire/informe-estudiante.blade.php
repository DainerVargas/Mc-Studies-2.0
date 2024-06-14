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
            </form>
        </div>
        <div class="containerConte">
            <small class="message" style="color: red">{{ $message2 }}</small>
            <div class="conteTable">
                <table class="tableInforme">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Acudiente</th>
                            <th>Estudiante</th>
                            <th>Valor Modulo</th>
                            <th>Abono</th>
                            <th>Fecha</th>
                            <th>Pendiente</th>
                            <th>Plataforma de Pago</th>
                            <th>Abonar</th>
                            <th>Restablecer</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                            $total = 0;
                            $totalModulos = 0;

                            foreach ($aprendices as $valor) {
                                $totalModulos += $valor->modality->valor + 120000;
                            }
                        @endphp
                        @forelse ($informes ?? [] as $informe)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td class="relative">
                                    {{ $informe->apprentice->attendant->name }}
                                </td>
                                <td>{{ $informe->apprentice->name }}</td>
                                <td>${{ $informe->apprentice->modality->valor }}</td>
                                <td>${{ $informe->abono }}</td>
                                @php
                                    $fecha = isset($informe->fecha) ? $informe->fecha : 'Sin fecha';
                                @endphp
                                <td>{{ $fecha }}</td>
                                @php
                                    $totalAbonos = $informes
                                        ->where('apprentice_id', $informe->apprentice->id)
                                        ->sum('abono');
                                    $pendiente = $informe->apprentice->modality->valor - $totalAbonos;
                                @endphp
                                <td>${{ $pendiente + 120000 }} </td>
                                <td>$120000</td>
                                <td style="color: green">
                                    @if ($pendiente != -120000)
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
                                <td>
                                    <div class="flex">
                                        <button class="delete" wire:click="reseter({{ $informe->id }})"
                                            wire:confirm="¿Estás seguro de restablecer los datos?
            Si aceptas los datos se perderan."><span
                                                class="material-symbols-outlined">
                                                restart_alt
                                            </span> Restore</button>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex">
                                        <button class="delete" wire:click="eliminar({{ $informe->id }})"
                                            wire:confirm="¿Estás seguro de eliminar?
            Si aceptas los datos se perderan."><span
                                                class="material-symbols-outlined">
                                                delete
                                            </span> Eliminar</button>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $total += $informe->abono;
                            @endphp
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
                        <td>${{ $totalModulos }}</td>
                        <td>${{ $total }}</td>
                    </tbody>
                </table>

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
