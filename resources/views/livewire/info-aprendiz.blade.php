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

                <div class="modern-table-wrapper">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Resultado</th>
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

                                    $resultado = match ($qualification->semestre) {
                                        1 => 'Resultado 1',
                                        2 => 'Resultado 2',
                                        3 => 'Resultado 3',
                                        default => 'Resultado',
                                    };
                                @endphp
                                <tr>
                                    <td>{{ $resultado }}</td>
                                    <td>{{ $qualification->listening }}</td>
                                    <td>{{ $qualification->reading }}</td>
                                    <td>{{ $qualification->speaking }}</td>
                                    <td>{{ $qualification->writing }}</td>
                                    <td>{{ number_format($promedioFila, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding: 30px;">Sin resultados registrados</td>
                                </tr>
                            @endforelse

                            @if ($count > 0)
                                <tr class="total-row">
                                    <td>Promedio Global</td>
                                    <td>{{ number_format($totalListening / $count, 2) }}</td>
                                    <td>{{ number_format($totalReading / $count, 2) }}</td>
                                    <td>{{ number_format($totalSpeaking / $count, 2) }}</td>
                                    <td>{{ number_format($totalWriting / $count, 2) }}</td>
                                    <td>{{ number_format(($totalListening + $totalReading + $totalSpeaking + $totalWriting) / ($count * 4), 2) }}
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
</div>
