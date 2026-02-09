<div class="teacher-report-section">
    <div class="modern-filters">
        <form wire:submit="filtrar">
            <div class="filter-group">
                <label for="filtro">Buscar Profesor</label>
                <input type="text" id="filtro" wire:model.live="filtro" placeholder="Nombre del docente...">
            </div>

            <div class="filter-group">
                <label>Año de Referencia</label>
                <div class="year-selector">
                    <span class="material-symbols-outlined" wire:click="previous">skip_previous</span>
                    <p>{{ $year }}</p>
                    <span class="material-symbols-outlined" wire:click="next">skip_next</span>
                </div>
            </div>

            <div class="btn-group" style="display: flex; gap: 10px; margin-left: auto;">
                <a href="{{ route('informedescarga', $year) }}" class="btn-action btn-download">
                    <span class="material-symbols-outlined">download</span>
                    Descargar Nómina
                </a>
            </div>
        </form>
    </div>

    @if ($message2)
        <div
            style="background: rgba(231, 76, 60, 0.1); color: #e74c3c; padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; font-weight: 600; font-size: 0.9rem; border: 1px solid rgba(231, 76, 60, 0.2);">
            {{ $message2 }}
        </div>
    @endif

    <div class="modern-table-container">
        <table class="tableInforme">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Docente</th>
                    <th>Valor Pagado</th>
                    <th>Fecha de Pago</th>
                    <th>Período</th>
                    <th style="text-align: center;">Acciones</th>
                    <th style="text-align: center;">Sel.</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $count = 1;
                    $total = 0;
                @endphp
                @forelse ($informes as $informe)
                    @php
                        $total += $informe->abono;
                        $fecha = $informe->fecha ?? 'Sin fecha';
                    @endphp
                    <tr>
                        <td style="font-weight: 600; color: #718096;">#{{ $count++ }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div
                                    style="width: 32px; height: 32px; background: #edf2f7; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <span class="material-symbols-outlined"
                                        style="font-size: 18px; color: #4a5568;">school</span>
                                </div>
                                <span style="font-weight: 700; color: #2d3748;">{{ $informe->teacher->name }}</span>
                            </div>
                        </td>
                        <td style="font-weight: 700; color: #27ae60;">
                            ${{ number_format($informe->abono, 0, ',', '.') }}
                        </td>
                        <td>
                            <span style="font-size: 0.85rem; color: #718096;">{{ $fecha }}</span>
                        </td>
                        <td>
                            <span class="badge-entity"
                                style="background: #fff5f5; color: #c53030; border-color: #feb2b2;">
                                {{ $informe->periodo ?? 'Pendiente' }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <button class="update-badge"
                                style="background: rgba(231, 76, 60, 0.1); color: #e74c3c; border-color: rgba(231, 76, 60, 0.2); margin: 0 auto;"
                                wire:click="eliminar({{ $informe->id }})"
                                wire:confirm="¿Estás seguro de eliminar este registro?">
                                <span class="material-symbols-outlined">delete</span>
                                Eliminar
                            </button>
                        </td>
                        <td style="text-align: center;">
                            <input type="checkbox"
                                style="width: 18px; height: 18px; cursor: pointer; accent-color: #05ccd1;"
                                wire:click="select({{ $informe->id }})"
                                {{ is_array($selectTeachers) && in_array($informe->id, $selectTeachers) ? 'checked' : '' }}>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 60px;">
                            <span class="material-symbols-outlined"
                                style="font-size: 48px; color: #cbd5e0;">person_off</span>
                            <p style="margin-top: 15px; color: #718096; font-weight: 500;">No se encontraron registros
                                de pagos para docentes</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot class="total-row">
                <tr>
                    <td colspan="2">RESUMEN DE PAGOS REALIZADOS</td>
                    <td style="color: #27ae60; font-size: 1.1rem;">${{ number_format($total, 0, ',', '.') }}</td>
                    <td colspan="4"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
