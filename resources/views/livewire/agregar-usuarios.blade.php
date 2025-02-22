<div class="conteInformacion">
    <div class="conteImg">
        @if ($image)
            <img src="{{ $image->temporaryUrl() }}" alt="">
        @else
            <img src="/images/perfil.png" alt="">
        @endif
        <label class="file" for="file">
            <img src="/images/mas.png" alt="">
        </label>
        <div class="informacion">
            <h2>{{ $name }}</h2>
            <p>{{ $typeName }}</p>
        </div>
    </div>
    <div class="containerForm">
        <h2>Agregar {{ $typeName }}</h2>
        <form wire:submit="save">
            @csrf
            <input type="file" id="file" wire:model="image" hidden>
            <div class="contenedor">
                <div class="containerContents">
                    <div class="conteInput">
                        <input type="text" wire:model.live="name" class="input" value="{{ old('name') }}"
                            placeholder="Nombre">
                        <label for="" class="label">Nombre</label>
                        @error('name')
                            <small class="errors" style="color red">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="conteInput">
                        <input type="text" class="input" wire:model="usuario" value="{{ old('usuario') }}"
                            placeholder="usuario">
                        <label for="" class="label">Usuario</label>
                        @error('usuario')
                            <small class="errors" style="color:red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="containerContents">
                    <div class="conteInput">
                        <input type="text" class="input" wire:model="email" value="{{ old('email') }}"
                            placeholder="email">
                        <label for="" class="label">Email</label>
                        @error('email')
                            <small class="errors" style="color:red">{{ $message }}</small>
                        @enderror
                        @error('message')
                            <small class="errors" style="color:green">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="conteInput">
                        <input type="password" id="nueva" wire:model="password" class="input"
                            value="{{ old('password') }}" placeholder="Nombre">
                        <label for="" class="label">Contraseña</label>
                        @error('password')
                            <small class="errors" style="color red">{{ $message }}</small>
                        @enderror
                        <span id="eye1" class="material-symbols-outlined eye">
                            visibility_off
                        </span>
                    </div>
                </div>
            </div>
            <div class="containerContents">
                <div class="conteInput">
                    <select class="input" wire:model.live="type" name="" id="">
                        <option value="" selected hidden>Seleccione...</option>
                        @foreach ($rols as $rol)
                            <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <small class="errors" id="left" style="color red">{{ $message }}</small>
                    @enderror
                    @if (isset($message))
                        <small class="errors" id="left" style="color: green">{{ $message }}</small>
                    @endif
                </div>
            </div>
            @if ($type == 4)                
            <div class="containerContents" id="absolute">
                <div class="conteInput">
                    <select class="input select" wire:model.live="teacherId" name="" id="">
                        <option value="" selected hidden>Seleccione...</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <small class="errors" id="left" style="color red">{{ $message }}</small>
                    @enderror
                    @if (isset($message))
                        <small class="errors" id="left" style="color: green">{{ $message }}</small>
                    @endif
                </div>
            </div>
            @endif

            <button type="submit" class="btnActualizar">Añadir {{ $typeName }}</button>
        </form>
    </div>
    <script>
        let nueva = document.getElementById("nueva");
        let eye1 = document.getElementById("eye1");
        let count = 0;
        eye1.addEventListener('click', () => {
            count++;
            if (count === 1) {
                eye1.innerHTML = "visibility";
                nueva.type = "text";
            } else {
                eye1.innerHTML = "visibility_off";
                nueva.type = "password";
                count = 0;
            }
        });
    </script>
</div>
