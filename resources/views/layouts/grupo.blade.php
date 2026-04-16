@extends('Dashboard')
@section('title', 'Crear Grupo')

@section('grupo')
    <div class="gc-container">
        @if (session('success'))
            <div class="alert alert-success"
                style="background: #e6fffa; color: #2c7a7b; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #b2f5ea;">
                {{ session('success') }}
            </div>
        @endif

        <div class="gc-filters-card">
            <div class="gc-filter-header">
                <div class="gc-filter-title">
                    <span class="material-symbols-outlined">filter_list</span>
                    Gestión de Grupos
                </div>
            </div>

            <div class="gc-filter-content">
                <form action="{{ route('grupo') }}" method="GET" style="display: flex; gap: 2rem; width: 100%; align-items: flex-end;">
                    <div class="gc-input-group" style="flex: 1;">
                        <label for="filtro">Filtra por el nombre del Grupo</label>
                        <input type="text" name="search" value="{{ $filtroName }}" placeholder="Buscar por nombre..." onchange="this.form.submit()">
                    </div>

                    <div class="gc-select-group">
                        <div class="gc-segmented-control">
                            <div class="gc-segmented-item">
                                <input name="estado" value="" type="radio" id="option1" {{ $estado == '' ? 'checked' : '' }} onchange="this.form.submit()">
                                <label for="option1">Todos</label>
                            </div>
                            <div class="gc-segmented-item">
                                <input name="estado" value="active" type="radio" id="option2" {{ $estado == 'active' ? 'checked' : '' }} onchange="this.form.submit()">
                                <label for="option2">Mc-Kids</label>
                            </div>
                            <div class="gc-segmented-item">
                                <input name="estado" value="inactive" type="radio" id="option3" {{ $estado == 'inactive' ? 'checked' : '' }} onchange="this.form.submit()">
                                <label for="option3">Mc-Teens</label>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="gc-create-action">
                    <button onclick="document.getElementById('modalCreate').style.display='flex'">
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
                                <td style="cursor: pointer" class="relative">
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
                                        <button type="button" class="update" 
                                            onclick="openEditModal({{ $grupo->id }}, '{{ $grupo->name }}', {{ $grupo->teacher_id ?? 'null' }}, {{ json_encode($grupo->tutors->pluck('id')) }})">
                                            <span class="material-symbols-outlined">edit</span> Editar
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex">
                                        @if (auth()->user()->rol_id == 1)
                                            <form action="{{ route('grupo.destroy', $grupo->id) }}" method="POST" onsubmit="return confirm('¿Desea eliminar el grupo {{ $grupo->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete">
                                                    <span class="material-symbols-outlined">delete</span> Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="nodatos">
                                        <p>No hay datos disponibles</p>
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

        <!-- Create Modal -->
        <div id="modalCreate" class="gc-modal-overlay" style="display: none;">
            <div class="gc-modal-card">
                <button class="gc-modal-close" onclick="document.getElementById('modalCreate').style.display='none'" title="Cerrar">
                    <span class="material-symbols-outlined">close</span>
                </button>
                <div class="gc-modal-header">
                    <h1>NUEVO GRUPO</h1>
                </div>
                <form action="{{ route('grupo.store') }}" method="POST">
                    @csrf
                    <div class="gc-form-grid">
                        <div class="gc-form-row">
                            <div class="gc-input-group">
                                <label class="label">Seleccionar Profesor</label>
                                <select name="teacher_id" required>
                                    <option value="">Seleccione...</option>
                                    @foreach ($profesores as $profesor)
                                        @if ($profesor->type_teacher_id == 1 || $profesor->type_teacher_id == 2)
                                            <option value="{{ $profesor->id }}">{{ $profesor->name }} - {{ $profesor->type_teacher->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="gc-input-group">
                                <label class="label">Nombre del Grupo</label>
                                <input name="name" type="text" placeholder="Ej: Nivel 1 - A" required>
                            </div>
                        </div>
                        <div class="gc-form-row">
                            <div class="gc-input-group">
                                <label class="label">Tipo de Grupo</label>
                                <select name="type_id" required>
                                    <option value="" selected hidden>Seleccione el tipo...</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="gc-form-row">
                            <div class="gc-input-group full-width">
                                <label class="label">Asignar Tutores (Opcional)</label>
                                <div class="tutors-selection-grid">
                                    @foreach ($allTutors as $tutor)
                                        <div class="tutor-checkbox-item">
                                            <input type="checkbox" name="tutor_ids[]" id="tutor_{{ $tutor->id }}" value="{{ $tutor->id }}">
                                            <label for="tutor_{{ $tutor->id }}">{{ $tutor->name }} {{ $tutor->apellido }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gc-modal-footer">
                        <button type="button" class="gc-btn-cancel" onclick="document.getElementById('modalCreate').style.display='none'">Cancelar</button>
                        <button type="submit" class="gc-btn-save">Registrar Grupo</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="modalEdit" class="gc-modal-overlay" style="display: none;">
            <div class="gc-modal-card">
                <button class="gc-modal-close" onclick="document.getElementById('modalEdit').style.display='none'" title="Cerrar">
                    <span class="material-symbols-outlined">close</span>
                </button>
                <div class="gc-modal-header">
                    <h1>ACTUALIZAR GRUPO</h1>
                </div>
                <form id="formEdit" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="gc-form-grid">
                        <div class="gc-input-group">
                            <label class="label">Nombre del Grupo</label>
                            <input id="edit_name" name="name" type="text" placeholder="Nombre del grupo" required>
                        </div>
                        <div class="gc-input-group">
                            <label class="label">Profesor Asignado</label>
                            <select id="edit_teacher_id" name="teacher_id" required>
                                <option value="">Seleccione...</option>
                                @foreach ($profesores as $profesor)
                                    <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="gc-input-group full-width">
                            <label class="label">Actualizar Tutores Asignados</label>
                            <div class="tutors-selection-grid">
                                @foreach ($allTutors as $tutor)
                                    <div class="tutor-checkbox-item">
                                        <input type="checkbox" name="tutor_ids[]" id="edit_tutor_{{ $tutor->id }}" value="{{ $tutor->id }}">
                                        <label for="edit_tutor_{{ $tutor->id }}">{{ $tutor->name }} {{ $tutor->apellido }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="gc-modal-footer">
                        <button type="button" class="gc-btn-cancel" onclick="document.getElementById('modalEdit').style.display='none'">Cancelar</button>
                        <button type="submit" class="gc-btn-update">Actualizar Grupo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(id, name, teacherId, tutorIds) {
            const modal = document.getElementById('modalEdit');
            const form = document.getElementById('formEdit');
            form.action = `/Crear-grupo/${id}`;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_teacher_id').value = teacherId;

            // Reset checkboxes
            document.querySelectorAll('#modalEdit input[type="checkbox"]').forEach(cb => cb.checked = false);
            
            // Set tutor checkboxes
            tutorIds.forEach(id => {
                const cb = document.getElementById(`edit_tutor_${id}`);
                if (cb) cb.checked = true;
            });

            modal.style.display = 'flex';
        }
    </script>
@endsection