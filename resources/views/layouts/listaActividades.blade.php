@extends('Dashboard')
@section('title', 'Lista de Actividades')

@section('listaAprendiz')
    <div class="ux-ap-container">
        {{-- Tabs de Navegación --}}
        <div class="ux-ap-tabs">
            <a href="{{ route('listaActividades', array_merge(request()->all(), ['view' => 'recibidas'])) }}"
                class="ux-ap-tab {{ $view === 'recibidas' ? 'active' : '' }}">
                <span class="material-symbols-outlined">inbox</span>
                Actividades Recibidas
            </a>
            <a href="{{ route('listaActividades', array_merge(request()->all(), ['view' => 'asignadas'])) }}"
                class="ux-ap-tab {{ $view === 'asignadas' ? 'active' : '' }}">
                <span class="material-symbols-outlined">outbox</span>
                Mis Asignaciones a Grupos
            </a>
        </div>

        {{-- Filtros --}}
        <div class="ux-ap-filters-card">
            <form action="{{ route('listaActividades') }}" method="GET">
                <input type="hidden" name="view" value="{{ $view }}">
                <div class="ux-ap-filter-top">
                    <div class="ux-ap-input-group">
                        <label for="search">Buscar por nombre de actividad</label>
                        <div class="ux-ap-input-with-icon">
                            <span class="material-symbols-outlined">search</span>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Buscar actividad..." onchange="this.form.submit()">
                        </div>
                    </div>
                    <div class="ux-ap-input-group">
                        <label for="fecha">Filtrar por fecha</label>
                        <input type="date" name="fecha" id="fecha" value="{{ request('fecha') }}"
                            onchange="this.form.submit()"
                            style="height: 54px; border-radius: 16px; border: 2px solid #eef2f6; padding: 0 1.5rem; background: #f8fafc; font-size: 1rem; font-weight: 600;">
                    </div>
                </div>

                <div class="ux-ap-filter-bottom">
                    <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; flex: 1;">
                        <select name="group_id" onchange="this.form.submit()" style="min-width: 200px;">
                            <option value="">Todos los grupos</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}"
                                    {{ request('group_id') == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>

                        @if ($view === 'recibidas')
                            <select name="aprendiz_id" onchange="this.form.submit()" style="min-width: 200px;">
                                <option value="">Todos los aprendices</option>
                                @foreach ($aprendices as $aprendiz)
                                    <option value="{{ $aprendiz->id }}"
                                        {{ request('aprendiz_id') == $aprendiz->id ? 'selected' : '' }}>
                                        {{ $aprendiz->name }} {{ $aprendiz->apellido }}
                                    </option>
                                @endforeach
                            </select>
                        @endif

                        @if (request()->anyFilled(['search', 'fecha', 'aprendiz_id', 'group_id']))
                            <a href="{{ route('listaActividades') }}" class="ux-ap-btn-clear">
                                LIMPIAR FILTROS
                            </a>
                        @endif
                    </div>

                    @livewire('assign-activity-modal')
                </div>
            </form>
        </div>

        {{-- Tabla de Actividades --}}
        <div class="ux-ap-table-card">
            <div class="ux-ap-table-responsive">
                <table class="ux-ap-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Título</th>
                            @if ($view === 'recibidas')
                                <th>Aprendiz</th>
                                <th>Acudiente</th>
                            @else
                                <th colspan="2">Grupos Destinatarios</th>
                            @endif
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Archivo</th>
                            @if ($view === 'asignadas' && $user->rol_id == 1)
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if ($view === 'recibidas')
                            @forelse ($activities as $index => $activity)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong style="color: #0f172a; font-weight: 700;">{{ $activity->titulo }}</strong>
                                    </td>
                                    <td>
                                        @if ($activity->apprentice)
                                            <div class="ux-ap-user-info">
                                                @if ($activity->apprentice->imagen)
                                                    <img src="/users/{{ $activity->apprentice->imagen }}"
                                                        alt="{{ $activity->apprentice->name }}">
                                                @else
                                                    <img src="/images/perfil.png" alt="Perfil">
                                                @endif
                                                <div style="display: flex; flex-direction: column;">
                                                    <a href="{{ route('informacion', $activity->apprentice->id) }}">
                                                        {{ $activity->apprentice->name }}
                                                        {{ $activity->apprentice->apellido }}
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <span style="color: #cbd5e1;">Sin aprendiz</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($activity->attendant)
                                            {{ $activity->attendant->name }} {{ $activity->attendant->apellido }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <div class="ux-ap-description-cell" title="{{ $activity->descripcion }}">
                                            {{ $activity->descripcion }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="ux-ap-date-cell">
                                            <span
                                                class="day">{{ \Carbon\Carbon::parse($activity->created_at)->format('d/m/Y') }}</span>
                                            <span
                                                class="time">{{ \Carbon\Carbon::parse($activity->created_at)->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($activity->archivo)
                                            <a href="{{ asset('users/' . $activity->archivo) }}" target="_blank"
                                                class="ux-ap-btn-action-download-blue" title="Descargar Actividad">
                                                <span class="material-symbols-outlined">download</span>
                                                <span>Archivo</span>
                                            </a>
                                        @else
                                            <span class="ux-ap-no-file">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="ux-ap-no-data">
                                            <p>No se encontraron actividades</p>
                                            <video src="/videos/video2.mp4" autoplay loop muted></video>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        @else
                            @forelse ($assignedActivities as $index => $activity)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong
                                            style="color: #6c5ce7; font-weight: 700; font-size: 1.05rem;">{{ $activity->titulo }}</strong>
                                    </td>
                                    <td colspan="2">
                                        <div class="ux-ap-groups-container">
                                            @foreach ($activity->groups as $group)
                                                <span class="ux-ap-group-pill">
                                                    {{ $group->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <div class="ux-ap-description-cell" title="{{ $activity->descripcion }}">
                                            {{ $activity->descripcion }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="ux-ap-date-cell">
                                            <span class="day">{{ $activity->created_at->format('d/m/Y') }}</span>
                                            <span class="time">{{ $activity->created_at->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($activity->archivo)
                                            <a href="{{ asset('users/' . $activity->archivo) }}" target="_blank"
                                                class="ux-ap-btn-action-download" title="Descargar Guía">
                                                <span class="material-symbols-outlined">download</span>
                                                <span>Guía</span>
                                            </a>
                                        @else
                                            <span class="ux-ap-no-file">N/A</span>
                                        @endif
                                    </td>
                                    @if ($user->rol_id == 1)
                                        <td>
                                            <form action="{{ route('listaActividades.destroy', $activity->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Está seguro de que desea eliminar esta actividad?\n\nEsta acción no se puede deshacer.')"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ux-ap-btn-delete-activity"
                                                    title="Eliminar Actividad">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="ux-ap-no-data">
                                            <p>No has asignado actividades aún</p>
                                            <video src="/videos/video2.mp4" autoplay loop muted></video>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .ux-ap-tabs {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            background: #f8fafc;
            padding: 8px;
            border-radius: 20px;
            border: 2px solid #eef2f6;
            width: fit-content;
        }

        .ux-ap-tab {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            border-radius: 14px;
            text-decoration: none;
            color: #64748b;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .ux-ap-tab:hover {
            color: #1e293b;
            background: #f1f5f9;
        }

        .ux-ap-tab.active {
            background: white;
            color: #6c5ce7;
            box-shadow: 0 4px 12px rgba(108, 92, 231, 0.15);
        }

        .ux-ap-tab span {
            font-size: 1.25rem;
        }

        /* Mejoras en la tabla de asignaciones */
        .ux-ap-groups-container {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            max-width: 250px;
        }

        .ux-ap-group-pill {
            background: #f0eeff;
            color: #6c5ce7;
            padding: 4px 10px;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 800;
            border: 1px solid #dcd7ff;
            white-space: nowrap;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .ux-ap-description-cell {
            color: #64748b;
            font-size: 0.88rem;
            max-width: 280px;
            line-height: 1.5;
            max-height: 60px;
            overflow-y: auto;
            padding-right: 8px;
        }

        .ux-ap-description-cell::-webkit-scrollbar {
            width: 4px;
        }

        .ux-ap-description-cell::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .ux-ap-date-cell {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .ux-ap-date-cell .day {
            color: #1e293b;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .ux-ap-date-cell .time {
            color: #94a3b8;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .ux-ap-btn-action-download {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #6c5ce7;
            color: white !important;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(108, 92, 231, 0.2);
            border: none;
        }

        .ux-ap-btn-action-download:hover {
            background: #5849c4;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(108, 92, 231, 0.3);
        }

        .ux-ap-btn-action-download-blue {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #0ea5e9;
            color: white !important;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(14, 165, 233, 0.2);
            border: none;
        }

        .ux-ap-btn-action-download-blue:hover {
            background: #0284c7;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(14, 165, 233, 0.3);
        }

        .ux-ap-no-file {
            color: #cbd5e1;
            font-size: 0.8rem;
            font-weight: 600;
            font-style: italic;
        }

        .ux-ap-btn-delete-activity {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #fed7d7;
            color: #c53030;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .ux-ap-btn-delete-activity:hover {
            background: #c53030;
            color: white;
            transform: scale(1.05);
        }
    </style>
@endsection
