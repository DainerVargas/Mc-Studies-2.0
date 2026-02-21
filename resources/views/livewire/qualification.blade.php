<div style="width: 100%;">
    @vite(['resources/sass/qualification-premium.scss'])

    <div class="ql-container">
        <div class="ql-header">
            <h1 class="ql-title">Registro de Calificaciones</h1>
            <p class="ql-subtitle">Gestiona el progreso académico de tus estudiantes</p>
        </div>

        <!-- Filtros -->
        <div class="ql-filters-card">
            <div class="ql-filters-grid">
                <div class="ql-filter-group">
                    <label for="year" class="ql-label">Año</label>
                    <select wire:model.live="selectedYear" id="year" class="ql-select">
                        @for ($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="ql-filter-group">
                    <label for="group" class="ql-label">Grupo</label>
                    <select wire:model.live="selectedGroup" id="group" class="ql-select">
                        <option value="">Seleccione un grupo...</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="ql-filter-group">
                    <label for="semester" class="ql-label">Semestre</label>
                    <select wire:model.live="selectedSemester" id="semester" class="ql-select">
                        <option value="" selected hidden>Seleccione semestre...</option>
                        <option value="1">Semestre 1</option>
                        <option value="2">Semestre 2</option>
                    </select>
                </div>

                <div class="ql-filter-group">
                    <label for="result" class="ql-label">Resultado / Periodo</label>
                    <select wire:model.live="selectedResult" id="result" class="ql-select">
                        <option value="" selected hidden>Seleccione resultado...</option>
                        <option value="1">Primer Resultado</option>
                        <option value="2">Segundo Resultado</option>
                        <option value="3">Tercer Resultado</option>
                        <option value="final">Resultado Final</option>
                    </select>
                </div>

            </div>
        </div>

        @if (session()->has('message'))
            <div class="ql-alert ql-alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="ql-alert ql-alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabla de Calificaciones -->
        <div class="ql-table-container">
            <table class="ql-table">
                <thead>
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Estudiante</th>
                        <th colspan="4" class="ql-center">Habilidades (0-100)</th>
                        <th colspan="2" class="ql-center">Actividades</th>
                        <th colspan="2" class="ql-center">Worksheets</th>
                        <th rowspan="2">Observación</th>
                        <th rowspan="2">Reporte</th>
                    </tr>
                    <tr>
                        <th>Listen.</th>
                        <th>Write.</th>
                        <th>Read.</th>
                        <th>Speak.</th>
                        <th>Asig.</th>
                        <th>Ent.</th>
                        <th>Asig.</th>
                        <th>Ent.</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $student)
                        <tr
                            wire:key="student-{{ $student->id }}-{{ $selectedYear }}-{{ $selectedSemester }}-{{ $selectedResult }}">
                            <td class="ql-index">{{ $index + 1 }}</td>
                            <td class="ql-student-name">
                                {{ $student->name }} {{ $student->apellido }}
                            </td>
                            <td>
                                <input placeholder="Nota" type="number"
                                    wire:model.blur="listening.{{ $student->id }}" class="ql-input-number"
                                    min="0" max="100" @if (!$isAdmin && $selectedResult === 'final') disabled @endif>
                                @error("listening.{$student->id}")
                                    <span class="ql-error-tip">Req.</span>
                                @enderror
                            </td>
                            <td>
                                <input placeholder="Nota" type="number" wire:model.blur="writing.{{ $student->id }}"
                                    class="ql-input-number" min="0" max="100"
                                    @if (!$isAdmin && $selectedResult === 'final') disabled @endif>
                                @error("writing.{$student->id}")
                                    <span class="ql-error-tip">Req.</span>
                                @enderror
                            </td>
                            <td>
                                <input placeholder="Nota" type="number" wire:model.blur="reading.{{ $student->id }}"
                                    class="ql-input-number" min="0" max="100"
                                    @if (!$isAdmin && $selectedResult === 'final') disabled @endif>
                                @error("reading.{$student->id}")
                                    <span class="ql-error-tip">Req.</span>
                                @enderror
                            </td>
                            <td>
                                <input placeholder="Nota" type="number" wire:model.blur="speaking.{{ $student->id }}"
                                    class="ql-input-number" min="0" max="100"
                                    @if (!$isAdmin && $selectedResult === 'final') disabled @endif>
                                @error("speaking.{$student->id}")
                                    <span class="ql-error-tip">Error</span>
                                @enderror
                            </td>
                            <td>
                                <input type="number" wire:model.blur="actividades_asignados.{{ $student->id }}"
                                    class="ql-input-count" placeholder="0"
                                    @if (!$isAdmin && $selectedResult === 'final') disabled @endif>
                                @error("actividades_asignados.{$student->id}")
                                    <span class="ql-error-tip">!</span>
                                @enderror
                            </td>
                            <td>
                                <input type="number" wire:model.blur="actividades_entregados.{{ $student->id }}"
                                    class="ql-input-count" placeholder="0"
                                    @if (!$isAdmin && $selectedResult === 'final') disabled @endif>
                                @error("actividades_entregados.{$student->id}")
                                    <span class="ql-error-tip">!</span>
                                @enderror
                            </td>
                            <td>
                                <input type="number" wire:model.blur="worksheet_asignados.{{ $student->id }}"
                                    class="ql-input-count" placeholder="0"
                                    @if (!$isAdmin && $selectedResult === 'final') disabled @endif>
                                @error("worksheet_asignados.{$student->id}")
                                    <span class="ql-error-tip">!</span>
                                @enderror
                            </td>
                            <td>
                                <input type="number" wire:model.blur="worksheet_entregados.{{ $student->id }}"
                                    class="ql-input-count" placeholder="0"
                                    @if (!$isAdmin && $selectedResult === 'final') disabled @endif>
                                @error("worksheet_entregados.{$student->id}")
                                    <span class="ql-error-tip">!</span>
                                @enderror
                            </td>
                            <td>
                                <textarea wire:model.blur="observaciones.{{ $student->id }}" class="ql-textarea" placeholder="Sin observaciones..."
                                    @if (!$isAdmin && $selectedResult === 'final') disabled @endif></textarea>
                                @error("observaciones.{$student->id}")
                                    <span class="ql-error-tip">!</span>
                                @enderror
                            </td>
                            <td class="ql-center">
                                <button wire:click="download({{ $student->id }})" class="ql-btn ql-btn-download">
                                    Descargar PDF
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="ql-empty">
                                @if (!$selectedGroup)
                                    Seleccione un grupo para cargar los estudiantes.
                                @else
                                    No hay estudiantes registrados en este grupo.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (count($students) > 0)
            <div class="ql-actions">
                <button wire:click="guardarNotas" class="ql-btn ql-btn-save">
                    <div wire:loading.remove wire:target="guardarNotas">
                        <i class="fas @if ($exists) fa-sync-alt @else fa-save @endif"></i>
                        @if ($exists)
                            Actualizar Calificaciones
                        @else
                            Guardar Calificaciones
                        @endif
                    </div>
                    <div wire:loading wire:target="guardarNotas">
                        <i class="fas fa-spinner fa-spin"></i> Procesando...
                    </div>
                </button>
                <button wire:click="descargarGrupo" class="ql-btn ql-btn-secondary">
                    <i class="fas fa-users"></i> Informe Grupal
                </button>
            </div>
        @endif
    </div>
</div>
