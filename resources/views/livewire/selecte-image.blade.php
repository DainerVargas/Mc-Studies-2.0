<div class="conteUpdate">
    <div class="conteImg">
        @if ($image)
            <img id="img" src="{{ $image->temporaryUrl() }}" alt="">
        @else
            @if ($aprendiz->imagen)
                {{-- <img id="img" src="/users/{{ $aprendiz->imagen }}" alt=""> --}}
                <img id="img" src="{{ asset('users/' . $aprendiz->imagen) }}" alt="">
            @else
                <img id="img" src="/images/perfil.png" alt="">
            @endif
        @endif
        <label for="imagen">
            <img src="/images/mas.png" alt="">
        </label>
    </div>
    <form action="{{ route('update', $aprendiz->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" wire:model="image" value="{{ $aprendiz->imagen }}" name="imagen" id="imagen" hidden>
        <div class="containerInfo">
            <div class="infoAprendiz">
                <div class="datosPersonales">
                    <h2>Datos del Estudiante</h2>
                    <div class="containerContents">
                        <div class="conteInput">
                            <input class="input" type="text" name="name" placeholder="Nombre"
                                value="{{ old('name', $aprendiz->name) }}">
                            <label class="label" for="">Nombre</label>
                            @error('name')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="conteInput">
                            <input class="input" type="text" name="apellido" placeholder="Apellido"
                                value="{{ old('apellido', $aprendiz->apellido) }}">
                            <label class="label" for="">Apellido</label>
                            @error('apellido')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="conteInput">
                            <input class="input" type="text" name="edad" placeholder="edad"
                                value="{{ old('edad', $aprendiz->edad) }}">
                            <label class="label" for="">Edad</label>
                            @error('edad')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="conteInput">
                            <input class="input" type="date" name="fecha_nacimiento" placeholder="fecha_nacimiento"
                                value="{{ old('fecha_nacimiento', $aprendiz->fecha_nacimiento) }}">
                            <label class="label" for="">Fecha_nacimiento</label>
                            @error('fecha_nacimiento')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="conteInput">
                            <input class="input" type="text" name="direccion" placeholder="Dirección"
                                value="{{ old('direccion', $aprendiz->direccion) }}">
                            <label class="label" for="">Dirección</label>
                            @error('direccion')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="datosEstudiantil datosPersonales">
                    <div class="containerContents">
                        <div class="conteInput">
                            <select class="input" name="modality_id" id="">
                                <option value="{{ $aprendiz->modality->id }}">{{ $aprendiz->modality->name }}</option>
                                @foreach ($modalidades as $modalidad)
                                    @if ($modalidad->id != $aprendiz->modality->id)
                                        <option value="{{ $modalidad->id }}">{{ $modalidad->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label class="label" for="">Modalidad</label>
                            @error('modality_id')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="conteInput">
                            @php
                                $grupoName = isset($aprendiz->group->name) ? $aprendiz->group->name : 'Sin Grupo';
                                $grupoId = isset($aprendiz->group->name) ? $aprendiz->group->id : '';
                            @endphp
                            <select class="input" name="group_id" id="">
                                <option value="{{ $grupoId }}">{{ $grupoName }}</option>
                                @if (isset($aprendiz->group->name))
                                    @foreach ($grupos as $grupo)
                                        @if ($grupo->id != $aprendiz->group->id)
                                            <option value="{{ $grupo->id }}">{{ $grupo->name }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach ($grupos as $grupo)
                                        <option value="{{ $grupo->id }}">{{ $grupo->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label class="label" for="">Grupo</label>
                            @error('group_id')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>

                        @if ($aprendiz->edad >= 18)
                            <div class="conteInput">
                                <input type="text" class="input" name="telefonoStudent" placeholder="Telefono"
                                    value="{{ old('telefonoStudent', $aprendiz->telefono) }}">
                                <label for="" class="label">Telefono</label>
                                @error('telefonoStudent')
                                    <small class="errors" style="color red">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="conteInput">
                                <input type="text" class="input" name="emailStudent" placeholder="Email"
                                    value="{{ old('emailStudent', $aprendiz->email) }}">
                                <label for="" class="label">Email</label>
                                @error('emailStudent')
                                    <small class="errors" style="color red">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="infoAcudiente">
                <div class="datosAcudiente">
                    <h2>Datos del Acudiente</h2>
                    <div class="containerContents">
                        <div class="conteInput">
                            <input class="input" type="text" name="nameAcudiente" placeholder="Nombre"
                                value="{{ old('nameAcudiente', $aprendiz->attendant->name) }}">
                            <label class="label" for="">Nombre Acudiente</label>
                            @error('nameAcudiente')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="conteInput">
                            <input class="input" type="text" name="apellidoAcudiente" placeholder="Nombre"
                                value="{{ old('apellidoAcudiente', $aprendiz->attendant->apellido) }}">
                            <label class="label" for="">Apellido Acudiente</label>
                            @error('apellidoAcudiente')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="conteInput">
                            <input class="input" type="text" name="email" placeholder="Nombre"
                                value="{{ old('email', $aprendiz->attendant->email) }}">
                            <label class="label" for="">Email</label>
                            @error('email')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="conteInput">
                            <input class="input" type="text" name="telefono" placeholder="Nombre"
                                value="{{ old('telefono', $aprendiz->attendant->telefono) }}">
                            <label class="label" for="">Telefono</label>
                            @error('telefono')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btnConte">
            <button class="btn" type="submit">Actualizar Información <span
                    wire:loading>Cargando...</span></button>
        </div>
        @error('message')
            <small style="color: green">{{ $message }}</small>
        @enderror
    </form>
</div>
