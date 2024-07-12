<div class="componente">
    <div class="headerInfo">
        <div class="back">
            <a href="{{ route('listaProfesor') }}">
                <img title="Go back" src="/images/atras.png" alt="">
            </a>
            @php
                $idTeacher = $teacher->id;
            @endphp
            <div class="conteImage">
                @if ($teacher->image)
                    @if ($image)
                        <img class="perfilImg" src="{{ $image->temporaryUrl() }}" alt="">
                    @else
                        <img class="perfilImg" src="/users/{{ $teacher->image }}" alt="">
                    @endif
                    <div class="conteFile">
                        <label for="image">
                            <img class="mas" title="Subir Foto" src="/images/mas.png" alt="">
                        </label>
                        <input type="file" wire:model="image" id="image" hidden>
                    </div>

                    <span class="material-symbols-outlined loading" wire:loading>
                        directory_sync
                    </span>
                @else
                    @if ($image)
                        <img class="perfilImg" src="{{ $image->temporaryUrl() }}" alt="">
                    @else
                        <img class="perfilImg" src="/images/perfil.png" alt="">
                    @endif
                    <div class="conteFile">
                        <label for="image">
                            <img class="mas" title="Subir Foto" src="/images/mas.png" alt="">
                            <input type="file" wire:model="image" id="image" hidden>
                        </label>
                    </div>

                    <span class="material-symbols-outlined loading" wire:loading>
                        directory_sync
                    </span>
                @endif
                @error('image')
                    <small class="errors" style="color: red">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="nameTeacher">

        </div>
        <div class="estado">
            @if ($teacher->estado == 1)
                <div class="active">
                    <p class="textestado">Active</p>
                </div>
                <div class="botonActive">
                    <button wire:click="toggleEstado({{ $teacher->id }})"
                        wire:confirm="¿Quieres deshabilitar al aprendiz: {{ $teacher->name }}?"></button>
                </div>
            @else
                <div class="inactive">
                    <p class="textestado">Inactive</p>
                </div>
                <div class="botonInactive">
                    <button wire:click="toggleEstado({{ $teacher->id }})"
                        wire:confirm="¿Quieres habilitar al aprendiz: {{ $teacher->name }}?"></button>
                </div>
            @endif
        </div>
    </div>
    <div class="mainInfo">
        <div class="infoEstado">
            <p class="name">{{ $teacher->name }} {{ $teacher->apellido }}</p>
            <p>{{ $teacher->type_teacher->name }}</p>
            <div class="eye">
                @if (!isset($teacher->group[0]->name) || isset($teacher->group->name))
                    <p>Sin Grupo</p>
                @else
                    <p>{{ $teacher->group[0]->name }}</p>
                @endif
                <span title="Enviar comprobante de pago" wire:click="comprobantePago" class="material-symbols-outlined">
                    file_open
                </span>
                <a href="{{ route('descargap', $teacher->id) }}">
                    <span class="material-symbols-outlined" title="Descargar documento">
                        download
                    </span>
                </a>
            </div>
            <div class="estado">
                <span>Estatus:</span>
                @if ($teacher->estado == 0)
                    <button class="inactive">Inactive</button>
                @else
                    <button class="active">active</button>
                @endif
            </div>
        </div>
        <div class="informacion">
            <p class="title">Información Personal</p>
            <div class="datos">
                <p>Nombre: <input type="text" value="{{ $teacher->name }}" wire:model="name" id=""></p>
                <p>Apellido: <input type="text" value="{{ $teacher->apellido }}" wire:model="apellido"
                        id=""></p>
                <p>Email: <input type="text" value="{{ $teacher->email }}" wire:model="email" id=""></p>
                <p>Telefono: <input type="text" wire:model="telefono" id=""
                        value="{{ $teacher->telefono }}"></p>
                <p>Tipo: <select wire:model="type" id="">
                        <option value="{{ $teacher->type_teacher_id }}">{{ $teacher->type_teacher->name }}</option>

                        @foreach ($type_teachers as $type_teacher)
                            @if ($type_teacher->id != $teacher->type_teacher_id)
                                <option value="{{ $type_teacher->id }}">{{ $type_teacher->name }}</option>
                            @endif
                        @endforeach
                    </select></p>
                <p>Fecha-Inicio: <span>{{ $teacher->fecha_inicio }}</span></p>
                {{-- <p>Fecha-Finalización: <span>{{ $teacher->fecha_fin }}</span></p> --}}
            </div>
        </div>
        <div class="infoAcudiente">
            <p class="title">Información Empresarial</p>
            <div class="datos">
                @if (!isset($teacher->group[0]->name) || isset($teacher->group->name))
                    <p>Grupo: Sin Grupo</p>
                @else
                    <p>Nombre Grupo: {{ $teacher->group[0]->name }}</p>
                @endif
                @if (!isset($teacher->group[0]->name) || isset($teacher->group->name))
                    <p>Tipo: <span>No hay tipo</span></p>
                @else
                    <p>Tipo: <span>{{ $teacher->group[0]->type->name }}</span></p>
                @endif
            </div>
            <button wire:click="update({{ $teacher->id }})">Actualizar Información</button>
        </div>
    </div>

    @if ($view != 0)
        <div class="conteUpdate">
            <div class="close">
                <span wire:click="ocultar" title="Cerrar" class="material-symbols-outlined">
                    close
                </span>
            </div>
            <div class="conteImagen">
                <h3>Enviar Comprobante</h3>
                <form wire:submit="sendEmail({{ $teacher->id }})" enctype="multipart/form-data">
                    <div class="conteLabel">
                        <label for="imagen">
                            @if ($comprobante)
                                <img src="{{ $comprobante->temporaryUrl() }}" alt="">
                            @else
                                <img class="comprobante" src="/images/comprobante.png" alt="">
                            @endif
                        </label>
                    </div>
                    @error('comprobante')
                        <small class="errors" style="color:red">{{ $message }}</small>
                    @enderror
                    @error('valor')
                        <small class="errors" style="color:red">{{ $message }}</small>
                    @enderror
                    @error('message')
                        <small class="errors" style="color:green">{{ $message }}</small>
                    @enderror
                    <div class="conteInput">
                        <label for="valor">Valor a pagar</label>
                        <input type="text" wire:model="valor" id="valor" class="input">
                    </div>
                    <input type="file" name="file" hidden wire:model="comprobante" id="imagen">
                    <div class="boton">
                        <button type="submit">Enviar Comprobante</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
