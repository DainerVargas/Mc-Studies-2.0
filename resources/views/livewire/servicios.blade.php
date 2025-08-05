<div class="component">
    <div class="conteFilter">
        <div class="create">
            <button wire:click="showService">Crear servicio</button>
        </div>
        <div class="conteInput">
            <label for="">Buscar servicio</label>
            <input type="text" wire:model.live="nameService" placeholder="Buscar servicios">
        </div>
        <div class="conteInput">
            <label for="">Fecha</label>
            <input style="width: 200px" type="date" wire:model.live="date">
        </div>
        <div class="typeService">
            <select wire:model.live="type" id="">
                <option value="null" selected>Seleccione...</option>
                @forelse ($typeService as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @empty
                    <p>Sin categoria</p>
                @endforelse
            </select>

            <button wire:click="showCategory">Crear categoria</button>
        </div>
    </div>

    {{--  <div class="conteFilter">
        <div class="typeService rigth">
            <button>Descargar</button>
        </div>
    </div> --}}

    <div class="containerConte">
        <div class="conteTable">
            <table class="teacher">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Servicios</th>
                        <th>valor</th>
                        <th>fecha</th>
                        <th>Categoria</th>
                        <th>Comprobante</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $suma = 0;
                    @endphp
                    @forelse ($services as $key => $service)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $service->name }} </td>
                            <td>${{ number_format($service->valor, 0, ',', '.') }} </td>
                            @php
                                $suma += $service->valor;
                            @endphp
                            <td>{{ $service->fecha }} </td>
                            <td>{{ $service->typeService->name }} </td>
                            @php
                                $extension = pathinfo($service->comprobante, PATHINFO_EXTENSION);
                            @endphp
                            <td>
                                @if ($extension)
                                    <a style="text-decoration: none; color: #99BF51" href="{{ asset('users/' . $service->comprobante) }}"
                                        download="Comprobante de servicio-{{ $service->name }}">
                                        <div class="flex">
                                            <label style="cursor: pointer;">Descargar
                                                <span class="material-symbols-outlined">
                                                    play_for_work
                                                </span>
                                            </label>
                                        </div>
                                    </a>
                                @else
                                    <label style="cursor: pointer" wire:change="setServiceIdAndSave({{ $service->id }})">Cargar
                                        <span class="material-symbols-outlined">
                                            upload_file
                                        </span>
                                        <input type="file" wire:model="comprobante" hidden>
                                    </label>
                                @endif
                            </td>
                            <td>
                                <div class="flex">
                                    <button wire:click="showUpdate({{ $service->id }})"
                                        class="update">Actualizar</button>
                                </div>
                            </td>
                            <td>
                                <div class="flex">
                                    <button class="delete" wire:click="delete({{ $service->id }})"
                                        wire:confirm="¿Desea eliminar el servicio?">Eliminar</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="center" colspan="7">
                                <p class="nodatos">No hay datos</p>
                                <video class="video" src="/videos/video2.mp4" height="180vw" autoplay loop>
                                    <source src="/videos/video2.mp4" type="">
                                </video>
                            </td>
                        </tr>
                    @endforelse
                    <tr class="total">
                        <td colspan="2">Total:</td>
                        <td>${{ number_format($suma, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="conteCreate">

        @if ($showS)
            <div class="conteCreateService">
                <h3>Crear Servicio</h3>

                <div class="conteDivs">
                    <div class="conteInput">
                        <label for="">Servicio</label>
                        <input type="text" wire:model="name">
                    </div>
                    <div class="conteInput">
                        <label for="">Valor:</label>
                        <input type="text" wire:model="valor">
                    </div>
                </div>
                <div class="conteDivs">
                    <div class="conteInput">
                        <label for="">Fecha:</label>
                        <input type="date" wire:model="fecha">
                    </div>
                    <div class="conteInput">
                        <label for="">Categoria:</label>
                        <select wire:model="type_service_id" id="">
                            <option value="null" selected hidden>Seleccione...</option>
                            @forelse ($typeService as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @empty
                                <p>Sin categoria</p>
                            @endforelse
                        </select>
                    </div>
                </div>

                <button wire:click="saveService">Crear servicio</button>

                <img class="close" wire:click="close" src="{{ asset('images/cerrar.png') }}" alt="Icono Cerrar">

            </div>
        @endif

        @if ($showC)
            <div class="conteCreateCategory">
                <h3>Crear Categoria</h3>
                <div class="conteDivs">
                    <div class="conteInput">
                        <label for="">Categoria</label>
                        <input type="text" wire:model="name">
                    </div>
                </div>

                <button wire:click="saveCategory">Crear servicio</button>

                <img class="close" wire:click="close" src="{{ asset('images/cerrar.png') }}" alt="Icono Cerrar">
            </div>
        @endif

        @if ($showU)
            <div class="conteCreateService">
                <h3>Crear Servicio</h3>

                <div class="conteDivs">
                    <div class="conteInput">
                        <label for="">Servicio</label>
                        <input type="text" wire:model="name">
                    </div>
                    <div class="conteInput">
                        <label for="">Valor:</label>
                        <input type="text" wire:model="valor">
                    </div>
                </div>
                <div class="conteDivs">
                    <div class="conteInput">
                        <label for="">Fecha:</label>
                        <input type="date" wire:model="fecha">
                    </div>
                    <div class="conteInput">
                        <label for="">Categoria:</label>
                        <select wire:model="type_service_id" id="">
                            <option value="null" selected hidden>Seleccione...</option>
                            @forelse ($typeService as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @empty
                                <p>Sin categoria</p>
                            @endforelse
                        </select>
                    </div>
                </div>

                <button wire:click="updateService({{ $service_id }})">Actualizar servicio</button>

                <img class="close" wire:click="close" src="{{ asset('images/cerrar.png') }}" alt="Icono Cerrar">

            </div>
        @endif
    </div>
</div>
