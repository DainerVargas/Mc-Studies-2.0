<div class="componente">
    <div class="conteFiltro" id="conteProfesor">
        <form wire:submit="filtrar">
            <div class="conteInput">
                <label for="filtro">Filtra por el nombre del Profesor o Tutor</label>
                <input type="text" wire:model.live="filtro" placeholder="Nombre del Profesor o Tutor">
            </div>
        </form>

        <div class="conteSelect">
            <div class="conteChecks">
                <div class="conteRadio">
                    <input wire:model.live="estado" value="all" type="radio" checked id="option1">
                    <label for="option1">Todos</label>
                </div>
                <div class="conteRadio">
                    <input wire:model.live="estado" value="active" type="radio" id="option2">
                    <label for="option2">Active</label>
                </div>
                <div class="conteRadio">
                    <input wire:model.live="estado" value="inactive" type="radio" id="option3">
                    <label for="option3">Inactive</label>
                </div>
            </div>
        </div>

        <div class="conteBtnCreate">
            <a><button wire:click="update"><img src="/images/agregar.png" alt="">
                    añadir</button></a>
        </div>
        
    </div>

    <div class="containerConte">
        <div class="conteTable">
            <table class="teacher">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Profesor</th>
                        <th>email</th>
                        <th>Estado</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @forelse ($profesores as $profesor)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td class="relative">
                                <div class="conteName">
                                    @if ($profesor->image)
                                        <img src="/users/{{ $profesor->image }}" alt="">
                                    @else
                                        <img src="/images/perfil.png" alt="">
                                    @endif
                                    <a href="{{ route('infoProfesor', $profesor->id) }}">{{ $profesor->name }}
                                        {{ $profesor->apellido }}</a>
                                </div>
                            </td>
                            <td>{{ $profesor->email }}</td>
                            @php
                                $estado = $profesor->estado == 1 ? 'active' : 'inactive';
                            @endphp
                            <td>
                                <div class="flex">
                                    <button class="{{ $estado }}">{{ $estado }}</button>
                                </div>
                            </td>
                            <td>
                                <div class="flex">
                                    <a href="{{ route('infoProfesor', $profesor->id) }}"><button class="update"><span
                                                class="material-symbols-outlined">
                                                edit
                                            </span> Editar</button></a>
                                </div>
                            </td>
                            <td>
                                <div class="flex">
                                    <button class="delete" wire:click="delete({{ $profesor->id }})"
                                        wire:confirm="¿Desea elimiar el {{ $profesor->type_teacher->name }}  {{ $profesor->name }}?">
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
                <span wire:click="ocultar" title="Cerrar" class="material-symbols-outlined">
                    close
                </span>
            </div>
            <form wire:submit="">
                <div class="conteImage">
                    <div class="contePerfil">
                        @if ($image)
                            <div class="imageConte">
                                <img class="perfil" src="{{ $image->temporaryUrl() }}" alt="">
                            </div>
                        @else
                            <div class="imageConte">
                                <img class="perfil" src="/images/perfil.png" alt="">
                            </div>
                        @endif
                        <label for="image">
                            <img class="mas" title="Subir Foto" src="/images/mas.png" alt="">
                        </label>
                        <input type="file" wire:model="image" id="image" hidden>
                        @error('image')
                            <small class="errors" style="color: red">{{ $message }}</small>
                        @enderror

                        <span class="material-symbols-outlined loading" wire:loading>
                            directory_sync
                        </span>
                    </div>
                </div>
                <div class="containerContent">
                    <div class="conteInput">
                        <input wire:model="name" class="input" type="text" placeholder="nombre" name=""
                            id="">
                        <label class="label" for="">Nombre</label>
                        @error('name')
                            <small class="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="conteInput">
                        <input wire:model="apellido" class="input" type="text" placeholder="apellido"
                            name="" id="">
                        <label class="label" for="">Apellido</label>
                        @error('apellido')
                            <small class="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="containerContent">
                    <div class="conteInput">
                        <input class="input" wire:model="email" type="text" placeholder="Email" name=""
                            id="">
                        <label class="label" for="">Email</label>
                        @error('email')
                            <small class="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="conteInput">
                        <input wire:model="telefono" class="input" type="text" placeholder="Telefono"
                            name="" id="">
                        <label class="label" for="">Telefono</label>
                        @error('telefono')
                            <small class="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="containerContent">
                    <select wire:model="type_teacher_id" name="" id="">
                        <option value="" selected hidden>Seleccione el tipo...</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('type_teacher_id')
                        <small class="errors" style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <button wire:click="save">Registrar</button>
            </form>
        </div>
    @endif
</div>
