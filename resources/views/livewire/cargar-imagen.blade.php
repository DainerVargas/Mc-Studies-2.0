<div class="conteInformacion">
    <div class="conteImg">
        @if ($imagen)
            <img src="{{ $imagen->temporaryUrl() }}" alt="">
        @else
            @if ($user->image)
                <img src="/users/{{ $user->image }}" alt="">
            @else
                <img src="/images/perfil.png" alt="">
            @endif
        @endif
        <label class="file" for="file">
            <img src="/images/mas.png" alt="">
        </label>
        <div class="informacion">
            <h2>{{ $user->name }}</h2>
            <p>{{ $user->rol->name }}</p>
        </div>
        <small wire:loading="">Cargando...</small>
    </div>

    <div class="containerForm">
        <h2>Actualizar Información</h2>
        <form action="{{ route('updateInfo', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" id="file" wire:model="imagen" name="image" hidden>
            <div class="containerContents">
                <div class="conteInput">
                    <input type="text" name="name" class="input" value="{{ old('name', $user->name) }}"
                        placeholder="Nombre">
                    <label for="" class="label">Nombre</label>
                    @error('name')
                        <small class="errors" style="color red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="conteInput">
                    <input type="text" class="input" name="usuario" value="{{ old('usuario', $user->usuario) }}"
                        placeholder="usuario">
                    <label for="" class="label">Usuario</label>
                    @error('usuario')
                        <small class="errors" style="color:red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="conteInput">
                    <input type="text" class="input" name="email" value="{{ old('email', $user->email) }}"
                        placeholder="email">
                    <label for="" class="label">Email</label>
                    @error('email')
                        <small class="errors" style="color:red">{{ $message }}</small>
                    @enderror
                    @error('message')
                        <small class="errors" style="color:green">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btnActualizar">Actualizar Información</button>
        </form>
    </div>
</div>
