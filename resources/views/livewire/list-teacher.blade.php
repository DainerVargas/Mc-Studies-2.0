<div class="teacher-list">

    <div class="teacher-list__header" id="conteProfesor">
        <form wire:submit="filtrar">
            <div class="teacher-list__search">
                <label for="filtro">Filtra por el nombre</label>
                <input type="text" wire:model.live="filtro" placeholder="Buscar por nombre...">
            </div>
        </form>

        <div class="teacher-list__filters">
            <div class="teacher-list__status-filters">
                <div class="status-radio">
                    <input wire:model.live="estado" value="all" type="radio" checked id="option1">
                    <label for="option1">Todos</label>
                </div>
                <div class="status-radio">
                    <input wire:model.live="estado" value="active" type="radio" id="option2">
                    <label for="option2">Activos</label>
                </div>
                <div class="status-radio">
                    <input wire:model.live="estado" value="inactive" type="radio" id="option3">
                    <label for="option3">Inactivos</label>
                </div>
            </div>
        </div>

        <div class="teacher-list__actions">
            <button class="btn-add" wire:click="update">
                <img src="/images/agregar.png" alt="">
                Agregar
            </button>
            <a href="{{ route('registerHours') }}">
                <button class="btn-hours">Registro de horas</button>
            </a>
        </div>

    </div>

    <div class="teacher-list__content">
        <div class="teacher-list__table-wrapper">
            <table class="teacher-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Profesor</th>
                        <th>Email</th>
                        <th>Registro asistencia</th>
                        <th>Calificaciones</th>
                        <th>Estado</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @forelse ($profesores as $profesor)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>
                                <div class="name-wrapper">
                                    @if ($profesor->image)
                                        <img class="avatar" src="/users/{{ $profesor->image }}" alt="">
                                    @else
                                        <img class="avatar" src="/images/perfil.png" alt="">
                                    @endif
                                    <a class="name-link" href="{{ route('infoProfesor', $profesor->id) }}">
                                        {{ $profesor->name }} {{ $profesor->apellido }}
                                    </a>
                                </div>
                            </td>
                            <td>{{ $profesor->email }}</td>
                            @php
                                $estado = $profesor->estado == 1 ? 'active' : 'inactive';
                                $estadoLabel = $profesor->estado == 1 ? 'Activo' : 'Inactivo';
                            @endphp
                            <td>
                                <div class="flex">
                                    @if ($profesor->type_teacher_id == 1 || $profesor->type_teacher_id == 2)
                                        <a href="{{ route('asistencias', $profesor->id) }}">
                                            <button class="action-btn action-btn--secondary">Ir al registro</button>
                                        </a>
                                    @else
                                        <span style="color: #cbd5e0;">No aplica</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="flex">
                                    @if ($profesor->type_teacher_id == 1 || $profesor->type_teacher_id == 2)
                                        <a href="{{ route('qualification', $profesor->id) }}">
                                            <button class="action-btn action-btn--secondary">Ir a calificación</button>
                                        </a>
                                    @else
                                        <span style="color: #cbd5e0;">No aplica</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="flex">
                                    <span class="status-badge status-badge--{{ $estado }}">
                                        {{ $estadoLabel }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="flex">
                                    <a href="{{ route('infoProfesor', $profesor->id) }}"
                                        style="text-decoration: none;">
                                        <button class="icon-btn icon-btn--edit" title="Editar">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="flex">
                                    @if (auth()->user()->rol_id == 1)
                                        <button class="icon-btn icon-btn--delete"
                                            wire:click="delete({{ $profesor->id }})"
                                            wire:confirm="¿Desea eliminar el {{ $profesor->type_teacher->name }} {{ $profesor->name }}?"
                                            title="Eliminar">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 3rem;">
                                <p class="nodatos" style="font-size: 1.2rem; margin-bottom: 1rem; color: #718096;">No
                                    hay datos</p>
                                <video class="video" src="/videos/video2.mp4"
                                    style="height: 200px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                                    autoplay loop>
                                    <source src="/videos/video2.mp4" type="">
                                </video>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($view != 0)
        <div class="teacher-modal">
            <div class="teacher-modal__form">
                <div class="teacher-modal__close">
                    <span wire:click="ocultar" title="Cerrar" class="material-symbols-outlined">
                        close
                    </span>
                </div>

                <form wire:submit="save">
                    <!-- Changed from empty action to wire:submit="save" but wire:submit inside handles it if button is type submit? usually wire:submit on form is better -->
                    <!-- Wait, original had wire:submit="" and button wire:click="save". Keeping button wire:click is safer if save is a method. -->

                    <div class="teacher-modal__image-upload">
                        <div class="image-wrapper">
                            @if ($image)
                                <img class="profile-img" src="{{ $image->temporaryUrl() }}" alt="">
                            @else
                                <img class="profile-img" src="/images/perfil.png" alt="">
                            @endif

                            <label for="image" class="upload-label" title="Subir Foto">
                                <img src="/images/mas.png" alt="">
                            </label>

                            <input type="file" wire:model="image" id="image" hidden>

                            <span class="material-symbols-outlined loading-spinner" wire:loading wire:target="image">
                                directory_sync
                            </span>
                        </div>
                        @error('image')
                            <small class="error-msg"
                                style="position:absolute; bottom: -20px; color: red;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="teacher-modal__row">
                        <div class="teacher-modal__input-group">
                            <label for="name">Nombre</label>
                            <input wire:model="name" type="text" placeholder="Nombre" id="name">
                            @error('name')
                                <small class="error-msg">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="teacher-modal__input-group">
                            <label for="apellido">Apellido</label>
                            <input wire:model="apellido" type="text" placeholder="Apellido" id="apellido">
                            @error('apellido')
                                <small class="error-msg">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="teacher-modal__row">
                        <div class="teacher-modal__input-group">
                            <label for="email">Email</label>
                            <input wire:model="email" type="text" placeholder="Email" id="email">
                            @error('email')
                                <small class="error-msg">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="teacher-modal__input-group">
                            <label for="telefono">Teléfono</label>
                            <input wire:model="telefono" type="text" placeholder="Teléfono" id="telefono">
                            @error('telefono')
                                <small class="error-msg">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="teacher-modal__row">
                        <div class="teacher-modal__input-group">
                            <label for="type">Tipo de profesor</label>
                            <select wire:model="type_teacher_id" id="type">
                                <option value="" selected hidden>Seleccione el tipo...</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('type_teacher_id')
                                <small class="error-msg">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <button type="button" class="teacher-modal__btn-submit" wire:click="save">Registrar</button>
                </form>
            </div>
        </div>
    @endif
</div>
