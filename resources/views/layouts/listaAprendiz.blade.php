@extends('Dashboard')
@section('title', 'Lista-Aprendices')

@section('listaAprendiz')
    <div class="ux-ap-container">
        {{-- Formulario de Filtros --}}
        <div class="ux-ap-filters-card">
            <form action="{{ route('listaAprendiz') }}" method="GET">
                <div class="ux-ap-filter-top">
                    <div class="ux-ap-input-group">
                        <label for="name">Filtra por el nombre del aprendiz</label>
                        <div class="ux-ap-input-with-icon">
                            <span class="material-symbols-outlined">search</span>
                            <input type="text" name="name" id="name" value="{{ request('name') }}"
                                placeholder="Buscar aprendiz..." onchange="this.form.submit()">
                        </div>
                    </div>
                    <div class="ux-ap-actions-group">
                        <a href="{{ route('sendEmail') }}" class="ux-ap-btn-email">
                            <span class="material-symbols-outlined">email</span>
                            ENVIAR EMAIL
                        </a>
                        <a href="{{ route('listaActividades') }}" class="ux-ap-btn-activity">
                            <span class="material-symbols-outlined"
                                style="vertical-align: middle; margin-right: 8px;">list_alt</span>
                            Lista Actividades
                        </a>
                    </div>
                </div>

                <div class="ux-ap-filter-bottom">
                    <select name="grupo" onchange="this.form.submit()">
                        <option value="all" {{ request('grupo') == 'all' ? 'selected' : '' }}>Todos los grupos</option>
                        <option value="none" {{ request('grupo') == 'none' ? 'selected' : '' }}>Sin grupos</option>
                        @foreach ($gruposSelect as $grupoItem)
                            <option value="{{ $grupoItem->id }}" {{ request('grupo') == $grupoItem->id ? 'selected' : '' }}>
                                {{ $grupoItem->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="sede" onchange="this.form.submit()">
                        <option value="" {{ request('sede') == '' ? 'selected' : '' }}>Todas las sedes</option>
                        <option value="1" {{ request('sede') == '1' ? 'selected' : '' }}>Fonseca</option>
                        <option value="2" {{ request('sede') == '2' ? 'selected' : '' }}>San Juan</option>
                        <option value="3" {{ request('sede') == '3' ? 'selected' : '' }}>Online</option>
                    </select>

                    <div class="ux-ap-segmented-control">
                        <div class="ux-ap-segmented-item">
                            <input type="radio" name="estado" value="all" id="opt_all"
                                {{ request('estado', 'all') == 'all' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label for="opt_all">Todos</label>
                        </div>
                        <div class="ux-ap-segmented-item">
                            <input type="radio" name="estado" value="active" id="opt_active"
                                {{ request('estado') == 'active' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label for="opt_active">Activos</label>
                        </div>
                        <div class="ux-ap-segmented-item">
                            <input type="radio" name="estado" value="inactive" id="opt_inactive"
                                {{ request('estado') == 'inactive' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label for="opt_inactive">Inactivos</label>
                        </div>
                    </div>

                    @if (request()->anyFilled(['name', 'grupo', 'sede', 'estado']))
                        <a href="{{ route('listaAprendiz') }}" class="ux-ap-btn-clear">
                            LIMPIAR FILTROS
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabla de Resultados --}}
        <div class="ux-ap-table-card">
            <div class="ux-ap-table-responsive">
                <table class="ux-ap-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Aprendiz</th>
                            <th>Nivel</th>
                            <th>Grupo</th>
                            <th>Estado</th>
                            @if ($user->rol_id == 1)
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($aprendices as $index => $aprendiz)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="ux-ap-user-info">
                                        @if ($aprendiz->imagen)
                                            <img src="/users/{{ $aprendiz->imagen }}" alt="{{ $aprendiz->name }}">
                                        @else
                                            <img src="/images/perfil.png" alt="Perfil">
                                        @endif
                                        <div style="display: flex; flex-direction: column;">
                                            <a href="{{ route('informacion', $aprendiz->id) }}">
                                                {{ $aprendiz->name }} {{ $aprendiz->apellido }}
                                            </a>
                                            @if ($aprendiz->group_id == null || $aprendiz->group->teacher_id == null)
                                                <span class="ux-ap-badge-new">Nuevo</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $aprendiz->level->name ?? 'N/A' }}</td>
                                <td>{{ $aprendiz->group->name ?? 'Sin grupo' }}</td>
                                <td>
                                    <span class="ux-ap-status-pill {{ $aprendiz->estado == 1 ? 'active' : 'inactive' }}">
                                        {{ $aprendiz->estado == 1 ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                @if ($user->rol_id == 1)
                                    <td>
                                        <div class="ux-ap-actions">
                                            <a href="{{ route('viewUpdate', $aprendiz->id) }}" class="ux-ap-btn-edit"
                                                title="Editar">
                                                <span class="material-symbols-outlined">edit</span>
                                                Editar
                                            </a>
                                            <a href="{{ route('listaActividades', ['aprendiz_id' => $aprendiz->id]) }}"
                                                class="ux-ap-btn-view" title="Ver Actividades">
                                                <span class="material-symbols-outlined">visibility</span>
                                                Ver Actividades
                                            </a>
                                            <form action="{{ route('deleteAprendiz', $aprendiz->id) }}" method="POST"
                                                onsubmit="return confirm('¿Desea eliminar al aprendiz {{ $aprendiz->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ux-ap-btn-delete" title="Eliminar">
                                                    <span class="material-symbols-outlined">delete</span>
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $user->rol_id == 1 ? 6 : 5 }}">
                                    <div class="ux-ap-no-data">
                                        <p>No se encontraron aprendices</p>
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
