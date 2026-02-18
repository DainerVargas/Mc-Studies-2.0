<div class="activity-container">
    <div class="header-section">
        <div class="header-content">
            <div class="title-tabs-wrapper">
                <h2>Historial de Actividades</h2>
                @if (Auth::user()->attendant)
                    <div class="tabs-navigation">
                        <button wire:click="$set('showAssigned', false)"
                            class="tab-btn {{ !$showAssigned ? 'active' : '' }}">
                            <span class="material-symbols-outlined">history</span> Realizadas
                        </button>
                        <button wire:click="$set('showAssigned', true)"
                            class="tab-btn {{ $showAssigned ? 'active' : '' }}">
                            <span class="material-symbols-outlined">assignment</span> Asignadas
                        </button>
                    </div>
                @endif
            </div>

            <div class="filters-container">
                {{-- Search Filter --}}
                <div class="search-wrapper">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" wire:model.live="search" placeholder="Buscar actividad..."
                        class="modern-search-input">
                </div>

                {{-- Group Filter (Staff only) --}}
                @if (in_array((int) Auth::user()->rol_id, [1, 2, 3, 4]))
                    <div class="filter-wrapper">
                        <select wire:model.live="filterGroup" class="modern-filter-select">
                            <option value="">Todos los grupos</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                {{-- Student Filter --}}
                @if ($children && count($children) > 0)
                    <div class="filter-wrapper">
                        <select wire:model.live="filterChild" class="modern-filter-select">
                            <option value="">
                                {{ in_array((int) Auth::user()->rol_id, [1, 2, 3, 4]) ? 'Todos los estudiantes' : 'Mi(s) hijo(s)' }}
                            </option>
                            @foreach ($children as $child)
                                <option value="{{ $child->id }}">{{ $child->name }} {{ $child->apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                @if (Auth::user()->attendant)
                    <button wire:click="createActivity" class="btn-create">
                        <span class="material-symbols-outlined">upload_file</span>
                        <span class="btn-text">Registrar Actividad</span>
                    </button>
                @else
                    <button wire:click="openAssignModal" class="btn-assign">
                        <span class="material-symbols-outlined">add_task</span>
                        <span class="btn-text">Asignar Actividad</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="scrollable-timeline-container">
        @if (!$showAssigned)
            {{-- Realizadas Timeline --}}
            <div class="activities-timeline">
                @forelse ($activities as $activity)
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="meta-info">
                                <span class="date">{{ $activity->fecha->format('d M, Y') }}</span>
                                @if ($activity->apprentice)
                                    <span class="student-badge">
                                        <span class="material-symbols-outlined">person</span>
                                        {{ $activity->apprentice->name }} {{ $activity->apprentice->apellido }}
                                    </span>
                                @endif
                                @if ($activity->attendant)
                                    <span class="parent-badge"
                                        style="margin-left: 10px; color: #64748b; font-size: 0.8rem;">
                                        Por: {{ $activity->attendant->name }}
                                    </span>
                                @endif
                            </div>
                            <div class="content-card">
                                <div class="card-header">
                                    <h3>{{ $activity->titulo }}</h3>
                                    @if ($activity->created_at->diffInMinutes(now()) <= 10 || Auth::user()->rol_id == 1)
                                        <button wire:click="deleteActivity({{ $activity->id }})"
                                            wire:confirm="¿Estás seguro de que deseas eliminar esta actividad?"
                                            class="btn-delete">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    @endif
                                </div>
                                @if ($activity->descripcion)
                                    <p class="description">{{ $activity->descripcion }}</p>
                                @endif
                                @if ($activity->archivo)
                                    @php
                                        $extension = pathinfo($activity->archivo, PATHINFO_EXTENSION);
                                        $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'wmv']);
                                        $fileUrl = asset('users/' . $activity->archivo);
                                    @endphp

                                    @if ($isVideo)
                                        <div class="video-container" style="margin-top: 10px;">
                                            <video controls style="width: 100%; max-width: 400px; border-radius: 8px;">
                                                <source src="{{ $fileUrl }}" type="video/{{ $extension }}">
                                                Tu navegador no soporta la reproducción de videos.
                                            </video>
                                        </div>
                                        <a href="{{ $fileUrl }}" target="_blank" class="download-link"
                                            style="font-size: 0.85rem; color: #667eea; display: block; margin-top: 5px;">
                                            Descargar Video
                                        </a>
                                    @else
                                        <a href="{{ $fileUrl }}" target="_blank" class="file-attachment">
                                            <div class="file-icon">
                                                <span class="material-symbols-outlined">description</span>
                                            </div>
                                            <div class="file-info">
                                                <span class="filename">Ver Documento Adjunto</span>
                                                <span class="click-hint">Clic para descargar/ver</span>
                                            </div>
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-data">
                        <span class="material-symbols-outlined">history</span>
                        <p>No hay actividades registradas aún.</p>
                    </div>
                @endforelse

                @if ($activities->count() < $totalActivitiesCount)
                    <div class="load-more-container">
                        <button wire:click="loadMore" class="btn-load-more">
                            <span>Cargar más</span>
                        </button>
                    </div>
                @endif
            </div>
        @else
            {{-- Asignadas Timeline --}}
            <div class="activities-timeline">
                @forelse ($assignedActivities as $activity)
                    <div class="timeline-item">
                        <div class="timeline-marker" style="background: #6c5ce7;"></div>
                        <div class="timeline-content">
                            <div class="meta-info">
                                <span class="date">{{ $activity->created_at->format('d M, Y') }}</span>
                                @foreach ($activity->groups as $group)
                                    <span class="group-badge">
                                        <span class="material-symbols-outlined">group</span>
                                        {{ $group->name }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="content-card assigned-card">
                                <div class="card-header">
                                    <h3>{{ $activity->titulo }}</h3>
                                    <span class="staff-name">Asignado por: {{ $activity->user->name }}</span>
                                </div>
                                @if ($activity->descripcion)
                                    <p class="description">{{ $activity->descripcion }}</p>
                                @endif
                                @if ($activity->archivo)
                                    @php
                                        $extension = pathinfo($activity->archivo, PATHINFO_EXTENSION);
                                        $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'wmv']);
                                        $fileUrl = asset('users/' . $activity->archivo);
                                    @endphp

                                    @if ($isVideo)
                                        <div class="video-container" style="margin-top: 10px;">
                                            <video controls style="width: 100%; max-width: 400px; border-radius: 8px;">
                                                <source src="{{ $fileUrl }}" type="video/{{ $extension }}">
                                                Tu navegador no soporta la reproducción de videos.
                                            </video>
                                        </div>
                                        <a href="{{ $fileUrl }}" target="_blank" class="download-link"
                                            style="font-size: 0.85rem; color: #667eea; display: block; margin-top: 5px;">
                                            Descargar Video
                                        </a>
                                    @else
                                        <a href="{{ $fileUrl }}" target="_blank"
                                            class="file-attachment assigned-file">
                                            <div class="file-icon">
                                                <span class="material-symbols-outlined">assignment</span>
                                            </div>
                                            <div class="file-info">
                                                <span class="filename">Ver Guía / Actividad Asignada</span>
                                                <span class="click-hint">Clic para descargar/ver</span>
                                            </div>
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-data">
                        <span class="material-symbols-outlined">task</span>
                        <p>No hay actividades asignadas actualmente.</p>
                    </div>
                @endforelse
            </div>
        @endif
    </div>

    @if ($confirmingActivityCreation)
        <div class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Registrar Nueva Actividad</h3>
                    <button wire:click="$set('confirmingActivityCreation', false)" class="close-btn">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Estudiante</label>
                        <select wire:model="apprentice_id" class="form-control">
                            <option value="">Seleccione estudiante...</option>
                            @foreach ($children as $child)
                                <option value="{{ $child->id }}">{{ $child->name }} {{ $child->apellido }}
                                </option>
                            @endforeach
                        </select>
                        @error('apprentice_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Título de la Actividad</label>
                        <input type="text" wire:model="titulo" class="form-control"
                            placeholder="Ej: Entrega de taller...">
                        @error('titulo')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Descripción / Observaciones</label>
                        <textarea wire:model="descripcion" class="form-control" rows="3"></textarea>
                        @error('descripcion')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Adjuntar Documento o Video (PDF/Video - Max 1GB)</label>
                        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">

                            <input type="file" wire:model="archivo" class="form-control"
                                accept=".pdf, .mp4, .mov, .avi, .wmv">

                            <div x-show="isUploading" style="margin-top: 5px;">
                                <progress max="100" x-bind:value="progress" style="width: 100%"></progress>
                                <span style="font-size: 0.8rem; color: #667eea;">Subiendo archivo...</span>
                            </div>
                        </div>
                        @error('archivo')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="$set('confirmingActivityCreation', false)"
                        class="btn-secondary">Cancelar</button>
                    <button wire:click="saveActivity" class="btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    @endif

    @if ($confirmingActivityAssignment)
        <div class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Asignar Actividad a Grupos</h3>
                    <button wire:click="$set('confirmingActivityAssignment', false)" class="close-btn">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Título de la Actividad</label>
                        <input type="text" wire:model="assign_titulo" class="form-control"
                            placeholder="Ej: Taller de refuerzo...">
                        @error('assign_titulo')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Grupos Destinatarios</label>
                        <div class="groups-checkbox-list">
                            @foreach ($groups as $group)
                                <label class="checkbox-item">
                                    <input type="checkbox" wire:model="assign_groups" value="{{ $group->id }}">
                                    <span>{{ $group->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('assign_groups')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Instrucciones / Observaciones</label>
                        <textarea wire:model="assign_descripcion" class="form-control" rows="4"></textarea>
                        @error('assign_descripcion')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Adjuntar Guía / Material / Video (Opcional - Max 1GB)</label>
                        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">

                            <input type="file" wire:model="assign_archivo" class="form-control"
                                accept=".pdf, .mp4, .mov, .avi, .wmv" wire:loading.attr="disabled">

                            <div x-show="isUploading" style="margin-top: 5px;">
                                <progress max="100" x-bind:value="progress" style="width: 100%"></progress>
                                <span style="font-size: 0.8rem; color: #667eea;">Subiendo archivo...</span>
                            </div>
                        </div>
                        @error('assign_archivo')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="$set('confirmingActivityAssignment', false)"
                        class="btn-secondary">Cancelar</button>
                    <button wire:click="saveAssignedActivity" class="btn-primary">Asignar Actividad</button>
                </div>
            </div>
        </div>
    @endif

    <style>
        .tabs-navigation {
            display: flex;
            background: #f1f5f9;
            padding: 4px;
            border-radius: 12px;
            gap: 4px;
        }

        .tab-btn {
            border: none;
            background: transparent;
            padding: 8px 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-weight: 600;
            color: #64748b;
            transition: all 0.2s;
        }

        .tab-btn.active {
            background: white;
            color: #05ccd1;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .btn-assign {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #6c5ce7;
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-assign:hover {
            background: #5849c4;
            transform: translateY(-2px);
        }

        .groups-checkbox-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            max-height: 150px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .assigned-card {
            border-left: 4px solid #6c5ce7;
        }

        .assigned-file {
            background: #f0eeff;
            border: 1px dashed #6c5ce7;
        }

        .group-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            background: #eee;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-left: 8px;
        }

        .staff-name {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
        }

        {{-- Existing styles --}}
    </style>
</div>
