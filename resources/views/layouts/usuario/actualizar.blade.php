@extends('layouts.usuario')
@section('title', 'Actualizar información')

@section('actualizar')
    <div class="conteInformacion">
        <div class="conteImg">
            @if ($user->image)
                <img src="/users/{{ $user->image }}" alt="">
            @else
                <img src="/images/perfil.png" alt="">
            @endif
            <div class="informacion">
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->rol->name }}</p>
            </div>
        </div>
        <div class="containerForm">
            <h2>Actualizar Contraseña</h2>
            <form action="{{ route('updateUser', $user->id) }}" method="POST">
                @csrf
                <div class="containerContents">
                    <div class="conteInput">
                        <input type="password" id="antigua" name="antigua" class="input" placeholder="antigua" value="{{old('antigua')}}">
                        <label for="" class="label">Antigua Contraseña</label>
                        @error('antigua')
                            <small class="errors" style="color red">{{ $message }}</small>
                        @enderror
                        <span id="eye1" class="material-symbols-outlined eye">
                            visibility_off
                        </span>
                    </div>
                    <div class="conteInput">
                        <input type="password" class="input" id="nueva" name="nueva" placeholder="nueva" value="{{old('nueva')}}">
                        <label for="" class="label">Nueva Contraseña</label>
                        @error('nueva')
                            <small class="errors" id="left" style="color:red">{{ $message }}</small>
                        @enderror
                        <span id="eye2" class="material-symbols-outlined eye">
                            visibility_off
                        </span>
                    </div>
                    <div class="conteInput">
                        <input type="password" class="input" id="confirm" name="confirm" placeholder="email" value="{{old('confirm')}}">
                        <label for="" class="label">Confirmar Contraseña</label>
                        @error('confirm')
                            <small class="errors" style="color:red">{{ $message }}</small>
                        @enderror
                        @error('message')
                            <small class="errors" style="color:green">{{ $message }}</small>
                        @enderror
                        <span id="eye3" class="material-symbols-outlined eye">
                            visibility_off
                        </span>
                    </div>
                </div>
                <button type="submit" class="btnActualizar">Actualizar Contraseña</button>
            </form>
        </div>
    </div>

    <script>
        let antigua = document.getElementById("antigua");
        let confirm = document.getElementById("confirm");
        let nueva = document.getElementById("nueva");

        let eye1 = document.getElementById("eye1");
        let eye2 = document.getElementById("eye2");
        let eye3 = document.getElementById("eye3");

        let count = 0;
        eye1.addEventListener('click', () => {
            count++;
            if (count === 1) {
                eye1.innerHTML = "visibility";
                antigua.type = "text";
            } else {
                eye1.innerHTML = "visibility_off";
                antigua.type = "password";
                count = 0;
            }
        });

        let count2 = 0;
        eye2.addEventListener('click', () => {
            count2++;
            if (count2 === 1) {
                eye2.innerHTML = "visibility";
                nueva.type = "text";
            } else {
                eye2.innerHTML = "visibility_off";
                nueva.type = "password";
                count2 = 0;
            }
        });

        let count3 = 0;
        eye3.addEventListener('click', () => {
            count3++;
            if (count3 === 1) {
                eye3.innerHTML = "visibility";
                confirm.type = "text";
            } else {
                eye3.innerHTML = "visibility_off";
                confirm.type = "password";
                count3 = 0;
            }
        });

    </script>
@endsection
