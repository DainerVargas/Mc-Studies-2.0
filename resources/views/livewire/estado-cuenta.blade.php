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
                    <th class="fixed" colspan="10">Modalidad - {{ $aprendiz->modality->name }}</th>
                </tr>
                <tr>
                    <th class="fixed">Precio Modulo</th>
                    <th class="fixed">Descuento</th>
                    <th class="fixed">Abono</th>
                    <th class="fixed">Pendiente</th>
                    <th class="fixed">Plataforma</th>
                    <th class="fixed">Metodo</th>
                    <th class="fixed">Fecha</th>
                    <th class="fixed">Subir/Ver</th>
                    @if ($user->rol_id == 1)
                        <th class="fixed">Restablecer</th>
                        <th class="fixed">Eliminar</th>
                    @endif
                </tr>
                @forelse ($informes as $informe)
                    <tr>
                        <td>${{ number_format($informe->apprentice->modality->valor, 0, ',', '.') }}</td>
                        <td>${{ number_format($informe->apprentice->descuento, 0, ',', '.') }}</td>
                        <td>${{ number_format($informe->abono, 0, ',', '.') }}</td>
                        @php
                            $precio = $informe->apprentice->modality->valor;
                            $descuento = $informe->apprentice->descuento;
                            $totalAbono += $informe->abono;
                        @endphp
                        <td>${{ number_format($precio - $descuento - $totalAbono, 0, ',', '.') }}</td>
                        <td>${{ number_format($informe->apprentice->plataforma, 0, ',', '.') }}</td>
                        <td>{{ $informe->metodo ?? 'N/A' }}</td>
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
                            @php
                                $extension = pathinfo($informe->urlImage, PATHINFO_EXTENSION);
                            @endphp
                            <td>
                                @if ($extension != 'pdf')
                                    <div wire:click="show({{ $informe->id }})" class="flex">
                                        <label>Mostrar</label>
                                        <img src="{{ asset('images/mostrar.png') }}" alt="">
                                    </div>
                                @else
                                    <a href="{{ asset('users/' . $informe->urlImage) }}"
                                        download="Comprobante de pago-{{ $informe->apprentice->name }}">
                                        <div class="flex">
                                            <label>Descargar</label>
                                            <img src="{{ asset('images/descargar.png') }}" alt="">
                                        </div>
                                    </a>
                                @endif
                            </td>
                        @endif
                        @if ($user->rol_id == 1)
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
                        @endif
                    </tr>
                @empty
                    <td>No hay datos que mostrar</td>
                @endforelse
                <tr>
                    <td>${{ number_format($precio, 0, ',', '.') }}</td>
                    <td>${{ number_format($descuento, 0, ',', '.') }}</td>
                    <td>${{ number_format($totalAbono, 0, ',', '.') }}</td>
                    <td>${{ number_format($precio - $descuento - $totalAbono, 0, ',', '.') }}</td>
                    @if ($count != 0)
                        <td>${{ number_format($aprendiz->plataforma, 0, ',', '.') }}</td>
                    @else
                        <td>El estudiante ya pagó la plataforma</td>
                    @endif
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
