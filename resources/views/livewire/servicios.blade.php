<div class="component">
    <div class="links">
        <a wire:click="view(1)" class="{{ $show == 1 ? 'active' : '' }}">Servicios</a>

        <a wire:click="view(2)" class="{{ $show == 2 ? 'active' : '' }}">Caja</a>
    </div>

    @if ($show == 1)
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
                                        <a style="text-decoration: none; color: #99BF51"
                                            href="{{ asset('users/' . $service->comprobante) }}"
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
                                        <label style="cursor: pointer"
                                            wire:change="setServiceIdAndSave({{ $service->id }})">Cargar
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

                    <img class="close" wire:click="close" src="{{ asset('images/cerrar.png') }}"
                        alt="Icono Cerrar">

                </div>
            @endif
        </div>
    @else
        <div class="conteFilter">
            <div class="conteInput">
                <label for="">Nombre del Estudiante</label>
                <input id="inputEstudent" type="text" wire:model.live="nameEstudiante" placeholder="Estudiante">
            </div>
            <div class="container">
                <div class="conteInput">
                    <label for="">Fecha Inicial</label>
                    <input style="width: 200px" type="date" wire:model.live="dateInicio">
                </div>
                <div class="conteInput">
                    <label for="">Fecha Final</label>
                    <input style="width: 200px" type="date" wire:model.live="dateFinal">
                </div>
            </div>
            <div class="typeService">
                <select wire:model.live="metodo" id="">
                    <option value="" selected>Metodo de pago</option>
                    @forelse ($metodoPagos as $metodo)
                        <option value="{{ $metodo->id }}">{{ $metodo->name }}</option>
                    @empty
                        <p></p>
                    @endforelse
                </select>

                <select wire:model.live="dinero" id="">
                    <option value="" selected>Dinero</option>
                    <option value="Ingresado">Ingreso</option>
                    <option value="Egresado">Egreso</option>
                </select>
                <div class="column">
                    <button wire:click="showPay">¡Crear nuevo!</button>
                    <button wire:click="donwload" wire:confirm='Confirma para descargar el informe de caja.'>Descargar</button>
                </div>
            </div>
        </div>

        <h2 class="titlesaldo">SALDO EN CAJA: ${{ number_format($saldoCaja, 0, ',', '.') }}</h2>

        <div class="containerConte">
            <div class="conteTable">
                <table class="teacher">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nombre</th>
                            <th>valor</th>
                            <th>Metodo</th>
                            <th>Ingreso/Egreso</th>
                            <th>Fecha</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @forelse ($pagos as $key => $pago)
                            <tr>
                                <td>{{ $key + 1 }}</td>

                                @php
                                    $name = $pago->apprentice
                                        ? $pago->apprentice->name . ' ' . $pago->apprentice->apellido
                                        : $pago->egresado;
                                @endphp
                                <td>{{ $name }}</td>
                                <td>${{ number_format($pago->monto, 0, ',', '.') }} </td>
                                @php
                                    $total += $pago->monto;
                                @endphp
                                <td>{{ $pago->metodo->name }} </td>
                                <td>{{ $pago->dinero }} </td>
                                <td>
                                    {{ $pago->created_at->format('Y-m-d') }}
                                </td>
                                <td>
                                    <div class="flex">
                                        <button wire:click="showPay({{ $pago->id }})"
                                            class="update">Actualizar</button>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex">
                                        <button class="delete" wire:click="deletePay({{ $pago->id }})"
                                            wire:confirm="¿Desea eliminar el servicio?">Eliminar</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="center" colspan="8">
                                    <p class="nodatos">No hay datos</p>
                                    <video class="video" src="/videos/video2.mp4" height="180vw" autoplay loop>
                                        <source src="/videos/video2.mp4" type="">
                                    </video>
                                </td>
                            </tr>
                        @endforelse
                        <tr class="total">
                            <td colspan="2">Total:</td>
                            <td>${{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if ($showU)
            <div class="conteCreateService">
                <h3>Crear Pago</h3>

                <div class="conteDivs">
                    <div class="conteInput">
                        <label for="">Crear o Buscar</label>
                        <input type="text" wire:model.live="search">
                    </div>
                    <div class="conteInput">
                        <label for="">Estudiantes:</label>
                        <select wire:model="idEstudentCreate" id="">
                            <option selected hidden value="">Seleccione</option>
                            @foreach ($estudents as $estudent)
                                <option value="{{ $estudent->id }}">{{ $estudent->name }} {{ $estudent->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="conteDivs">
                    <div class="conteInput">
                        <label for="">Monto:</label>
                        <input type="text" wire:model="montoCreate">
                    </div>
                    <div class="conteInput">
                        <label for="">Fecha:</label>
                        <input type="date" wire:model="dateCreate">
                    </div>
                </div>
                <div class="conteDivs">
                    <div class="conteInput">
                        <label for="">Metodo:</label>
                        <select wire:model="metodoCreate" id="">
                            <option value="null" selected hidden>Seleccione...</option>
                            @forelse ($metodoPagos as $metodo)
                                <option value="{{ $metodo->id }}">{{ $metodo->name }}</option>
                            @empty
                                <p></p>
                            @endforelse
                        </select>
                    </div>
                    <div class="conteInput">
                        <label for="">Dinero:</label>
                        <select wire:model="dineroCreate" id="">
                            <option value="null" selected hidden>Seleccione...</option>
                            <option value="Ingresado">Ingreso</option>
                            <option value="Egresado">Egreso</option>
                        </select>
                    </div>
                </div>
                @if ($pay_id)
                    <button wire:click="createPay({{ $pay_id }})">Actualizar Pago</button>
                @else
                    <button wire:click="createPay()">Crear Pago</button>
                @endif

                <img class="close" wire:click="close" src="{{ asset('images/cerrar.png') }}" alt="Icono Cerrar">
            </div>
        @endif
    @endif
</div>
