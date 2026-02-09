<div class="component">
    <div class="links">
        <a wire:click="view(1)" class="{{ $show == 1 ? 'active' : '' }}">Servicios</a>
        <a wire:click="view(2)" class="{{ $show == 2 ? 'active' : '' }}">Caja</a>
    </div>

    @if ($show == 1)
        <div class="modern-filters">
            <div class="filter-header">
                <div class="filter-title">
                    <span class="material-symbols-outlined">filter_list</span>
                    Gestión de Servicios
                </div>
                <div class="header-actions">
                    <button class="filter-btn outline" wire:click="showCategory">
                        <span class="material-symbols-outlined">category</span> Categoría
                    </button>
                    <button class="filter-btn dark" wire:click="showService">
                        <span class="material-symbols-outlined">add_circle</span> Nuevo Servicio
                    </button>
                </div>
            </div>

            <div class="filter-group">
                <label>Buscador</label>
                <input type="text" wire:model.live="nameService" placeholder="Buscar por nombre o fecha...">
            </div>

            <div class="filter-group small">
                <label>Año</label>
                <div class="year-selector">
                    <span class="material-symbols-outlined" wire:click="previous">keyboard_arrow_left</span>
                    <p>{{ $year }}</p>
                    <span class="material-symbols-outlined" wire:click="next">keyboard_arrow_right</span>
                </div>
            </div>

            <div class="filter-group medium">
                <label>Mes de referencia</label>
                <input type="date" wire:model.live="date">
            </div>

            <div class="filter-group">
                <label>Filtrar por categoría</label>
                <select wire:model.live="type">
                    <option value="null">Todas las especialidades</option>
                    @foreach ($typeService as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="modern-table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Servicio</th>
                        <th>Valor</th>
                        <th>Fecha</th>
                        <th>Categoría</th>
                        <th>Comprobante</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $suma = 0; @endphp
                    @forelse ($services as $key => $service)
                        @php $suma += $service->valor; @endphp
                        <tr>
                            <td style="font-weight: 600; color: #718096;">#{{ $key + 1 }}</td>
                            <td><span style="font-weight: 700;">{{ $service->name }}</span></td>
                            <td style="font-weight: 700; color: #05ccd1;">
                                ${{ number_format($service->valor, 0, ',', '.') }}</td>
                            <td><span style="color: #718096; font-size: 0.85rem;">{{ $service->fecha }}</span></td>
                            <td><span class="badge-category">{{ $service->typeService->name }}</span></td>
                            <td>
                                @php $extension = pathinfo($service->comprobante, PATHINFO_EXTENSION); @endphp
                                @if ($extension)
                                    <a href="{{ asset('users/' . $service->comprobante) }}"
                                        download="Comprobante-{{ $service->name }}" class="btn-update"
                                        style="text-decoration: none;">
                                        <span class="material-symbols-outlined">download</span>Descargar
                                    </a>
                                @else
                                    <label class="btn-update" style="cursor: pointer;"
                                        wire:change="setServiceIdAndSave({{ $service->id }})">
                                        <span class="material-symbols-outlined">upload</span>Cargar
                                        <input type="file" wire:model="comprobante" hidden>
                                    </label>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <button wire:click="showUpdate({{ $service->id }})" class="btn-update">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                    <button wire:click="delete({{ $service->id }})"
                                        wire:confirm="¿Desea eliminar el servicio?" class="btn-delete">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 50px;">
                                <span class="material-symbols-outlined"
                                    style="font-size: 48px; color: #cbd5e0;">inventory_2</span>
                                <p style="margin-top: 10px; color: #718096;">No hay servicios registrados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="total">
                        <td colspan="2">TOTAL SERVICIOS</td>
                        <td colspan="5" style="color: #05ccd1; font-size: 1.2rem;">
                            ${{ number_format($suma, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if ($showS || $showC || $showU)
            <div class="conteCreate">
                @if ($showS || $showU)
                    <div class="conteCreateService">
                        <div class="modal-header">
                            <h3>{{ $showU ? 'Actualizar Servicio' : 'Nuevo Servicio' }}</h3>
                            <p>{{ $showU ? 'Modifique los detalles del servicio seleccionado' : 'Registre un nuevo gasto o servicio en el sistema' }}
                            </p>
                            <button class="close-modal" wire:click="close">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="conteDivs">
                                <div class="Input">
                                    <label>Nombre del Servicio</label>
                                    <input type="text" wire:model="name" placeholder="Ej: Pago de luz">
                                </div>
                                <div class="Input">
                                    <label>Valor</label>
                                    <input type="text" wire:model="valor" placeholder="0.00">
                                </div>
                            </div>
                            <div class="conteDivs">
                                <div class="Input">
                                    <label>Fecha</label>
                                    <input type="date" wire:model="fecha">
                                </div>
                                <div class="Input">
                                    <label>Categoría</label>
                                    <select wire:model="type_service_id">
                                        <option value="null">Seleccione...</option>
                                        @foreach ($typeService as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-cancel" wire:click="close">Cancelar</button>
                            @if ($showU)
                                <button class="btn-save" wire:click="updateService({{ $service_id }})">
                                    <span class="material-symbols-outlined">save</span> Guardar Cambios
                                </button>
                            @else
                                <button class="btn-save" wire:click="saveService">
                                    <span class="material-symbols-outlined">add_circle</span> Registrar Servicio
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

                @if ($showC)
                    <div class="conteCreateCategory">
                        <div class="modal-header">
                            <h3>Nueva Categoría</h3>
                            <p>Organice sus servicios mediante categorías personalizadas</p>
                            <button class="close-modal" wire:click="close">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="conteDivs">
                                <div class="Input">
                                    <label>Nombre de Categoría</label>
                                    <input type="text" wire:model="name" placeholder="Ej: Mantenimiento">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-cancel" wire:click="close">Cancelar</button>
                            <button class="btn-save" wire:click="saveCategory">
                                <span class="material-symbols-outlined">check_circle</span> Crear Categoría
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    @else
        <div class="modern-filters">
            <div class="filter-header">
                <div class="filter-title">
                    <span class="material-symbols-outlined">account_balance</span>
                    Control de Caja
                </div>
                <div class="header-actions">
                    <button class="filter-btn dark" wire:click="showPay">
                        <span class="material-symbols-outlined">add_box</span> Nuevo Movimiento
                    </button>
                    <button class="filter-btn outline" wire:click="donwload"
                        wire:confirm="¿Descargar informe de caja?">
                        <span class="material-symbols-outlined">download</span> Reporte PDF
                    </button>
                </div>
            </div>

            <div class="filter-group">
                <label>Búsqueda rápida</label>
                <input type="text" wire:model.live="nameEstudiante" placeholder="Estudiante o concepto...">
            </div>

            <div class="filter-group medium">
                <label>Fecha inicial</label>
                <input type="date" wire:model.live="dateInicio">
            </div>

            <div class="filter-group medium">
                <label>Fecha final</label>
                <input type="date" wire:model.live="dateFinal">
            </div>

            <div class="filter-group small">
                <label>Año</label>
                <div class="year-selector">
                    <span class="material-symbols-outlined" wire:click="previouspay">keyboard_arrow_left</span>
                    <p>{{ $year2 }}</p>
                    <span class="material-symbols-outlined" wire:click="nextpay">keyboard_arrow_right</span>
                </div>
            </div>

            <div class="filter-group small">
                <label>Método</label>
                <select wire:model.live="metodo">
                    <option value="">Todos</option>
                    @foreach ($metodoPagos as $metodoItem)
                        <option value="{{ $metodoItem->id }}">{{ $metodoItem->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group small">
                <label>Tipo</label>
                <select wire:model.live="dinero">
                    <option value="">Ambos</option>
                    <option value="Ingresado">Ingresos</option>
                    <option value="Egresado">Egresos</option>
                </select>
            </div>
        </div>

        <h2 class="titlesaldo">BALANCE ACTUAL: ${{ number_format($saldoCaja, 0, ',', '.') }}</h2>

        <div class="modern-table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Concepto / Estudiante</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @forelse ($pagos as $key => $pago)
                        @php
                            $total += $pago->monto;
                            $name = $pago->apprentice
                                ? $pago->apprentice->name . ' ' . $pago->apprentice->apellido
                                : $pago->egresado;
                        @endphp
                        <tr>
                            <td style="font-weight: 600; color: #718096;">#{{ $key + 1 }}</td>
                            <td><span style="font-weight: 700;">{{ $name }}</span></td>
                            <td
                                style="font-weight: 700; color: {{ $pago->dinero == 'Ingresado' ? '#27ae60' : '#e74c3c' }};">
                                ${{ number_format($pago->monto, 0, ',', '.') }}
                            </td>
                            <td><span class="badge-category">{{ $pago->metodo->name }}</span></td>
                            <td>
                                <span class="badge-{{ $pago->dinero == 'Ingresado' ? 'income' : 'expense' }}">
                                    {{ $pago->dinero == 'Ingresado' ? 'INGRESO' : 'EGRESO' }}
                                </span>
                            </td>
                            <td>{{ $pago->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <button wire:click="showPay({{ $pago->id }})" class="btn-update">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                    <button wire:click="deletePay({{ $pago->id }})"
                                        wire:confirm="¿Eliminar este registro?" class="btn-delete">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 50px;">
                                <span class="material-symbols-outlined"
                                    style="font-size: 48px; color: #cbd5e0;">point_of_sale</span>
                                <p style="margin-top: 10px; color: #718096;">No hay movimientos</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="total">
                        <td colspan="2">TOTAL CONSULTADO</td>
                        <td colspan="5" style="color: #2d3436; font-size: 1.2rem;">
                            ${{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if ($showU)
            <div class="conteCreate">
                <div class="conteCreateService">
                    <div class="modal-header">
                        <h3>{{ $pay_id ? 'Actualizar Movimiento' : 'Nuevo Movimiento' }}</h3>
                        <p>{{ $pay_id ? 'Gestione los detalles del registro contable' : 'Registre un nuevo ingreso o egreso en la caja' }}
                        </p>
                        <button class="close-modal" wire:click="close">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="conteDivs">
                            <div class="Input">
                                <label>Concepto / Egreso</label>
                                <input type="text" wire:model.live="search" placeholder="Especifique concepto...">
                            </div>
                            <div class="Input">
                                <label>O Estudiante</label>
                                <select wire:model="idEstudentCreate">
                                    <option value="">Seleccione...</option>
                                    @foreach ($estudents as $estudent)
                                        <option value="{{ $estudent->id }}">{{ $estudent->name }}
                                            {{ $estudent->apellido }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="conteDivs">
                            <div class="Input">
                                <label>Monto</label>
                                <input type="text" wire:model="montoCreate" placeholder="0.00">
                            </div>
                            <div class="Input">
                                <label>Fecha</label>
                                <input type="date" wire:model="dateCreate">
                            </div>
                        </div>
                        <div class="conteDivs">
                            <div class="Input">
                                <label>Método</label>
                                <select wire:model="metodoCreate">
                                    <option value="null">Seleccione...</option>
                                    @foreach ($metodoPagos as $metodoItem)
                                        <option value="{{ $metodoItem->id }}">{{ $metodoItem->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="Input">
                                <label>Tipo</label>
                                <select wire:model="dineroCreate">
                                    <option value="null">Seleccione...</option>
                                    <option value="Ingresado">Ingreso</option>
                                    <option value="Egresado">Egreso</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn-cancel" wire:click="close">Cancelar</button>
                        <button class="btn-save" wire:click="createPay({{ $pay_id }})">
                            <span class="material-symbols-outlined">{{ $pay_id ? 'save' : 'add_box' }}</span>
                            {{ $pay_id ? 'Actualizar' : 'Registrar' }}
                        </button>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
