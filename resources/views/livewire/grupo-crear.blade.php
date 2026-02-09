<div class="gc-container">
    <div class="gc-filters-card">
        <div class="gc-filter-header">
            <div class="gc-filter-title">
                <span class="material-symbols-outlined">filter_list</span>
                Gestión de Grupos
            </div>
        </div>

        <div class="gc-filter-content">
            <form>
                <div class="gc-input-group">
                    <label for="filtro">Filtra por el nombre del Grupo</label>
                    <input type="text" wire:model.live="filtroName" placeholder="Buscar por nombre...">
                </div>
            </form>
            <div class="gc-select-group">
                <div class="gc-segmented-control">
                    <div class="gc-segmented-item">
                        <input wire:model.live="estado" value="" type="radio" checked="" id="option1">
                        <label for="option1">Todos</label>
                    </div>
                    <div class="gc-segmented-item">
                        <input wire:model.live="estado" value="active" type="radio" id="option2">
                        <label for="option2">Mc-Kids</label>
                    </div>
                    <div class="gc-segmented-item">
                        <input wire:model.live="estado" value="inactive" type="radio" id="option3">
                        <label for="option3">Mc-Teens</label>
                    </div>
                </div>
            </div>
            <div class="gc-create-action">
                <button wire:click="update">
                    <span class="material-symbols-outlined">group_add</span>
                    Crear Grupo
                </button>
            </div>
        </div>
    </div>

    <div class="gc-table-container">
        <div class="gc-table-wrapper">
            <table class="gc-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nombre del Grupo</th>
                        <th>Profesor</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                        $cantidad = 0;
                    @endphp
                    @forelse ($grupos ?? [] as $grupo)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td style="cursor: pointer" class="relative" wire:click="verDetalle({{ $grupo->id }})">
                                {{ $grupo->name }}
                            </td>
                            @if (!$grupo->teacher)
                                <td>Sin Profesor</td>
                            @else
                                <td>{{ $grupo->teacher->name }} {{ $grupo->teacher->apellido }}</td>
                            @endif

                            <td>{{ $grupo->type->name }}</td>
                            <td>{{ count($grupo->apprentice) }}</td>
                            @php
                                $cantidad += count($grupo->apprentice);
                            @endphp
                            <td>
                                <div class="flex">
                                    <a><button type="button" class="update"
                                            wire:click="actualizar({{ $grupo->id }})"><span
                                                class="material-symbols-outlined">
                                                edit
                                            </span> Editar</button></a>
                                </div>
                            </td>
                            <td>
                                <div class="flex">
                                    <button class="delete" wire:click="delete({{ $grupo->id }})"
                                        wire:confirm="¿Desea elimiar el grupo {{ $grupo->name }} ?"><span
                                            class="material-symbols-outlined">
                                            delete
                                        </span> Eliminar</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="nodatos">
                                    <p>No hay datos disponibles</p>
                                    <video class="video" src="/videos/video2.mp4" height="180vw" autoplay loop>
                                        <source src="/videos/video2.mp4" type="">
                                    </video>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">Total alumnos inscritos</td>
                        <td class="cantidad">{{ $cantidad }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    @if ($view != 0)
        <div class="gc-modal-overlay">
            <div class="gc-modal-card">
                <button class="gc-modal-close" wire:click="ocultar" title="Cerrar">
                    <span class="material-symbols-outlined">close</span>
                </button>
                <div class="gc-modal-header">
                    <h1>NUEVO GRUPO</h1>
                </div>
                <form wire:submit="" id="formgroup">
                    <div class="gc-form-grid">
                        <div class="gc-form-row">
                            <div class="gc-input-group">
                                <label class="label" for="filtroTeacher">Filtrar Profesor</label>
                                <input wire:model.live="filtroTeacher" type="text" placeholder="Buscar por nombre..."
                                    id="filtroTeacher">
                            </div>
                            <div class="gc-input-group">
                                <label class="label">Seleccionar Profesor</label>
                                <select name="teacher_id" wire:model="teacher_id">
                                    <option value="">Seleccione...</option>
                                    @foreach ($profesores as $profesor)
                                        @if ($profesor->type_teacher_id == 1 || $profesor->type_teacher_id == 2)
                                            <option value="{{ $profesor->id }}">{{ $profesor->name }} -
                                                {{ $profesor->type_teacher->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                    <small class="errors" style="color: #E74C3C">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="gc-form-row">
                            <div class="gc-input-group">
                                <label class="label" for="groupName">Nombre del Grupo</label>
                                <input id="groupName" wire:model="name" type="text" placeholder="Ej: Nivel 1 - A">
                                @error('name')
                                    <small class="errors" id="errors" style="color: #E74C3C">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="gc-input-group">
                                <label class="label">Tipo de Grupo</label>
                                <select wire:model="type_id">
                                    <option value="" selected hidden>Seleccione el tipo...</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                    <small class="errors" id="errors"
                                        style="color: #E74C3C">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="gc-modal-footer">
                        <button type="button" class="gc-btn-cancel" wire:click="ocultar">Cancelar</button>
                        <button type="button" class="gc-btn-save" wire:click="save">Registrar Grupo</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if ($view2 != 0)
        <div class="gc-modal-overlay">
            <div class="gc-modal-card" id="updateGroup">
                <button class="gc-modal-close" wire:click="ocultar" title="Cerrar">
                    <span class="material-symbols-outlined">close</span>
                </button>
                <div class="gc-modal-header">
                    <h1>ACTUALIZAR GRUPO</h1>
                </div>
                <form wire:submit="" id="formgroup">
                    <div class="gc-form-grid">
                        <div class="gc-input-group">
                            <label class="label" for="editGroupName">Nombre del Grupo</label>
                            <input id="editGroupName" wire:model="grupoNmae" type="text"
                                placeholder="Nombre del grupo">
                            @error('grupoNmae')
                                <small class="errors" id="errors" style="color: #E74C3C">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="gc-input-group">
                            <label class="label">Profesor Asignado</label>
                            <select name="teacher_id" wire:model="profesor_id">
                                <option value="" selected hidden>Seleccione...</option>
                                @if (isset($profesorName))
                                    <option selected value="{{ $profesorName->id }}"> {{ $profesorName->name }}
                                    </option>
                                    @foreach ($profesores as $profesor)
                                        @if ($profesorName->id != $profesor->id)
                                            <option value="{{ $profesor->id }}">{{ $profesor->name }} </option>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach ($profesores as $profesor)
                                        <option value="{{ $profesor->id }}">{{ $profesor->name }} </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('profesor_id')
                                <small class="errors" id="errors" style="color: #E74C3C">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="gc-modal-footer">
                        <button type="button" class="gc-btn-cancel" wire:click="ocultar">Cancelar</button>
                        <button type="button" class="gc-btn-update"
                            wire:click="guardar({{ $grupoId }})">Actualizar Grupo</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if ($show)
        <div class="gc-modal-overlay">
            <div class="gc-modal-card gc-modal-detail">
                <button class="gc-modal-close" wire:click="ocultar" title="Cerrar">
                    <span class="material-symbols-outlined">close</span>
                </button>

                <div class="gc-detail-content">
                    <div class="gc-detail-header">
                        <div class="gc-detail-title">
                            <h2>{{ $groupName }}</h2>
                            <div class="gc-detail-badges">
                                <span class="gc-badge teacher">
                                    <span class="material-symbols-outlined">person</span>
                                    {{ $nameTeacher }}
                                </span>
                                <span class="gc-badge type">
                                    <span class="material-symbols-outlined">category</span>
                                    {{ $typeGroup }}
                                </span>
                            </div>
                        </div>

                        <button wire:click="descargarReporte" class="gc-btn-download">
                            <span class="material-symbols-outlined">download</span>
                            Descargar Reporte
                        </button>
                    </div>

                    <div class="gc-charts-section">
                        @foreach ($qualifications as $semestre => $data)
                            <div class="gc-chart-group">
                                <span class="label">Semestre {{ $semestre }}</span>

                                <div class="gc-chart-grid">
                                    @foreach (['listening', 'writing', 'reading', 'speaking', 'global'] as $key)
                                        @php
                                            $value = $data[$key];
                                            $isGlobal = $key === 'global';
                                            if ($isGlobal) {
                                                $color = 'linear-gradient(90deg, #99BF51, #7da63d)';
                                            } else {
                                                $color =
                                                    $value >= 75
                                                        ? 'linear-gradient(90deg, #05CCD1, #04a5a9)'
                                                        : 'linear-gradient(90deg, #E74C3C, #c0392b)';
                                            }
                                        @endphp
                                        <div class="gc-chart-item">
                                            <div class="gc-chart-info">
                                                <span>{{ ucfirst($key) }}</span>
                                                <span>{{ $value }}%</span>
                                            </div>
                                            <div class="gc-chart-track">
                                                <div class="gc-chart-bar {{ $isGlobal ? 'global' : '' }}"
                                                    style="width: {{ $value }}%; background: {{ $color }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
