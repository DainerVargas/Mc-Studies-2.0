<div class="componente">
    <div class="conteFiltro" id="conteFiltro">
        <form>
            <div class="conteInput">
                <label for="filtro">Estudiantes</label>
                <input type="text" wire:model.live="nameAprendiz" placeholder="Nombre del estudiantes">
            </div>
            <div class="mes">
                <select wire:model.live="semestre">
                    <option value="" hidden selected>Resultados</option>
                    <option value="1">Resultado 1</option>
                    <option value="2">Resultado 2</option>
                    <option value="3">Resultado 3</option>
                    <option value="4">Resultado Final</option>
                </select>
            </div>
            <div class="mes">
                <select wire:model.live="selectGrupo">
                    <option value="all" selected>Grupos</option>
                    @foreach ($grupos as $grupo)
                        <option value="{{ $grupo->id }}">{{ $grupo->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mes">
                <select wire:model.live="number">
                    <option value="" hidden selected>Semestre</option>
                    <option value="Primer">Semestre 1</option>
                    <option value="Segundo">Semestre 2</option>
                    <option value="Tercer">Semestre 3</option>
                    <option value="Final">Semestre Final</option>
                </select>
            </div>
        </form>
    </div>

    @if ($message)
        <p style="color: red" class="alert">{{ $message }}</p>
    @endif
    @if ($success)
        <p style="color: green" class="alert">{{ $success }}</p>
    @endif
    <p style="color: red" class="alert">{{ $messageSemestre }}</p>
    <div class="containerConte">
        <div class="conteTable">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Estudiante</th>
                        <th>Listening</th>
                        <th>Writing</th>
                        <th>Reading</th>
                        <th>Speaking</th>
                        <th>Observaciones</th>
                        <th>Descargar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estudiantes as $index => $estudiante)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $estudiante->name }} {{ $estudiante->apellido }}</td>

                            {{-- Listening --}}
                            <td>
                                <input placeholder="Nota" type="number" min="0" max="100"
                                    wire:model="listening.{{ $estudiante->id }}"
                                    @if (!$userEsAdmin && isset($estudiante->qualification[3]->listening)) disabled @endif>

                                @if (isset($erroresCampo["listening_{$estudiante->id}"]))
                                    <small style="color: red;">
                                        {{ $erroresCampo["listening_{$estudiante->id}"] }}
                                    </small>
                                @endif
                            </td>

                            {{-- Writing --}}
                            <td>
                                <input placeholder="Nota" type="number" min="0" max="100"
                                    wire:model="writing.{{ $estudiante->id }}"
                                    @if (!$userEsAdmin && isset($estudiante->qualification[3]->writing)) disabled @endif>

                                @if (isset($erroresCampo["writing_{$estudiante->id}"]))
                                    <small style="color: red;">
                                        {{ $erroresCampo["writing_{$estudiante->id}"] }}
                                    </small>
                                @endif
                            </td>

                            {{-- Reading --}}
                            <td>
                                <input placeholder="Nota" type="number" min="0" max="100"
                                    wire:model="reading.{{ $estudiante->id }}"
                                    @if (!$userEsAdmin && isset($estudiante->qualification[3]->reading)) disabled @endif>

                                @if (isset($erroresCampo["reading_{$estudiante->id}"]))
                                    <small style="color: red;">
                                        {{ $erroresCampo["reading_{$estudiante->id}"] }}
                                    </small>
                                @endif
                            </td>

                            {{-- Speaking --}}
                            <td>
                                <input placeholder="Nota" type="number" min="0" max="100"
                                    wire:model="speaking.{{ $estudiante->id }}"
                                    @if (!$userEsAdmin && isset($estudiante->qualification[3]->speaking)) disabled @endif>

                                @if (isset($erroresCampo["speaking_{$estudiante->id}"]))
                                    <small style="color: red;">
                                        {{ $erroresCampo["speaking_{$estudiante->id}"] }}
                                    </small>
                                @endif
                            </td>

                            <td>
                                @if (isset($speaking[$estudiante->id]))
                                    <div class="form-control" style="background-color: #f5f5f5;">
                                        {{ $observaciones[$selectGrupo][$estudiante->id] ?? 'No hay observacion' }}
                                    </div>
                                @else
                                    <textarea rows="2" cols="25" wire:model.defer="observaciones.{{ $selectGrupo }}.{{ $estudiante->id }}"
                                        class="form-control"></textarea>
                                @endif
                            </td>

                            <td>
                                <div class="flex">
                                    <button class="update"
                                        wire:click="download({{ $estudiante->id }})">Descargar</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($userEsAdmin)
                <div class="flex">
                    <button class="buttonsave" class="btn btn-success mt-3" wire:click="guardarNotas">
                        Actualizar
                    </button>
                    <button class="buttonsave" style="background-color: red; color: white; border: 1px solid red;" wire:click="deleteNotas" wire:confirm="¿Estás seguro que deseas eliminar estas notas?">
                        Eliminar
                    </button>1
                </div>
            @else
                <button class="buttonsave" class="btn btn-success mt-3" wire:click="guardarNotas">
                    Guardar calificaciones
                </button>
            @endif
        </div>
    </div>
</div>
