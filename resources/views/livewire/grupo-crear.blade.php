<div class="componente">
    <div class="conteFiltro" id="conteProfesor">
        <form>
            <div class="conteInput">
                <label for="filtro">Filtra por el nombre del Grupo</label>
                <input type="text" wire:model.live="filtroName" placeholder="Nombre del Grupo">
            </div>
        </form>
        <div class="conteSelect ">
            <div class="conteChecks">
                <div class="conteRadio">
                    <input wire:model.live="estado" value="" type="radio" checked="" id="option1">
                    <label for="option1">Todos</label>
                </div>
                <div class="conteRadio">
                    <input wire:model.live="estado" value="active" type="radio" id="option2">
                    <label for="option2">Mc-Kids</label>
                </div>
                <div class="conteRadio">
                    <input wire:model.live="estado" value="inactive" type="radio" id="option3">
                    <label for="option3">Mc-Teens</label>
                </div>
            </div>
        </div>
        <div class="conteBtnCreate">
            <a><button wire:click="update"><img src="/images/grupo2.png" alt="">
                    Crear</button></a>
        </div>
    </div>

    <div class="containerConte">
        <div class="conteTable">
            <table class="grupo">
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
                            <td class="relative">
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
                                    <a><button type="button" class="update"
                                            wire:click="actualizar({{ $grupo->id }})"><span
                                                class="material-symbols-outlined">
                                                edit
                                            </span> Editar</button></a>
                                </div>
                            </td>
                            <td>
                                <div class="flex">
                                    <button class="delete" wire:click="delete({{ $grupo->id }})"
                                        wire:confirm="¿Desea elimiar el grupo {{ $grupo->name }} ?"><span
                                            class="material-symbols-outlined">
                                            delete
                                        </span> Eliminar</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <p class="nodatos">No hay datos</p>
                                <video class="video" src="/videos/video2.mp4" height="180vw" autoplay loop>
                                    <source src="/videos/video2.mp4" type="">
                                </video>
                            </td>
                        </tr>
                    @endforelse
                    <td id="start" colspan="4">Total cantidad:</td>
                    <td class="cantidad">{{ $cantidad }}</td>
                </tbody>
            </table>
        </div>
    </div>

    @if ($view != 0)
        <div class="conteUpdate">
            <div class="close">
                <span wire:click="ocultar" title="Cerrar" class="material-symbols-outlined">
                    close
                </span>
            </div>
            <form wire:submit="" id="formgroup">
                <div class="contetitulo">
                    <h1>CREAR UN GRUPO</h1>
                </div>
                <div class="containerContent">
                    <div class="conteInput">
                        <input wire:model.live="filtroTeacher" class="input" type="text" placeholder="nombre"
                            name="" id="">
                        <label class="label" for="">Filtrar</label>
                    </div>
                    <select name="teacher_id" wire:model="teacher_id" id="">
                        <option value="">Seleccione...</option>
                        @foreach ($profesores as $profesor)
                            @if ($profesor->type_teacher_id == 1 || $profesor->type_teacher_id == 2)
                                <option value="{{ $profesor->id }}">{{ $profesor->name }} -
                                    {{ $profesor->type_teacher->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <small class="errors" style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="containerContent">
                    <div class="conteInput">
                        <input class="input" wire:model="name" type="text" placeholder="name">
                        <label class="label" for="">Nombre del Grupo</label>
                        @error('name')
                            <small class="errors" id="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                    <select wire:model="type_id" name="" id="">
                        <option value="" selected hidden>Seleccione el tipo...</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('type_id')
                        <small class="errors" id="errors" style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="conteBtn">
                    <button class="cancelar" wire:click="ocultar">Cancelar</button>
                    <button class="registrar" wire:click="save">Registrar</button>
                </div>
            </form>
        </div>
    @endif

    @if ($view2 != 0)
        <div class="conteUpdate" id="updateGroup">
            <div class="close">
                <span wire:click="ocultar" title="Cerrar" class="material-symbols-outlined">
                    close
                </span>
            </div>
            <form wire:submit="" id="formgroup">
                <div class="containerContent">
                    <div class="conteInput">
                        <input class="input" wire:model="grupoNmae" type="text" placeholder="name">
                        <label class="label" for="">Nombre del Grupo</label>
                        @error('grupoNmae')
                            <small class="errors" id="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="conteInput">
                        <select name="teacher_id" wire:model="profesor_id" id="">
                            <option value="" selected hidden>seleccione...</option>
                            @if (isset($profesorName))
                                <option selected value="{{ $profesorName->id }}"> {{ $profesorName->name }}
                                </option>
                                @foreach ($profesores as $profesor)
                                    @if ($profesorName->id != $profesor->id)
                                        <option value="{{ $profesor->id }}">{{ $profesor->name }} </option>
                                    @endif
                                @endforeach
                            @else
                                @foreach ($profesores as $profesor)
                                    <option value="{{ $profesor->id }}">{{ $profesor->name }} </option>
                                @endforeach
                            @endif
                        </select>
                        @error('profesor_id')
                            <small class="errors" id="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="conteBtn">
                    <button class="registrar" wire:click="guardar({{ $grupoId }})">Actualizar</button>
                </div>
            </form>
        </div>
    @endif

</div>
