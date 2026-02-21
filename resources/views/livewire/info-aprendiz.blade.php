<div class="info-aprendiz-container">
    <div class="header-premium">
        <div class="back-nav">
            <a href="{{ route('listaAprendiz') }}" class="btn-back">
                <img title="Volver" src="/images/atras.png" alt="Atrás">
            </a>
            <div class="avatar-wrapper">
                @if ($aprendiz->imagen)
                    <img class="perfil-img" src="{{ asset('users/' . $aprendiz->imagen) }}" alt="Perfil">
                @else
                    <img class="perfil-img" src="{{ asset('images/perfil.png') }}" alt="Perfil">
                @endif
            </div>
        </div>

        <div class="header-center">
            @php
                if ($aprendiz->group_id == null) {
                    $profesor = 'Sin profesor';
                } elseif ($aprendiz->group->teacher_id != null) {
                    $profesor = $aprendiz->group->teacher->name . ' ' . $aprendiz->group->teacher->apellido;
                } else {
                    $profesor = 'Sin profesor';
                }
            @endphp
            <h2>Profesor: <span>{{ $profesor }}</span></h2>
        </div>

        @if ($user->rol_id != 4 && $user->rol_id != 5)
            <div class="status-control">
                <div class="status-indicator {{ $aprendiz->estado == 1 ? 'active' : 'inactive' }}">
                    {{ $aprendiz->estado == 1 ? 'Activo' : 'Inactivo' }}
                </div>
                <button wire:click="toggleEstado"
                    wire:confirm="¿Quieres {{ $aprendiz->estado == 1 ? 'deshabilitar' : 'habilitar' }} al aprendiz: {{ $aprendiz->name }}?"
                    class="toggle-switch {{ $aprendiz->estado == 1 ? 'active' : '' }}">
                </button>
            </div>
        @else
            <div></div>
        @endif
    </div>

    <div class="main-grid">
        <!-- Sidebar Profile -->
        <div class="profile-side">
            <div class="info-card summary-box">
                <p class="full-name">{{ $aprendiz->name }} {{ $aprendiz->apellido }}</p>
                <div class="modality-badge">{{ $aprendiz->modality->name }}</div>

                <div class="actions-grid">
                    @php
                        $hasGroup = $aprendiz->group_id != null;
                    @endphp

                    <div title="{{ $hasGroup ? $aprendiz->group->name : 'Sin Grupo' }}"
                        class="btn-icon {{ $hasGroup ? 'active' : '' }}">
                        <span class="material-symbols-outlined">group</span>
                    </div>

                    <div title="Visualizar comprobante de pago" wire:click="show(1)" class="btn-icon">
                        <span class="material-symbols-outlined">visibility</span>
                    </div>

                    <a href="{{ route('donwload', $aprendiz->id) }}" class="btn-icon" title="Descargar documento">
                        <span class="material-symbols-outlined">download</span>
                    </a>

                    <div title="Ver calificaciones" wire:click="showQualification" class="btn-icon">
                        <span class="material-symbols-outlined">rewarded_ads</span>
                    </div>

                    @if ($user->rol_id != 5)
                        <div title="Certificado" wire:click="showCertificate" class="btn-icon">
                            <span class="material-symbols-outlined">license</span>
                        </div>
                    @endif

                    <div title="Ver asistencias" wire:click="showAttendance" class="btn-icon">
                        <span class="material-symbols-outlined">calendar_month</span>
                    </div>
                </div>

                @if ($valor == 1 && (!$aprendiz->comprobante || $aprendiz->comprobante == 'Sin comprobante'))
                    <small style="color: #ff4757; font-weight: 500;">No hay comprobante de pago</small>
                @endif

                <div class="status-row">
                    <span>Estatus:</span>
                    <div class="badge {{ $aprendiz->estado == 0 ? 'inactive' : 'active' }}">
                        {{ $aprendiz->estado == 0 ? 'Inactive' : 'Active' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Details Section -->
        <div class="details-content">
            <div class="info-card">
                <div class="card-header">
                    <h3>Información Personal</h3>
                </div>
                <div class="data-group">
                    <div class="data-item">
                        <label>Nombre Completo</label>
                        <span>{{ $aprendiz->name }} {{ $aprendiz->apellido }}</span>
                    </div>
                    <div class="data-item">
                        <label>Edad</label>
                        <span>{{ $edadActualizada }} años</span>
                    </div>
                    <div class="data-item">
                        <label>Fecha de Nacimiento</label>
                        <span>{{ $aprendiz->fecha_nacimiento->format('d/m/Y') }}</span>
                    </div>
                    <div class="data-item">
                        <label>Dirección</label>
                        <span>{{ $aprendiz->direccion ?: 'No registrada' }}</span>
                    </div>
                    <div class="data-item">
                        <label>Sede</label>
                        <span>{{ $aprendiz->sede->sede }}</span>
                    </div>
                    @if ($aprendiz->edad > 17)
                        <div class="data-item">
                            <label>Documento</label>
                            <span>{{ $aprendiz->documento ?? 'No registrado' }}</span>
                        </div>
                    @endif
                    <div class="data-item">
                        <label>Fecha de Inicio</label>
                        <span>{{ $aprendiz->fecha_inicio }}</span>
                    </div>
                    <div class="data-item">
                        <label>Finalización</label>
                        <span>{{ $aprendiz->fecha_fin }}</span>
                    </div>
                </div>
            </div>

            <div class="info-card attendant-section">
                <div class="card-header">
                    <h3>Información del Acudiente</h3>
                </div>
                <div class="data-group">
                    <div class="data-item">
                        <label>Nombre</label>
                        <span>{{ $aprendiz->attendant->name ?? 'N/A' }}
                            {{ $aprendiz->attendant->apellido ?? '' }}</span>
                    </div>
                    <div class="data-item">
                        <label>Email</label>
                        <span>{{ $aprendiz->attendant->email ?? 'N/A' }}</span>
                    </div>
                    <div class="data-item">
                        <label>Teléfono</label>
                        <span>{{ $aprendiz->attendant->telefono ?? 'N/A' }}</span>
                    </div>
                    @if ($aprendiz->edad < 18)
                        <div class="data-item">
                            <label>Documento</label>
                            <span>{{ $aprendiz->attendant->documento ?? 'No registrado' }}</span>
                        </div>
                    @endif
                </div>

                @if ($user->rol_id == 1)
                    <a href="{{ route('viewUpdate', $aprendiz->id) }}" style="text-decoration: none;">
                        <button class="btn-update">
                            <span>Ir a Actualizar</span>
                            <span class="material-symbols-outlined">directions_run</span>
                        </button>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Modals -->
    @if ($valor > 0 && ($aprendiz->comprobante && $aprendiz->comprobante != 'Sin comprobante'))
        <div class="receipt-viewer">
            <img src="/users/{{ $aprendiz->comprobante }}" alt="Comprobante">
            <div class="viewer-actions">
                <span wire:click="show(0)" class="material-symbols-outlined" title="Cerrar">close</span>
                <a href="/users/{{ $aprendiz->comprobante }}" download="">
                    <span class="material-symbols-outlined" title="Descargar">download</span>
                </a>
            </div>
        </div>
    @endif

    @if ($view)
        <div class="custom-modal-overlay">
            <div class="modal-body">
                <div class="close-icon" wire:click="showQualification">
                    <span class="material-symbols-outlined">close</span>
                </div>
                <h4>Calificaciones del Aprendiz</h4>

                <div class="ql-filters-modal"
                    style="margin-bottom: 20px; background: #f8fafc; padding: 15px; border-radius: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="ql-filter-group">
                        <label
                            style="font-size: 0.75rem; font-weight: 700; color: #475569; display: block; margin-bottom: 5px;">AÑO</label>
                        <select wire:model.live="selectedYear"
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; background: white; font-weight: 600;">
                            @for ($i = date('Y'); $i >= 2023; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="ql-filter-group">
                        <label
                            style="font-size: 0.75rem; font-weight: 700; color: #475569; display: block; margin-bottom: 5px;">SEMESTRE</label>
                        <select wire:model.live="selectedSemester"
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; background: white; font-weight: 600;">
                            <option value="">Todos los semestres</option>
                            <option value="1">Semestre 1</option>
                            <option value="2">Semestre 2</option>
                        </select>
                    </div>
                </div>

                @if (session()->has('error_modal'))
                    <div
                        style="background: #fef2f2; color: #b91c1c; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 0.85rem; border: 1px solid #fecaca; text-align: center;">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error_modal') }}
                    </div>
                @endif

                <div class="modern-table-wrapper" style="max-height: 300px; overflow-y: auto;">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Periodo</th>
                                <th>Listening</th>
                                <th>Reading</th>
                                <th>Speaking</th>
                                <th>Writing</th>
                                <th>Promedio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalListening = 0;
                                $totalReading = 0;
                                $totalSpeaking = 0;
                                $totalWriting = 0;
                                $count = $qualifications->count();
                            @endphp

                            @forelse ($qualifications as $qualification)
                                @php
                                    $promedioFila =
                                        ($qualification->listening +
                                            $qualification->reading +
                                            $qualification->speaking +
                                            $qualification->writing) /
                                        4;
                                    $totalListening += $qualification->listening;
                                    $totalReading += $qualification->reading;
                                    $totalSpeaking += $qualification->speaking;
                                    $totalWriting += $qualification->writing;

                                    $resLabel = match ($qualification->resultado) {
                                        '1' => 'Resultado 1',
                                        '2' => 'Resultado 2',
                                        '3' => 'Resultado 3',
                                        default => 'Resultado ' . $qualification->resultado,
                                    };
                                @endphp
                                <tr>
                                    <td>{{ $resLabel }}</td>
                                    <td>{{ number_format($qualification->listening, 1) }}</td>
                                    <td>{{ number_format($qualification->reading, 1) }}</td>
                                    <td>{{ number_format($qualification->speaking, 1) }}</td>
                                    <td>{{ number_format($qualification->writing, 1) }}</td>
                                    <td
                                        style="font-weight: bold; color: {{ $promedioFila >= 75 ? '#166534' : '#b91c1c' }}">
                                        {{ number_format($promedioFila, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        style="padding: 30px; text-align: center; color: #94a3b8; font-style: italic;">
                                        No se encontraron calificaciones para los filtros seleccionados.
                                    </td>
                                </tr>
                            @endforelse

                            @if ($count > 1)
                                <tr class="total-row" style="background: #f0fdf4; font-weight: bold;">
                                    <td>PROM. GLOBAL</td>
                                    <td>{{ number_format($totalListening / $count, 1) }}</td>
                                    <td>{{ number_format($totalReading / $count, 1) }}</td>
                                    <td>{{ number_format($totalSpeaking / $count, 1) }}</td>
                                    <td>{{ number_format($totalWriting / $count, 1) }}</td>
                                    <td style="color: #166534;">
                                        {{ number_format(($totalListening + $totalReading + $totalSpeaking + $totalWriting) / ($count * 4), 2) }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button class="btn-primary" wire:click="sendQualification">
                        <span class="material-symbols-outlined">send</span> Enviar
                    </button>
                    <button class="btn-secondary" wire:click="donwloadQualification">
                        <span class="material-symbols-outlined">download</span> Descargar
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($viewCertificate)
        <div class="custom-modal-overlay certificate-modal">
            <div class="modal-body">
                <div class="close-icon" wire:click="showCertificate">
                    <span class="material-symbols-outlined">close</span>
                </div>
                <h4>Generar Reconocimiento</h4>

                <div class="flex">
                    <textarea wire:model="textReconocimiento"
                        placeholder="Escribe aquí el motivo del reconocimiento o logro alcanzado..."></textarea>
                </div>

                @error('textReconocimiento')
                    <p class="error" style="color: #ff4757; font-weight: 600; margin-bottom: 20px; font-size: 0.9rem;">
                        {{ $message }}</p>
                @enderror

                <button class="btn-generate" wire:click="generateCertificate">
                    Generar Certificado Oficial
                </button>
            </div>
        </div>
    @endif

    <!-- Attendance Modal -->
    @if ($viewAttendance)
        <div class="custom-modal-overlay">
            <div class="modal-body" style="max-width: 600px;">
                <div class="close-icon" wire:click="showAttendance">
                    <span class="material-symbols-outlined">close</span>
                </div>
                <h4>Asistencias de {{ $aprendiz->name }}</h4>

                <div class="ql-filters-modal"
                    style="margin-bottom: 20px; background: #f8fafc; padding: 15px; border-radius: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="ql-filter-group">
                        <label
                            style="font-size: 0.75rem; font-weight: 700; color: #475569; display: block; margin-bottom: 5px;">AÑO</label>
                        <select wire:model.live="attendanceYear"
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; background: white; font-weight: 600;">
                            @for ($i = date('Y'); $i >= 2023; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="ql-filter-group">
                        <label
                            style="font-size: 0.75rem; font-weight: 700; color: #475569; display: block; margin-bottom: 5px;">ESTADO</label>
                        <select wire:model.live="attendanceStatus"
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; background: white; font-weight: 600;">
                            <option value="">Todas</option>
                            <option value="Presente">Presente</option>
                            <option value="Ausente">Ausente</option>
                            <option value="Tarde">Tarde</option>
                        </select>
                    </div>
                </div>

                <div class="modern-table-wrapper" style="max-height: 400px; overflow-y: auto;">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendances as $asistencia)
                                <tr>
                                    <td style="font-weight: 600; color: #334155;">
                                        {{ Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        @php
                                            $statusColor = match ($asistencia->estado) {
                                                'Presente' => '#166534',
                                                'Ausente' => '#b91c1c',
                                                'Tarde' => '#c2410c',
                                                default => '#475569',
                                            };
                                            $statusBg = match ($asistencia->estado) {
                                                'presente' => '#f0fdf4',
                                                'ausente' => '#fef2f2',
                                                'tarde' => '#fff7ed',
                                                default => '#f8fafc',
                                            };
                                        @endphp
                                        <span
                                            style="padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; background: {{ $statusBg }}; color: {{ $statusColor }}; border: 1px solid {{ $statusColor }}33;">
                                            {{ $asistencia->estado }}
                                        </span>
                                    </td>
                                    <td style="font-size: 0.85rem; color: #64748b;">
                                        {{ $asistencia->observaciones ?: 'Sin observaciones' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        style="padding: 40px; text-align: center; color: #94a3b8; font-style: italic;">
                                        <div
                                            style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                            <span class="material-symbols-outlined"
                                                style="font-size: 48px;">event_busy</span>
                                            No se encontraron registros de asistencia.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer" style="justify-content: center;">
                    <button class="btn-secondary" wire:click="showAttendance" style="width: 100%; max-width: 200px;">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
