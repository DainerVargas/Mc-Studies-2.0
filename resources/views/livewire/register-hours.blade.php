<div class="componente">
    <div class="conteFiltro" id="conteProfesor">
        <form wire:submit="filtrar">
            <div class="conteInput">
                <label for="filtro">Filtra por el nombre</label>
                <input type="text" wire:model.live="filtro" placeholder="Nombre">
            </div>
        </form>

        <div style="gap: 10px" class="conteBtnCreate">
            <a><button wire:click="show()" class="register">Registrar Horas</button></a>
        </div>
    </div>

    <div class="containerConte">
        <div class="conteTable">
            <table class="teacher">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Profesor</th>
                        <th>Horas</th>
                        <th>Monto</th>
                        <th>Fecha Inicial</th>
                        <th>Fecha Final</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @forelse ($registerHours as $registerHour)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td class="relative">
                                <div class="conteName">
                                    @if ($registerHour->teacher)
                                        <img src="/users/{{ $registerHour->teacher->image }}" alt="">
                                    @else
                                        <img src="/images/perfil.png" alt="">
                                    @endif
                                    <a href="{{ route('infoProfesor', $registerHour->teacher->id) }}">{{ $registerHour->teacher->name }}
                                        {{ $registerHour->teacher->apellido }}</a>
                                </div>
                            </td>
                            <td>
                                <p>{{ $registerHour->horas }}</p>
                            </td>
                            <td>
                                <p>{{ number_format($registerHour->horas * $registerHour->teacher->precio_hora) }}</p>
                            </td>
                            <td>
                                <p>{{ $registerHour->fecha }}</p>
                            </td>
                            <td>
                                <p>{{ $registerHour->updated_at }}</p>
                            </td>
                            <td>
                                <div class="flex">
                                    <a><button wire:click="show({{ $registerHour->id }})" class="update">
                                            <span class="material-symbols-outlined">
                                                edit
                                            </span> Editar
                                        </button>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="flex">
                                    <button class="delete" wire:click="delete({{ $registerHour->teacher->id }})"
                                        wire:confirm="¿Desea elimiar el?">
                                        <span class="material-symbols-outlined">
                                            delete
                                        </span>Eliminar</button>
                                </div>
                            </td>
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
        </div>
    </div>

    @if ($view != 0)
        <div class="conteUpdate">
            <div class="close">
                <span wire:click="show()" title="Cerrar" class="material-symbols-outlined">
                    close
                </span>
            </div>
            <form wire:submit="">
                <div class="conteImage">
                    <h1 style="color: #99BF51">Registro de horas</h1>
                </div>
                <div class="containerContent">
                    <select wire:model="teacher_id">
                        <option value="" selected hidden>Seleccione el profesor...</option>
                        @foreach ($profesores as $profesor)
                            <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <small class="errors" style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="containerContent">
                    <div class="conteInput">
                        <input class="input" wire:model="horas" type="number" placeholder="Horas">
                        <label class="label" for="">Horas</label>
                        @error('horas')
                            <small class="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="conteInput">
                        <input wire:model="fecha" class="input" type="date" placeholder="Fecha">
                        <label class="label" for="">Fecha</label>
                        @error('fecha')
                            <small class="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <button style="background-color: #99BF51" wire:click="save(1)">Registrar Horas</button>
            </form>
        </div>
    @endif
</div>
