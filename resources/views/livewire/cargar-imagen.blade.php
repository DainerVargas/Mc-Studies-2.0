<div>
    <div class="profile-header-card">
        <div class="profile-image-container">
            @if ($imagen)
                <img src="{{ $imagen->temporaryUrl() }}" alt="Previsualización">
            @else
                @if ($user->image)
                    <img src="/users/{{ $user->image }}" alt="Foto de perfil">
                @else
                    <img src="/images/perfil.png" alt="Foto por defecto">
                @endif
            @endif

            <label for="file" class="image-upload-overlay">
                <span class="material-symbols-outlined">add_a_photo</span>
            </label>

            <div wire:loading wire:target="imagen" class="loading-overlay">
                <span class="material-symbols-outlined spin">refresh</span>
            </div>
        </div>

        <div class="profile-info">
            <h2>{{ $user->name }}</h2>
            <p>{{ $user->rol->name }}</p>
        </div>
    </div>

    <div class="password-update-card"> {{-- Reuse card style for consistency --}}
        <h2>Actualizar Información</h2>
        <form action="{{ route('updateInfo', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" id="file" wire:model="imagen" name="image" hidden accept="image/*">

            <div class="input-group">
                <label for="name">Nombre</label>
                <div class="input-wrapper">
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                        placeholder="Nombre completo">
                    <span class="material-symbols-outlined eye-icon" style="pointer-events: none;">person</span>
                </div>
                @error('name')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="input-group">
                <label for="usuario">Usuario</label>
                <div class="input-wrapper">
                    <input type="text" id="usuario" name="usuario" value="{{ old('usuario', $user->usuario) }}"
                        placeholder="Nombre de usuario">
                    <span class="material-symbols-outlined eye-icon" style="pointer-events: none;">badge</span>
                </div>
                @error('usuario')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                        placeholder="Correo electrónico">
                    <span class="material-symbols-outlined eye-icon" style="pointer-events: none;">mail</span>
                </div>
                @error('email')
                    <small class="error-message">{{ $message }}</small>
                @enderror
                @error('message')
                    <small class="success-message">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn-update">Actualizar</button>
        </form>
    </div>

    <style>
        /* Local styles for specific loading state */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 5;
        }

        .spin {
            animation: spin 1s linear infinite;
            color: #05ccd1;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</div>
