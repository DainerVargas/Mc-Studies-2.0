<div class="asistencia-container">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg-gray: #f9fafb;
            --border-color: #e5e7eb;
            --text-main: #111827;
            --text-muted: #6b7280;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .asistencia-container {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-gray);
            padding: 1.5rem;
            border-radius: 1rem;
            min-height: 80vh;
            width: 96%;
            margin: 0 auto;
        }

        /* Hero / Header Section */
        .header-section {
            margin-bottom: 2rem;
            text-align: center;
        }

        .header-section h1 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 0.25rem;
            letter-spacing: -0.025em;
        }

        .header-section p {
            color: var(--text-muted);
            font-size: 1rem;
        }

        /* Filter Bar - Compacted & Spaced */
        .filter-bar {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
            width: 95%;
            margin: 0 auto 1.5rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 1.5rem;
            align-items: center;
            border: 1px solid var(--border-color);
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .filter-group.search {
            flex: 0.5;
            min-width: 140px;
        }

        .filter-group.status {
            flex: 2;
            min-width: 320px;
            align-items: center;
        }

        .filter-group.date {
            flex: 0.4;
            min-width: 130px;
        }

        .filter-group.group {
            flex: 0.6;
            min-width: 160px;
        }

        .filter-group label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
        }

        .filter-bar input,
        .filter-bar select {
            padding: 0.45rem 0.6rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.85rem;
            transition: all 0.2s;
            background-color: #fff;
            color: var(--text-main);
            width: 100%;
        }

        #startDate,
        #endDate {
            max-width: 140px;
        }

        #grupo {
            max-width: 160px;
        }

        .filter-bar input:focus,
        .filter-bar select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        /* Status Pills - Toggleable style */
        .status-filters {
            display: flex;
            gap: 0.4rem;
            align-items: center;
        }

        .status-option {
            cursor: pointer;
        }

        .status-option input {
            display: none;
        }

        .status-option span {
            padding: 0.45rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            border: 1px solid var(--border-color);
            transition: all 0.2s;
            display: block;
            text-align: center;
            background: white;
            cursor: pointer;
            text-transform: uppercase;
        }

        .status-option input:checked+span {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 4px 8px rgba(79, 70, 229, 0.25);
        }

        /* Table Design */
        .table-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: var(--shadow);
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .asistencia-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .asistencia-table th {
            background: #f8fafc;
            padding: 1rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            border-bottom: 2px solid #f1f5f9;
        }

        .asistencia-table td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 0.9rem;
            color: var(--text-main);
        }

        .asistencia-table tr:hover {
            background-color: #f8fafc;
        }

        /* Badges */
        .badge {
            padding: 0.25rem 0.6rem;
            border-radius: 0.375rem;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            text-transform: uppercase;
        }

        .badge-presente {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .badge-ausente {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .badge-tarde {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fef3c7;
        }

        /* Marking controls */
        .marking-radio-group {
            display: flex;
            gap: 1.25rem;
        }

        .marking-radio {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .marking-radio input {
            width: 1.1rem;
            height: 1.1rem;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .obs-textarea {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.8rem;
            resize: none;
            min-height: 70px;
            transition: all 0.2s;
        }

        .obs-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        /* Action Buttons */
        .btn-primary {
            background-color: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.25);
            font-size: 0.9rem;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .footer-actions {
            margin-top: 2rem;
            display: flex;
            justify-content: flex-end;
            padding: 0.5rem 0;
        }

        /* Error & Alert messages */
        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            border: 1px solid #fecaca;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            background: white;
            border-radius: 1rem;
            border: 1px solid var(--border-color);
        }

        .empty-state p {
            font-size: 1.1rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            font-weight: 500;
        }

        .empty-state video {
            max-width: 450px;
            border-radius: 1.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 1024px) {
            .filter-group {
                flex: 1;
                min-width: 45%;
            }

            .filter-group.search,
            .filter-group.status {
                flex: 1 1 45%;
            }
        }

        @media (max-width: 768px) {
            .asistencia-container {
                width: 98%;
                padding: 1rem;
            }

            .filter-group {
                flex: 1 1 100%;
            }

            .marking-radio-group {
                flex-direction: column;
                gap: 0.6rem;
            }
        }
    </style>

    <div class="header-section">
        <h1>Control de Asistencia</h1>
        <p>MC Language Studies - Gestión Académica</p>
    </div>

    <!-- Barra de Filtros con Toggle y Espaciado -->
    <div class="filter-bar">
        <div class="filter-group search">
            <label for="search">Estudiante</label>
            <input type="text" id="search" wire:model.live="nameAprendiz" placeholder="Buscar...">
        </div>

        <div class="filter-group status">
            <label>Filtrar por</label>
            <div class="status-filters">
                <label class="status-option">
                    <input type="radio" name="filter" wire:click="setFilter('null')"
                        @if ($filter === 'null') checked @endif>
                    <span>Todos</span>
                </label>
                <label class="status-option">
                    <input type="radio" name="filter" wire:click="setFilter('presente')"
                        @if ($filter === 'presente') checked @endif>
                    <span>Presentes</span>
                </label>
                <label class="status-option">
                    <input type="radio" name="filter" wire:click="setFilter('ausente')"
                        @if ($filter === 'ausente') checked @endif>
                    <span>Ausentes</span>
                </label>
                <label class="status-option">
                    <input type="radio" name="filter" wire:click="setFilter('tarde')"
                        @if ($filter === 'tarde') checked @endif>
                    <span>Tardanzas</span>
                </label>
            </div>
        </div>

        <div class="filter-group date">
            <label for="startDate">Desde</label>
            <input type="date" id="startDate" wire:model.live="startDate">
        </div>

        <div class="filter-group date">
            <label for="endDate">Hasta</label>
            <input type="date" id="endDate" wire:model.live="endDate">
        </div>

        <div class="filter-group group">
            <label for="grupo">Grupo</label>
            <select id="grupo" wire:model.live="selectGrupo">
                <option value="all">Todos los grupos</option>
                @foreach ($grupos as $grupo)
                    <option value="{{ $grupo->id }}">{{ $grupo->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if ($message)
        <div class="alert-error">
            <span class="material-symbols-outlined" style="font-size: 1.25rem;">warning</span>
            {{ $message }}
        </div>
    @endif

    <!-- TABLA DE ASISTENCIA HORIZONTAL -->
    <div class="table-card" style="overflow-x: auto;">
        <table class="asistencia-table">
            <thead>
                <tr>
                    <th width="50" style="position: sticky; left: 0; background: #f8fafc; z-index: 10;">N°</th>
                    <th style="min-width: 200px; position: sticky; left: 50px; background: #f8fafc; z-index: 10;">
                        Estudiante</th>
                    @foreach ($datesInRange as $dateItem)
                        <th class="text-center" style="min-width: 100px;">
                            <div style="font-size: 0.65rem; color: #64748b;">
                                {{ \Carbon\Carbon::parse($dateItem)->translatedFormat('D') }}
                            </div>
                            <div>{{ \Carbon\Carbon::parse($dateItem)->format('d/m') }}</div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($estudiantes as $index => $estudiante)
                    <tr>
                        <td
                            style="color: #94a3b8; font-weight: 600; position: sticky; left: 0; background: inherit; z-index: 5;">
                            {{ $index + 1 }}</td>
                        <td
                            style="font-weight: 700; color: #1e293b; position: sticky; left: 50px; background: inherit; z-index: 5;">
                            {{ $estudiante->name }} {{ $estudiante->apellido }}
                        </td>
                        @foreach ($datesInRange as $dateItem)
                            <td class="text-center">
                                @php
                                    $asistRow = $asistencias[$estudiante->id][$dateItem] ?? null;
                                    $asistencia = is_array($asistRow) ? $asistRow[0] : null;
                                    $badgeClass = '';
                                    if ($asistencia) {
                                        $estadoVal = is_array($asistencia)
                                            ? $asistencia['estado']
                                            : $asistencia->estado;
                                        if ($estadoVal == 'presente') {
                                            $badgeClass = 'badge-presente';
                                        } elseif ($estadoVal == 'ausente') {
                                            $badgeClass = 'badge-ausente';
                                        } elseif ($estadoVal == 'tarde') {
                                            $badgeClass = 'badge-tarde';
                                        }
                                    }
                                @endphp

                                @if ($asistencia)
                                    @php
                                        $estadoVal = is_array($asistencia)
                                            ? $asistencia['estado']
                                            : $asistencia->estado;
                                        $obsVal = is_array($asistencia)
                                            ? $asistencia['observaciones'] ?? ''
                                            : $asistencia->observaciones ?? '';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}" title="{{ $obsVal }}">
                                        @if ($estadoVal == 'presente')
                                            <span class="material-symbols-outlined"
                                                style="font-size: 0.8rem;">check_circle</span>
                                        @elseif ($estadoVal == 'ausente')
                                            <span class="material-symbols-outlined"
                                                style="font-size: 0.8rem;">cancel</span>
                                        @elseif ($estadoVal == 'tarde')
                                            <span class="material-symbols-outlined"
                                                style="font-size: 0.8rem;">schedule</span>
                                        @endif
                                        {{ substr($estadoVal, 0, 1) }}
                                    </span>
                                @elseif ($dateItem == now()->format('Y-m-d'))
                                    {{-- Permitir marcar si es hoy y no tiene registro --}}
                                    <div class="marking-radio-group"
                                        style="justify-content: center; transform: scale(0.85);">
                                        <select wire:model="estado.{{ $estudiante->id }}"
                                            style="padding: 2px; font-size: 0.75rem; border-radius: 4px; border: 1px solid #ddd;">
                                            <option value="">-</option>
                                            <option value="presente">P</option>
                                            <option value="ausente">A</option>
                                            <option value="tarde">T</option>
                                        </select>
                                    </div>
                                @else
                                    <span style="color: #cbd5e1;">-</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($datesInRange) + 2 }}" class="text-center" style="padding: 3rem;">
                            <p style="color: #64748b;">No se encontraron estudiantes para este filtro.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($selectGrupo !== 'all' && count($estudiantes) > 0 && in_array(auth()->user()->rol_id, [1, 2, 3, 4, 7]))
        <div class="footer-actions">
            <button class="btn-primary" wire:click="guardarAsistencia">
                <span class="material-symbols-outlined">save</span>
                Guardar Registro de Asistencia (Hoy)
            </button>
        </div>
    @endif

    <div class="footer-actions">
        @if ($selectGrupo != 'all' && $startDate && $endDate)
            <a href="{{ route('descargarAsistencias', ['teacher' => $teacher->id, 'startDate' => $startDate, 'endDate' => $endDate, 'grupo' => $selectGrupo]) }}"
                style="text-decoration: none;">
                <button class="btn-primary">
                    <span class="material-symbols-outlined">description</span>
                    Imprimir reporte del rango
                </button>
            </a>
        @endif
    </div>

    <!-- ESTADO VACÍO -->
    @if (count($estudiantes) == 0 || (isset($mostrarVideo) && $mostrarVideo))
        <div class="empty-state">
            <p>No se encontraron registros activos.</p>
            <video autoplay loop muted playsinline>
                <source src="/videos/video2.mp4" type="video/mp4">
            </video>
        </div>
    @endif

    <!-- ESTADO VACÍO -->
    @if (($date != now()->format('Y-m-d') && empty($asistencias)) || (isset($mostrarVideo) && $mostrarVideo))
        <div class="empty-state">
            <p>No se encontraron registros activos.</p>
            <video autoplay loop muted playsinline>
                <source src="/videos/video2.mp4" type="video/mp4">
            </video>
        </div>
    @endif
</div>
