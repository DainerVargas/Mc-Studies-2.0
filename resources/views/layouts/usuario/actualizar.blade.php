@extends('layouts.usuario')
@section('title', 'Actualizar información')

@section('actualizar')
    <div class="profile-header-card">
        <div class="profile-image-container">
            @if ($user->image)
                <img src="/users/{{ $user->image }}" alt="Foto de perfil">
            @else
                <img src="/images/perfil.png" alt="Foto por defecto">
            @endif
        </div>
        <div class="profile-info">
            <h2>{{ $user->name }}</h2>
            <p>{{ $user->rol->name }}</p>
        </div>
    </div>

    <div class="password-update-card">
        <h2>Actualizar Contraseña</h2>
        <form action="{{ route('updateUser', $user->id) }}" method="POST">
            @csrf

            <div class="input-group">
                <label for="antigua">Antigua Contraseña</label>
                <div class="input-wrapper">
                    <input type="password" id="antigua" name="antigua" placeholder="Ingrese contraseña actual"
                        value="{{ old('antigua') }}">
                    <span id="eye1" class="material-symbols-outlined eye-icon">visibility_off</span>
                </div>
                @error('antigua')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="input-group">
                <label for="nueva">Nueva Contraseña</label>
                <div class="input-wrapper">
                    <input type="password" id="nueva" name="nueva" placeholder="Nueva contraseña"
                        value="{{ old('nueva') }}">
                    <span id="eye2" class="material-symbols-outlined eye-icon">visibility_off</span>
                </div>
                @error('nueva')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="input-group">
                <label for="confirm">Confirmar Contraseña</label>
                <div class="input-wrapper">
                    <input type="password" id="confirm" name="confirm" placeholder="Confirme nueva contraseña"
                        value="{{ old('confirm') }}">
                    <span id="eye3" class="material-symbols-outlined eye-icon">visibility_off</span>
                </div>
                @error('confirm')
                    <small class="error-message">{{ $message }}</small>
                @enderror
                @error('message')
                    <small class="success-message">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn-update">Actualizar</button>
        </form>
    </div>

    <script>
        // Toggle Password Visibility
        function toggleVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            icon.addEventListener('click', () => {
                if (input.type === "password") {
                    input.type = "text";
                    icon.textContent = "visibility";
                } else {
                    input.type = "password";
                    icon.textContent = "visibility_off";
                }
            });
        }

        toggleVisibility('antigua', 'eye1');
        toggleVisibility('nueva', 'eye2');
        toggleVisibility('confirm', 'eye3');
    </script>
@endsection
