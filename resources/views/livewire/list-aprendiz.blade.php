<div class="la-container">
    <div class="la-filters-card">
        <div class="la-filter-top">
            <form>
                <div class="la-input-group">
                    <label for="filtro">Filtra por el nombre del aprendiz</label>
                    <input type="text" wire:model.live="nameAprendiz" placeholder="Buscar aprendiz...">
                </div>
            </form>
            <button type="button" wire:click="sendEmail" class="la-btn-email">
                <span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">mail</span>
                Enviar Email
            </button>
        </div>

        <div class="la-filter-bottom">
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

            <div class="la-segmented-control">
                <div class="la-segmented-item">
                    <input wire:model.live="estado" value="all" type="radio" id="option1" checked>
                    <label for="option1">Todos</label>
                </div>
                <div class="la-segmented-item">
                    <input wire:model.live="estado" value="active" type="radio" id="option2">
                    <label for="option2">Activos</label>
                </div>
                <div class="la-segmented-item">
                    <input wire:model.live="estado" value="inactive" type="radio" id="option3">
                    <label for="option3">Inactivos</label>
                </div>
            </div>
        </div>
    </div>

    <div class="la-table-card">
        <div class="la-table-responsive">
            <table class="la-table">
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
                                <div class="la-user-info">
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
                                            <span class="la-badge-new">Nuevo</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $aprendiz->level->name ?? 'N/A' }}</td>
                            <td>{{ $aprendiz->group->name ?? 'Sin grupo' }}</td>
                            <td>
                                <span class="la-status-pill {{ $aprendiz->estado == 1 ? 'active' : 'inactive' }}">
                                    {{ $aprendiz->estado == 1 ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            @if ($user->rol_id == 1)
                                <td>
                                    <div class="la-actions">
                                        <a href="{{ route('viewUpdate', $aprendiz->id) }}" class="la-btn-edit"
                                            title="Editar">
                                            <span class="material-symbols-outlined">edit</span>
                                            Editar
                                        </a>
                                        <button class="la-btn-delete" wire:click="delete({{ $aprendiz->id }})"
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
                                <div class="la-no-data">
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
