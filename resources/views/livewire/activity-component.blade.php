<div class="activity-container">
    <div class="header-section">
        <div class="header-content">
            <h2>Historial de Actividades</h2>

            <div class="filters-container">
                {{-- Search Filter --}}
                <div class="search-wrapper">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" wire:model.live="search" placeholder="Buscar actividad..."
                        class="modern-search-input">
                </div>

                {{-- Student Filter --}}
                @if ($children && count($children) > 1)
                    <div class="filter-wrapper">
                        <select wire:model.live="filterChild" class="modern-filter-select">
                            <option value="">Todos los estudiantes</option>
                            @foreach ($children as $child)
                                <option value="{{ $child->id }}">{{ $child->name }} {{ $child->apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <button wire:click="createActivity" class="btn-create">
                    <span class="material-symbols-outlined">upload_file</span>
                    <span class="btn-text">Registrar Actividad</span>
                </button>
            </div>
        </div>
    </div>

    <div class="scrollable-timeline-container">
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
                        </div>
                        <div class="content-card">
                            <div class="card-header">
                                <h3>{{ $activity->titulo }}</h3>
                                @if ($activity->created_at->diffInMinutes(now()) <= 10)
                                    <button wire:click="deleteActivity({{ $activity->id }})"
                                        wire:confirm="¿Estás seguro de que deseas eliminar esta actividad? Esta acción no se puede deshacer."
                                        class="btn-delete" title="Eliminar (Diponible por 10 min)">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                @endif
                            </div>
                            @if ($activity->descripcion)
                                <p class="description">{{ $activity->descripcion }}</p>
                            @endif
                            @if ($activity->archivo)
                                <a href="{{ asset('users/' . $activity->archivo) }}" target="_blank"
                                    class="file-attachment">
                                    <div class="file-icon">
                                        <span class="material-symbols-outlined">description</span>
                                    </div>
                                    <div class="file-info">
                                        <span class="filename">Ver Documento Adjunto</span>
                                        <span class="click-hint">Clic para descargar/ver</span>
                                    </div>
                                </a>
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
                    <button wire:click="loadMore" class="btn-load-more" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="loadMore">Cargar más actividades</span>
                        <span wire:loading wire:target="loadMore">Cargando...</span>
                        <span class="material-symbols-outlined" wire:loading.remove
                            wire:target="loadMore">expand_more</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <style>
        .scrollable-timeline-container {
            max-height: 70vh;
            /* Adjust height as needed */
            overflow-y: auto;
            padding-right: 10px;
            /* Space for scrollbar */
            margin-top: 20px;

            /* Custom Scrollbar */
            scrollbar-width: thin;
        }

        .scrollable-timeline-container::-webkit-scrollbar {
            width: 6px;
        }

        .scrollable-timeline-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .scrollable-timeline-container::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }

        .scrollable-timeline-container::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        .load-more-container {
            display: flex;
            justify-content: center;
            padding: 20px 0;
            margin-top: 10px;
        }

        .btn-load-more {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            background-color: #f8f9fa;
            border: 1px solid #e1e1e1;
            border-radius: 30px;
            color: #636e72;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .btn-load-more:hover {
            background-color: #fff;
            color: #05ccd1;
            border-color: #05ccd1;
            box-shadow: 0 4px 12px rgba(5, 204, 209, 0.2);
            transform: translateY(-2px);
        }

        .btn-load-more:active {
            transform: translateY(0);
        }

        .btn-load-more .material-symbols-outlined {
            font-size: 20px;
        }
    </style>

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
                            @if ($children)
                                @foreach ($children as $child)
                                    <option value="{{ $child->id }}">{{ $child->name }} {{ $child->apellido }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('apprentice_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Título de la Actividad</label>
                        <input type="text" wire:model="titulo" class="form-control"
                            placeholder="Ej: Entrega de taller, Justificación...">
                        @error('titulo')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Fecha input removed as it is auto-generated --}}
                    <div class="form-group">
                        <label>Descripción / Observaciones</label>
                        <textarea wire:model="descripcion" class="form-control" rows="3"></textarea>
                        @error('descripcion')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Adjuntar Documento/Evidencia</label>
                        <div class="file-upload-wrapper">
                            <input type="file" wire:model="archivo" id="file-upload" class="file-input">
                            <label for="file-upload" class="file-label">
                                <span class="material-symbols-outlined">cloud_upload</span>
                                <span>{{ $archivo ? $archivo->getClientOriginalName() : 'Seleccionar archivo...' }}</span>
                            </label>
                        </div>
                        @error('archivo')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <div wire:loading wire:target="archivo" class="uploading-text">Subiendo...</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="$set('confirmingActivityCreation', false)"
                        class="btn-secondary">Cancelar</button>
                    <button wire:click="saveActivity" class="btn-primary" wire:loading.attr="disabled">Guardar</button>
                </div>
            </div>
        </div>
    @endif
</div>
