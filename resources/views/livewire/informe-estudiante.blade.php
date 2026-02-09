<div class="componente">
    <div class="links">
        <a wire:click="activar(1)" class="activea{{ $active }}">Estudiantes</a>
        <a wire:click="activar(2)" class="activep{{ $active }}">Profesores</a>
        <a wire:click="activar(3)" class="active{{ $active }}">Copia de seguridad</a>
    </div>
    @if ($active == 1)
        <div class="modern-filters">
            <form>
                <div class="filter-group">
                    <label for="filtro">Estudiante</label>
                    <input type="text" id="filtro" wire:model.live="filtro" placeholder="Buscar por nombre...">
                </div>

                <div class="filter-group">
                    <label>Sede</label>
                    <select wire:model.live="sede_id">
                        <option value="" selected>Todas las Sedes</option>
                        <option value="1">Fonseca</option>
                        <option value="2">San Juan</option>
                        <option value="3">Online</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Mes</label>
                    <select wire:model.live="mes">
                        <option value="00" selected>Seleccionar mes</option>
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

                <div class="filter-group">
                    <label>Año</label>
                    <div class="year-selector">
                        <span class="material-symbols-outlined" wire:click="previous">skip_previous</span>
                        <p>{{ $year }}</p>
                        <span class="material-symbols-outlined" wire:click="next">skip_next</span>
                    </div>
                </div>

                <div class="filter-group">
                    <label>Estado</label>
                    <select wire:model.live="estado">
                        <option value="0" selected>Todos los estados</option>
                        <option value="1">Pagado</option>
                        <option value="2">Pendiente</option>
                    </select>
                </div>

                <div class="btn-group" style="display: flex; gap: 10px; margin-left: auto;">
                    <button type="button" class="btn-action btn-new-module"
                        wire:confirm="¿Estás seguro? Se archivará el módulo actual." wire:click="saveInforme">
                        <span class="material-symbols-outlined">archive</span>
                        Nuevo Módulo
                    </button>

                    <a href="{{ route('descargar', $mes) }}" class="btn-action btn-download">
                        <span class="material-symbols-outlined">download</span>
                        Descargar
                    </a>
                </div>
            </form>
        </div>

        <div class="modern-table-container">
            <table class="tableInforme">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Acudiente / Estudiante</th>
                        <th>Becado</th>
                        <th>Valor Módulo</th>
                        <th>Descuento</th>
                        <th>Abonado</th>
                        <th>Pendiente</th>
                        <th>Plataforma</th>
                        <th>Acción</th>
                        <th>Fecha</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                        $plataformaTotal = 0;
                        $fechaPlataforma = Date::now()->year;
                    @endphp
                    @forelse ($informes ?? [] as $informe)
                        @php
                            $abonoColor = '#2d3748';
                            if ($informe->total_abonos <= 300000) {
                                $abonoColor = '#e74c3c';
                            } elseif ($informe->total_abonos < 800000) {
                                $abonoColor = '#f39c12';
                            } else {
                                $abonoColor = '#27ae60';
                            }

                            $isBecado = $informe->apprentice->becado_id == 1;
                            $valorModulo =
                                $informe->apprentice->modality_id != 4
                                    ? $informe->apprentice->modality->valor
                                    : $informe->apprentice->valor;
                            $pendiente = $isBecado
                                ? 0
                                : $valorModulo - $informe->total_abonos - $informe->apprentice->descuento;

                            if (!$isBecado && $informe->apprentice->fechaPlataforma == $fechaPlataforma) {
                                $plataformaTotal += $informe->apprentice->plataforma ?? 0;
                            }
                        @endphp

                        <tr class="{{ $pendiente <= 0 ? 'active' : '' }}">
                            <td>{{ $count++ }}</td>
                            <td>
                                <div style="display: flex; flex-direction: column;">
                                    <small
                                        style="color: #718096; font-size: 0.75rem;">{{ $informe->apprentice->attendant->name }}</small>
                                    <a href="{{ route('estadoCuenta', $informe->apprentice->id) }}">
                                        {{ $informe->apprentice->name }} {{ $informe->apprentice->apellido }}
                                    </a>
                                </div>
                            </td>
                            <td>
                                <span class="badge-entity">{{ $informe->apprentice->becado->name ?? 'N/A' }}</span>
                            </td>
                            <td>${{ number_format($isBecado ? 0 : $valorModulo, 0, ',', '.') }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    ${{ number_format($isBecado ? 0 : $informe->apprentice->descuento, 0, ',', '.') }}
                                    @if (!$isBecado)
                                        <span wire:click="descuento({{ $informe->apprentice->id }})"
                                            class="material-symbols-outlined"
                                            style="font-size: 16px; cursor: pointer; color: #a0aec0;">edit</span>
                                    @endif
                                </div>
                            </td>
                            <td style="color: {{ $abonoColor }}; font-weight: 700;">
                                ${{ number_format($isBecado ? 0 : $informe->total_abonos, 0, ',', '.') }}
                            </td>
                            <td style="font-weight: 700;">${{ number_format($pendiente, 0, ',', '.') }}</td>
                            <td>
                                @if ($informe->apprentice->plataforma == null || $informe->apprentice->plataforma == 0)
                                    <button wire:confirm="¿Deseas abonar la plataforma?" class="update-badge"
                                        wire:click="plataforma({{ $informe->apprentice->id }})">
                                        <span class="material-symbols-outlined">add_card</span> $140mil
                                    </button>
                                @else
                                    <div style="display: flex; align-items: center; gap: 5px; color: #27ae60;">
                                        <span class="material-symbols-outlined"
                                            style="font-size: 18px;">check_circle</span>
                                        Ok
                                        <span wire:click="activePlataforma({{ $informe->apprentice->id }})"
                                            class="material-symbols-outlined"
                                            style="font-size: 16px; cursor: pointer; color: #a0aec0;">edit</span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if ($pendiente > 0)
                                    <button class="update-badge" wire:click="abonar({{ $informe->apprentice->id }})">
                                        <span class="material-symbols-outlined">payments</span> Abonar
                                    </button>
                                @else
                                    <span style="color: #27ae60; font-weight: 700;">Pagado</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 5px; font-size: 0.85rem;">
                                    {{ $informe->fecha ?? 'Sin fecha' }}
                                    <span wire:click="aumentar({{ $informe->id }})" class="material-symbols-outlined"
                                        style="font-size: 16px; cursor: pointer; color: #a0aec0;">edit</span>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    <textarea class="observaciones" wire:model.defer="observaciones.{{ $informe->apprentice->id }}" rows="1"></textarea>
                                    <img wire:click="saveObservacion({{ $informe->apprentice->id }})" class="save-icon"
                                        src="{{ asset('images/save.png') }}" alt="Guardar">
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" style="text-align: center; padding: 50px;">
                                <span class="material-symbols-outlined"
                                    style="font-size: 48px; color: #cbd5e0;">search_off</span>
                                <p style="margin-top: 10px; color: #718096;">No se encontraron resultados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="total-row">
                    <tr>
                        <td colspan="3">TOTALES DEL PERÍODO</td>
                        <td>${{ number_format($totalModulos - $totalDescuento, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalDescuento, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalAbono, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalPendiente, 0, ',', '.') }}</td>
                        <td>${{ number_format($plataformaTotal, 0, ',', '.') }}</td>
                        <td colspan="3" style="text-align: right; color: #05ccd1; font-size: 1.1rem;">
                            Neto: ${{ number_format($plataformaTotal + $totalModulos - $totalDescuento, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Modales --}}
        @if ($viewDescuento == 1)
            <div class="modern-modal-overlay">
                <div class="modern-modal">
                    <span wire:click="ocultar" class="material-symbols-outlined close-btn">close</span>
                    <div class="modal-header">
                        <h2>Registrar Descuento</h2>
                        <p>Aplicar una rebaja al valor del módulo</p>
                    </div>
                    <form wire:submit="saveDescuento({{ $aprendizArray->id }})">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Estudiante</label>
                                <input wire:model="nameF" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label>Monto del Descuento</label>
                                <input wire:model="descuent" type="number" placeholder="Ej: 50000" autofocus>
                                @if (isset($message) && $message)
                                    <small style="color: #e74c3c;">{{ $message }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit">Aplicar Descuento</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if ($vista == 1)
            <div class="modern-modal-overlay">
                <div class="modern-modal">
                    <span wire:click="ocultar" class="material-symbols-outlined close-btn">close</span>
                    <div class="modal-header">
                        <h2>Actualizar Fecha</h2>
                        <p>Modificar la fecha de registro del abono</p>
                    </div>
                    <form wire:submit="guardar({{ $idEstudiante }})">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Estudiante</label>
                                <input wire:model="nameF" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nueva Fecha</label>
                                <input wire:model="fecha" type="date">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit">Actualizar Fecha</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if ($viewplataforma == 1)
            <div class="modern-modal-overlay">
                <div class="modern-modal">
                    <span wire:click="ocultar" class="material-symbols-outlined close-btn">close</span>
                    <div class="modal-header">
                        <h2>Pago de Plataforma</h2>
                        <p>Actualizar el año de vigencia de la plataforma</p>
                    </div>
                    <form wire:submit="savePlataforma({{ $idEstudiante }})">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Estudiante</label>
                                <input wire:model="name" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label>Año de Vigencia</label>
                                <input wire:model="fechaPlataforma" type="number" placeholder="Ej: 2025">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if ($view != 0)
            <div class="modern-modal-overlay">
                <div class="modern-modal">
                    <span wire:click="ocultar" class="material-symbols-outlined close-btn">close</span>
                    <div class="modal-header">
                        <h2>Registrar Nuevo Abono</h2>
                        <p>Ingresar un nuevo pago realizado por el estudiante</p>
                    </div>
                    <form wire:submit.prevent>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Estudiante</label>
                                <input wire:model="name" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label>Monto a Abonar</label>
                                <input wire:model="abono" type="number" placeholder="Monto en pesos" autofocus>
                                @error('abono')
                                    <small style="color: #e74c3c;">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Método de Pago</label>
                                <select wire:model="metodo">
                                    <option value="" selected hidden>Seleccionar...</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Consignación">Consignación Bancaria</option>
                                </select>
                                @error('metodo')
                                    <small style="color: #e74c3c;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="save({{ $idEstudiante }})">Confirmar Abono</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @elseif($active == 2)
        @livewire('tinforme')
    @else
        <div class="modern-filters">
            <form>
                <div class="filter-group">
                    <label>Estudiante / Acudiente</label>
                    <input type="text" wire:model.live="nameApprentice" placeholder="Buscar en copia...">
                </div>

                <div class="filter-group">
                    <label>Mes</label>
                    <select wire:model.live="month">
                        <option value="00" selected>Seleccionar mes</option>
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

                <div class="filter-group">
                    <label>Año</label>
                    <div class="year-selector">
                        <span class="material-symbols-outlined" wire:click="previous">skip_previous</span>
                        <p>{{ $yearCopia }}</p>
                        <span class="material-symbols-outlined" wire:click="next">skip_next</span>
                    </div>
                </div>

                <div class="filter-group">
                    <label>Módulo</label>
                    <select wire:model.live="module">
                        <option value="" selected>Todos los módulos</option>
                        <option value="1">Módulo 1</option>
                        <option value="2">Módulo 2</option>
                    </select>
                </div>

                <div class="btn-group" style="display: flex; gap: 10px; margin-left: auto;">
                    <button type="button" class="btn-action btn-download" wire:click="donwload">
                        <span class="material-symbols-outlined">download</span>
                        Descargar Reporte
                    </button>
                </div>
            </form>
        </div>

        <div class="modern-table-container">
            <table class="tableInforme">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Acudiente / Estudiante</th>
                        <th>Becado</th>
                        <th>Valor Módulo</th>
                        <th>Descuento</th>
                        <th>Abonado</th>
                        <th>Pendiente</th>
                        <th>Plataforma</th>
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
                            $extension = pathinfo($informe->comprobante, PATHINFO_EXTENSION);
                        @endphp

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <div style="display: flex; flex-direction: column;">
                                    <small
                                        style="color: #718096; font-size: 0.75rem;">{{ $informe->acudiente }}</small>
                                    <span style="font-weight: 600;">{{ $informe->estudiante }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge-entity">{{ $informe->becado }}</span>
                            </td>
                            <td>${{ number_format($informe->valor, 0, ',', '.') }}</td>
                            <td>${{ number_format($informe->descuento, 0, ',', '.') }}</td>
                            <td style="font-weight: 700;">${{ number_format($informe->abono, 0, ',', '.') }}</td>
                            <td style="font-weight: 700;">${{ number_format($informe->pendiente, 0, ',', '.') }}</td>
                            <td>${{ number_format($informe->plataforma, 0, ',', '.') }}</td>
                            <td>
                                <div style="font-size: 0.85rem; color: #718096;">
                                    {{ $informe->fecha ?? 'Sin fecha' }}
                                </div>
                            </td>
                            <td>
                                @if ($extension)
                                    <a href="{{ asset('users/' . $informe->comprobante) }}"
                                        download="Comprobante-{{ $informe->estudiante }}" class="update-badge"
                                        style="text-decoration: none;">
                                        <span class="material-symbols-outlined">download_for_offline</span>
                                        PDF/IMG
                                    </a>
                                @else
                                    <span style="color: #cbd5e0; font-size: 0.8rem;">No disponible</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-size: 0.85rem; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                    title="{{ $informe->observacion }}">
                                    {{ $informe->observacion }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" style="text-align: center; padding: 50px;">
                                <span class="material-symbols-outlined"
                                    style="font-size: 48px; color: #cbd5e0;">archive</span>
                                <p style="margin-top: 10px; color: #718096;">No hay registros archivados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="total-row">
                    <tr>
                        <td colspan="3">TOTALES ARCHIVADOS</td>
                        <td>${{ number_format($totalModulos, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalDescuento, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalAbono, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalPendiente, 0, ',', '.') }}</td>
                        <td>${{ number_format($totalplataforma, 0, ',', '.') }}</td>
                        <td colspan="3" style="text-align: right; color: #05ccd1; font-size: 1.1rem;">
                            Neto: ${{ number_format($totalplataforma + $totalModulos, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</div>
