<div>
    <div class="conteFiltro">
        <form wire:submit="filtrar">
            <div class="conteInput">
                <label for="filtro">Filtra por el nombre del Profesor</label>
                <input type="text" wire:model.live="filtro" placeholder="Nombre del Profesor">
            </div>
            <div class="contelink">
                <a href="{{ route('informedescarga') }}"> Descargar Informe
                    <span class="material-symbols-outlined">
                        download
                    </span>
                </a>
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
                        <th>Profesor</th>
                        <th>Valor Pagado</th>
                        <th>Fecha de Pago</th>
                        <th>Restablecer</th>
                        <th>Eliminar</th>
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

                    <td colspan="2">Total: </td>
                    <td>${{ $total }}</td>
                </tbody>
            </table>

        </div>
    </div>
</div>
