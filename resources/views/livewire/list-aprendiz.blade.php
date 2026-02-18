<div class="ux-ap-container">
    <div class="ux-ap-filters-card">
        <div class="ux-ap-filter-top">
            <form>
                <div class="ux-ap-input-group">
                    <label for="filtro">Filtra por el nombre del aprendiz</label>
                    <input type="text" wire:model.live="nameAprendiz" placeholder="Buscar aprendiz...">
                </div>
            </form>
            <div class="ux-ap-actions-group">
                <button type="button" wire:click="sendEmail" class="ux-ap-btn-email">
                    <span class="material-symbols-outlined"
                        style="vertical-align: middle; margin-right: 8px;">mail</span>
                    Enviar Email
                </button>
                <a href="{{ route('listaActividades') }}" class="ux-ap-btn-activity">
                    <span class="material-symbols-outlined"
                        style="vertical-align: middle; margin-right: 8px;">list_alt</span>
                    Lista Actividades
                </a>
            </div>
        </div>

        <div class="ux-ap-filter-bottom">
            <select wire:model.live="grupo">
                <option value="all">Todos los grupos</option>
                <option value="none">Sin grupos</option>
                @foreach ($grupos as $grupoItem)
                    <option value="{{ $grupoItem->id }}">{{ $grupoItem->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="sede_id">
                <option value="">Todas las sedes</option>
                <option value="1">Fonseca</option>
                <option value="2">San Juan</option>
                <option value="3">Online</option>
            </select>

            <div class="ux-ap-segmented-control">
                <div class="ux-ap-segmented-item">
                    <input wire:model.live="estado" value="all" type="radio" id="option1" checked>
                    <label for="option1">Todos</label>
                </div>
                <div class="ux-ap-segmented-item">
                    <input wire:model.live="estado" value="active" type="radio" id="option2">
                    <label for="option2">Activos</label>
                </div>
                <div class="ux-ap-segmented-item">
                    <input wire:model.live="estado" value="inactive" type="radio" id="option3">
                    <label for="option3">Inactivos</label>
                </div>
            </div>
        </div>
    </div>

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
                    @php
                        $count = 1;
                    @endphp
                    @forelse ($aprendices as $aprendiz)
                        <tr>
                            <td>{{ $count++ }}</td>
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
                                        <button class="ux-ap-btn-view" wire:click="viewActivities({{ $aprendiz->id }})"
                                            title="Ver Actividades">
                                            <span class="material-symbols-outlined">visibility</span>
                                            Ver Actividades
                                        </button>
                                        <button class="ux-ap-btn-delete" wire:click="delete({{ $aprendiz->id }})"
                                            wire:confirm="¿Desea eliminar al aprendiz {{ $aprendiz->name }}?"
                                            title="Eliminar">
                                            <span class="material-symbols-outlined">delete</span>
                                            Eliminar
                                        </button>
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

    @if ($viewingActivities)
        <div class="ux-ap-modal-overlay">
            <div class="ux-ap-modal-card">
                <button class="ux-ap-modal-close" wire:click="closeActivities" title="Cerrar">
                    <span class="material-symbols-outlined">close</span>
                </button>
                <div class="ux-ap-modal-header">
                    <h2>Actividades de {{ $selectedApprenticeName }}</h2>
                </div>
                <div class="ux-ap-modal-body">
                    @if (count($selectedActivities) > 0)
                        <div class="ux-ap-activities-list">
                            @foreach ($selectedActivities as $activity)
                                <div class="ux-ap-activity-item">
                                    <div class="ux-ap-activity-icon">
                                        <span class="material-symbols-outlined">assignment</span>
                                    </div>
                                    <div class="ux-ap-activity-details">
                                        <h3>{{ $activity->titulo }}</h3>
                                        <p>{{ $activity->descripcion }}</p>
                                        <small>{{ $activity->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    @if ($activity->archivo)
                                        <a href="{{ asset('users/' . $activity->archivo) }}" target="_blank"
                                            class="ux-ap-btn-download">
                                            <span class="material-symbols-outlined">download</span>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="ux-ap-no-activities">
                            <span class="material-symbols-outlined">sentiment_dissatisfied</span>
                            <p>No hay actividades registradas para este aprendiz.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
