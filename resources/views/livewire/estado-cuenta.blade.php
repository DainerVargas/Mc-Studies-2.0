<div class="containerEstado">

    <div class="title">
        <h1>Estado de la cuenta</h1>
        <p>{{ $aprendiz->name . ' ' . $aprendiz->apellido }}</p>
    </div>

    <div class="containerButton">
        <a href="{{ route('descargarInforme', $aprendiz) }}">
            <button>Descargar Informe <img src="{{ asset('images/descargar2.png') }}" alt=""></button>
        </a>
    </div>

    <small class="message" style="color: red">{{ $message2 }}</small>
    <div class="containerConte">
        <div class="conteTable">

            @php
                $precio = 0;
                $descuento = 0;
                $totalAbono = 0;
            @endphp
            <table>
                <tr>
                    <th class="fixed" colspan="9">Modalidad - {{ $aprendiz->modality->name }}</th>
                </tr>
                <tr>
                    <th class="fixed">Precio Modulo</th>
                    <th class="fixed">Descuento</th>
                    <th class="fixed">Abono</th>
                    <th class="fixed">Pendiente</th>
                    <th class="fixed">Plataforma</th>
                    <th class="fixed">Fecha</th>
                    <th class="fixed">Subir/Ver</th>
                    <th class="fixed">Restablecer</th>
                    <th class="fixed">Eliminar</th>
                </tr>
                @forelse ($informes as $informe)
                    <tr>
                        <td>${{ number_format($informe->apprentice->valor, 0, ',', '.') }}</td>
                        <td>${{ number_format($informe->apprentice->descuento, 0, ',', '.') }}</td>
                        <td>${{ number_format($informe->abono, 0, ',', '.') }}</td>
                        @php
                            $precio = $informe->apprentice->valor;
                            $descuento = $informe->apprentice->descuento;
                            $totalAbono += $informe->abono;
                        @endphp
                        <td>${{ number_format($precio - $descuento - $totalAbono, 0, ',', '.') }}</td>
                        <td>${{ number_format($informe->apprentice->plataforma, 0, ',', '.') }}</td>
                        <td>{{ $informe->fecha ?? 'Sin fecha' }}</td>

                        @if ($informe->urlImage == null)
                            <td>
                                <div wire:click="setInformeId({{ $informe->id }})" class="flex">

                                    <label wire:loading.remove for="cargar_{{ $informe->id }}">
                                        Cargar
                                        <img class="img" src="{{ asset('images/cargar.png') }}" alt="">
                                    </label>
                                    <input type="file" wire:model="comprobante" hidden
                                        id="cargar_{{ $informe->id }}">
                                </div>
                            </td>
                        @else
                            <td>
                                <div wire:click="show({{ $informe->id }})" class="flex">
                                    <label> Mostrar</label>
                                    <img src="{{ asset('images/mostrar.png') }}" alt="">
                                </div>
                            </td>
                        @endif
                        <td>
                            <div class="flex">
                                <button class="delete"
                                    wire:click="reseter({{ $informe->id }} , {{ $informe->apprentice_id }})"
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
                    <td>No hay na'</td>
                @endforelse
                <tr>
                    <td>${{ number_format($precio, 0, ',', '.') }}</td>
                    <td>${{ number_format($descuento, 0, ',', '.') }}</td>
                    <td>${{ number_format($totalAbono, 0, ',', '.') }}</td>
                    <td>${{ number_format($precio - $descuento - $totalAbono, 0, ',', '.') }}</td>
                    <td>${{ number_format($aprendiz->plataforma, 0, ',', '.') }}</td>
                </tr>
            </table>
            <div class="loader" wire:loading="updatedComprobante">
                <div class="justify-content-center jimu-primary-loading"></div>
            </div>
        </div>
        @if ($viewComprobante == 1)
            <div class="containerComprobante">
                <img class="comprobante" src="{{ asset('users/' . $urlImage) }}" alt="">
                <img class="close" wire:click="close" src="{{ asset('images/cerrar.png') }}" alt="">
            </div>
        @endif
    </div>
</div>
