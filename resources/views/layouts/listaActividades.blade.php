@extends('Dashboard')
@section('title', 'Lista de Actividades')

@section('listaAprendiz')
    <div class="ux-ap-container">
        {{-- Filtros --}}
        <div class="ux-ap-filters-card">
            <form action="{{ route('listaActividades') }}" method="GET">
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
                    <select name="aprendiz_id" onchange="this.form.submit()">
                        <option value="">Todos los aprendices</option>
                        @foreach ($aprendices as $aprendiz)
                            <option value="{{ $aprendiz->id }}"
                                {{ request('aprendiz_id') == $aprendiz->id ? 'selected' : '' }}>
                                {{ $aprendiz->name }} {{ $aprendiz->apellido }}
                            </option>
                        @endforeach
                    </select>

                    @if (request()->anyFilled(['search', 'fecha', 'aprendiz_id']))
                        <a href="{{ route('listaActividades') }}" class="ux-ap-btn-clear">
                            LIMPIAR FILTROS
                        </a>
                    @endif
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
                            <th>Aprendiz</th>
                            <th>Acudiente</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Archivo</th>
                        </tr>
                    </thead>
                    <tbody>
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
                                    <p
                                        style="margin: 0; color: #64748b; font-size: 0.9rem; max-width: 300px; line-height: 1.4;">
                                        {{ Str::limit($activity->descripcion, 100) }}
                                    </p>
                                </td>
                                <td>
                                    <span style="color: #94a3b8; font-weight: 600; font-size: 0.85rem;">
                                        {{ \Carbon\Carbon::parse($activity->created_at)->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                                <td>
                                    @if ($activity->archivo)
                                        <a href="{{ asset('users/activities_docs/' . basename($activity->archivo)) }}"
                                            target="_blank" class="ux-ap-btn-download">
                                            <span class="material-symbols-outlined">download</span>
                                            Descargar
                                        </a>
                                    @else
                                        <span style="color: #cbd5e1;">Sin archivo</span>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
