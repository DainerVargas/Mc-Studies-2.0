<div class="componente">
    <div class="conteFiltro" id="conteFiltro">
        <form>
            <div class="conteInput">
                <label for="filtro">Filtra por el nombre del estudiante</label>
                <input type="text" wire:model.live="nameAprendiz" placeholder="Nombre del estudiantes">
            </div>
        </form>
        <div class="conteSelect">
            <div class="conteChecks">
                <div class="conteRadio">
                    <input wire:model.live="filter" value="null" type="radio" id="option1">
                    <label for="option">Todos</label>
                </div>
                <div class="conteRadio">
                    <input wire:model.live="filter" value="presente" type="radio" id="option1">
                    <label for="option1">Presente</label>
                </div>
                <div class="conteRadio">
                    <input wire:model.live="filter" value="ausente" type="radio" id="option2">
                    <label for="option2">Ausente</label>
                </div>
                <div class="conteRadio">
                    <input wire:model.live="filter" value="tarde" type="radio" id="option3">
                    <label for="option3">Tarde</label>
                </div>
            </div>
        </div>
        <div class="conteDate">
            <input type="date" name="date" wire:model.live="date">
        </div>
        <div class="conteSelect">
            <select wire:model.live="selectGrupo">
                <option value="all" selected>Todos los grupos</option>
                @foreach ($grupos as $grupo)
                    <option value="{{ $grupo->id }}">{{ $grupo->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if ($message)
        <p style="color: red" class="alert">{{ $message }}</p>
    @endif
    @if ($date == now()->format('Y-m-d') && empty($asistencias))
        <div class="containerConte">
            <div class="conteTable">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Estudiantes</th>
                            <th>Estado</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estudiantes as $index => $estudiante)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $estudiante->name }} {{ $estudiante->apellido }}</td>
                                <td>
                                    <div class="conteRadio">
                                        <div class="conteCheck">
                                            <input type="radio" checked wire:model="estado.{{ $estudiante->id }}"
                                                value="presente" id="presente-{{ $estudiante->id }}">
                                            <label for="presente-{{ $estudiante->id }}">Presente</label>
                                        </div>
                                        <div class="conteCheck">
                                            <input type="radio" wire:model="estado.{{ $estudiante->id }}"
                                                value="ausente" id="ausente-{{ $estudiante->id }}">
                                            <label for="ausente-{{ $estudiante->id }}">Ausente</label>
                                        </div>
                                        <div class="conteCheck">
                                            <input type="radio" wire:model="estado.{{ $estudiante->id }}"
                                                value="tarde" id="tarde-{{ $estudiante->id }}">
                                            <label for="tarde-{{ $estudiante->id }}">Tarde</label>
                                        </div>
                                        @error('estado.' . $estudiante->id)
                                            <small class="error" style="color: red">{{ $message }}</small>
                                        @enderror
                                        @error('estado.' . $estudiante->id)
                                            <small class="error" style="color: red">{{ $message }}</small>
                                        @enderror
                                        @error('estado.' . $estudiante->id)
                                            <small class="error" style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </td>
                                <td>
                                    <div class="flex">
                                        <textarea cols="35" rows="3" name="observaciones.{{ $estudiante->id }}" class="observacion"
                                            wire:model.defer="observaciones.{{ $selectGrupo }}.{{ $estudiante->id }}"></textarea>
                                        @error('observaciones.' . $estudiante->id)
                                            <small class="error" style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button class="buttonsave" wire:click="guardarAsistencia">Guardar Asistencia</button>
            </div>
        </div>
    @endif
    @if (!empty($asistencias))
        <div class="containerConte">
            <div class="conteTable">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Estudiantes</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($asistencias as $index => $asistencia)
                            <tr class="showAssistent">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $asistencia->apprentice->name }} {{ $asistencia->apprentice->apellido }}</td>
                                <td>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                                @php
                                    $color = '';
                                    if ($asistencia->estado == 'presente') {
                                        $color = 'green';
                                    } elseif ($asistencia->estado == 'ausente') {
                                        $color = 'orange';
                                    } elseif ($asistencia->estado == 'tarde') {
                                        $color = 'red';
                                    }

                                @endphp
                                <td style="color: {{ $color }}"">{{ $asistencia->estado }}</td>
                                <td>{{ $asistencia->observaciones ?? 'No tiene ninguna observacion' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <p class="nodatos">No hay datos</p>
                                    <video class="video" src="/videos/video2.mp4" height="180vw" autoplay loop>
                                        <source src="/videos/video2.mp4" type="">
                                    </video>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($selectGrupo != 'all' && $date)
                    <a href="{{ route('descargarAsistencias', ['date' => $date, 'grupo' => $selectGrupo]) }}">
                        <button class="buttonsave">Descargar Asistencia</button>
                    </a>
                @endif
            </div>
        </div>
    @endif
    @if ($date != now()->format('Y-m-d') && empty($asistencias))
        <div class="containerConte">
            <div class="conteTable">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Estudiantes</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($asistencias as $index => $asistencia)
                        @empty
                            <tr>
                                <td colspan="6">
                                    <p class="nodatos">No hay datos</p>
                                    <video class="video" src="/videos/video2.mp4" height="180vw" autoplay loop>
                                        <source src="/videos/video2.mp4" type="">
                                    </video>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
