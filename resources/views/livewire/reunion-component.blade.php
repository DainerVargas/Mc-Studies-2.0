<div class="reunion-container">
    <div class="header-section">
        <h2>
            @if (Auth::user()->attendant)
                Reuniones Programadas
            @else
                Gestión de Reuniones
            @endif
        </h2>
        @if (Auth::user()->attendant)
            <button wire:click="createMeeting" class="btn-create">
                <span class="material-symbols-outlined">add</span>
                Solicitar Reunión
            </button>
        @endif
    </div>

    {{-- Audio Player for Notifications --}}
    @if (session()->has('status_updated'))
        <audio autoplay>
            <source src="{{ asset('audios/universfield-new-notification-031-480569.mp3') }}" type="audio/mpeg">
        </audio>
    @endif

    @if (session()->has('new_meeting'))
        <audio autoplay>
            <source src="{{ asset('audios/universfield-new-notification-09-352705.mp3') }}" type="audio/mpeg">
        </audio>
    @endif

    <div class="meetings-list">
        @if (!Auth::user()->attendant)

            {{-- Admin Filter --}}
            <div class="filter-section">
                <select wire:model.live="filterStatus" class="modern-filter-select">
                    <option value="">Todos los Estados</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="confirmada">Confirmada</option>
                    <option value="cancelada">Cancelada</option>
                    <option value="completada">Completada</option>
                </select>
            </div>

            {{-- Admin Table View --}}
            <div class="table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Acudiente / Estudiante</th>
                            <th>Hijo(s)</th>
                            <th>Fecha y Hora</th>
                            <th>Tema</th>
                            <th>Estado</th>
                            <th>Link de Reunión</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($meetings as $meeting)
                            <tr class="row-{{ $meeting->estado }}">
                                <td>
                                    @if ($meeting->attendant)
                                        <div class="attendant-info">
                                            <strong>{{ $meeting->attendant->name }}
                                                {{ $meeting->attendant->apellido }}</strong>
                                        </div>
                                    @else
                                        <span class="text-muted">Desconocido</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($meeting->attendant && $meeting->attendant->apprentice->isNotEmpty())
                                        @foreach ($meeting->attendant->apprentice as $child)
                                            <span class="child-badge">{{ $child->name }}</span>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $meeting->fecha_programada->format('d/m/Y h:i A') }}</td>
                                <td>{{ $meeting->titulo }}</td>
                                <td>
                                    <span
                                        class="status-badge {{ $meeting->estado }}">{{ ucfirst($meeting->estado) }}</span>
                                </td>
                                <td>
                                    @if (in_array(Auth::user()->rol_id, [1, 2, 3]))
                                        <input type="text" value="{{ $meeting->link_reunion }}"
                                            wire:blur="updateLink({{ $meeting->id }}, $event.target.value)"
                                            placeholder="Pegar link aquí..." class="link-input">
                                    @else
                                        @if ($meeting->link_reunion)
                                            <a href="{{ $meeting->link_reunion }}" target="_blank"
                                                class="link-text">Ver Link</a>
                                        @else
                                            <span class="text-muted">Sin link</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <select wire:change="updateStatus({{ $meeting->id }}, $event.target.value)"
                                        class="status-select">
                                        <option value="pendiente"
                                            {{ $meeting->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="confirmada"
                                            {{ $meeting->estado == 'confirmada' ? 'selected' : '' }}>Aceptar</option>
                                        <option value="cancelada"
                                            {{ $meeting->estado == 'cancelada' ? 'selected' : '' }}>Cancelar</option>
                                        <option value="completada"
                                            {{ $meeting->estado == 'completada' ? 'selected' : '' }}>Completada
                                        </option>
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="no-data-cell">No hay solicitudes pendientes.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            {{-- Attendant Filter --}}
            <div class="filter-section">
                <select wire:model.live="filterStatus" class="modern-filter-select">
                    <option value="">Ver todas</option>
                    <option value="pendiente">Pendientes</option>
                    <option value="confirmada">Confirmadas</option>
                    <option value="cancelada">Canceladas</option>
                    <option value="completada">Completadas</option>
                </select>
            </div>

            {{-- Attendant Card View (Existing Logic) --}}
            @forelse ($meetings as $meeting)
                <div class="meeting-card {{ $meeting->estado }}">
                    <div class="meeting-header">
                        <h3>{{ $meeting->titulo }}</h3>
                        <span class="status-badge {{ $meeting->estado }}">{{ ucfirst($meeting->estado) }}</span>
                    </div>
                    <div class="meeting-body">
                        <p class="date">
                            <span class="material-symbols-outlined">calendar_today</span>
                            {{ $meeting->fecha_programada->format('d/m/Y h:i A') }}
                        </p>
                        @if ($meeting->descripcion)
                            <p class="description">{{ $meeting->descripcion }}</p>
                        @endif

                        @if ($meeting->link_reunion)
                            <div class="meeting-footer">
                                <a href="{{ $meeting->link_reunion }}" target="_blank" class="btn-join">
                                    <span class="material-symbols-outlined">video_call</span>
                                    Unirse a la Reunión
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="no-data">
                    <span class="material-symbols-outlined">event_busy</span>
                    <p>No tienes reuniones programadas.</p>
                </div>
            @endforelse
        @endif
    </div>

    @if ($confirmingMeetingCreation)
        <div class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Solicitar Nueva Reunión</h3>
                    <button wire:click="$set('confirmingMeetingCreation', false)" class="close-btn">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fecha Estimada</label>
                        <input type="date" wire:model.live="fecha_programada" class="form-control">
                        @error('fecha_programada')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    @if ($fecha_programada)
                        <div class="form-group">
                            <label>Hora de Atención</label>
                            <div class="radio-grid">
                                @php
                                    $slots = ['15:00', '15:30', '16:00', '16:30', '17:00', '17:30'];
                                @endphp
                                @foreach ($slots as $slot)
                                    @php
                                        $isDisabled = $this->isTimeSlotTaken($slot);
                                    @endphp
                                    <label class="radio-option {{ $isDisabled ? 'disabled-slot' : '' }}">
                                        <input type="radio" wire:model="hora_seleccionada"
                                            value="{{ $slot }}" {{ $isDisabled ? 'disabled' : '' }}>
                                        <span>{{ date('g:i A', strtotime($slot)) }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('hora_seleccionada')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <div class="form-group">
                        <label>Tema a Conversar</label>
                        <div class="radio-list">
                            @php
                                $temas = [
                                    'Acceso a Richmond',
                                    'Progreso de mi hij@',
                                    'Actividades de fin de semana',
                                    'Otro',
                                ];
                            @endphp
                            @foreach ($temas as $tema)
                                <label class="radio-item">
                                    <input type="radio" wire:model="titulo" value="{{ $tema }}">
                                    <span>{{ $tema }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('titulo')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    @if ($titulo === 'Otro')
                        <div class="form-group">
                            <label>Detalles Adicionales</label>
                            <textarea wire:model="descripcion" class="form-control" rows="3" placeholder="Especifique el tema..."></textarea>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button wire:click="$set('confirmingMeetingCreation', false)"
                        class="btn-secondary">Cancelar</button>
                    <button wire:click="saveMeeting" class="btn-primary">Solicitar</button>
                </div>
            </div>
        </div>
    @endif

    <style>
        .link-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .link-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .link-text {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }

        .link-text:hover {
            text-decoration: underline;
        }

        .meeting-footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: flex-end;
        }

        .btn-join {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-join:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
            filter: brightness(1.1);
            color: white;
        }

        .btn-join .material-symbols-outlined {
            font-size: 20px;
        }

        .row-pendiente {
            background-color: rgba(245, 158, 11, 0.02);
        }

        .row-confirmada {
            background-color: rgba(16, 185, 129, 0.02);
        }

        .row-cancelada {
            background-color: rgba(239, 68, 68, 0.02);
        }

        .row-completada {
            background-color: rgba(107, 114, 128, 0.02);
        }
    </style>
</div>
