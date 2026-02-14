<div>
    <div class="profile-header-card">
        <div class="profile-image-container">
            @if ($image)
                <img src="{{ $image->temporaryUrl() }}" alt="Previsualización">
            @else
                <img src="/images/perfil.png" alt="Imagen por defecto">
            @endif

            <label for="file" class="image-upload-overlay">
                <span class="material-symbols-outlined">add_a_photo</span>
            </label>

            <div wire:loading wire:target="image" class="loading-overlay">
                <span class="material-symbols-outlined spin">refresh</span>
            </div>
        </div>

        <div class="profile-info">
            <h2>{{ $name ?: 'Nuevo Usuario' }}</h2>
            <p>{{ $typeName ?: 'Rol' }}</p>
        </div>
    </div>

    <div class="password-update-card">
        <h2>Agregar {{ $typeName ?: 'Usuario' }}</h2>
        <form wire:submit="save">
            @csrf
            <input type="file" id="file" wire:model="image" hidden accept="image/*">

            <div class="input-group">
                <label for="name">Nombre</label>
                <div class="input-wrapper">
                    <input type="text" id="name" wire:model.live="name" placeholder="Nombre completo">
                    <span class="material-symbols-outlined eye-icon" style="pointer-events: none;">person</span>
                </div>
                @error('name')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="input-group">
                <label for="usuario">Usuario</label>
                <div class="input-wrapper">
                    <input type="text" id="usuario" wire:model="usuario" placeholder="Nombre de usuario">
                    <span class="material-symbols-outlined eye-icon" style="pointer-events: none;">badge</span>
                </div>
                @error('usuario')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <input type="text" id="email" wire:model="email" placeholder="Correo electrónico">
                    <span class="material-symbols-outlined eye-icon" style="pointer-events: none;">mail</span>
                </div>
                @error('email')
                    <small class="error-message">{{ $message }}</small>
                @enderror
                @error('message')
                    <small class="success-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="input-group">
                <label for="password">Contraseña</label>
                <div class="input-wrapper">
                    <input type="password" id="nueva" wire:model="password" placeholder="Contraseña">
                    <span id="eye1" class="material-symbols-outlined eye-icon"
                        style="cursor: pointer;">visibility_off</span>
                </div>
                @error('password')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="input-group">
                <label>Rol</label>
                <select wire:model.live="type">
                    <option value="" selected hidden>Seleccione...</option>
                    @foreach ($rols as $rol)
                        <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                    @endforeach
                </select>
                @error('type')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            @if ($type == 4)
                <div class="input-group">
                    <label>Profesor Asociado</label>
                    <select wire:model.live="teacherId">
                        <option value="" selected hidden>Seleccione...</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                    @if (isset($message))
                        <small class="success-message">{{ $message }}</small>
                    @endif
                </div>
            @endif

            @if ($type == 5)
                <div class="input-group">
                    <label>Acudiente Asociado</label>
                    <select wire:model.live="attendantId">
                        <option value="" selected hidden>Seleccione...</option>
                        @foreach ($attendants as $attendant)
                            <option value="{{ $attendant->id }}">{{ $attendant->name }} {{ $attendant->apellido }}
                            </option>
                        @endforeach
                    </select>
                    @error('attendantId')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>
            @endif

            <button type="submit" class="btn-update">Añadir {{ $typeName ?: 'Usuario' }}</button>
        </form>
    </div>

    <style>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nueva = document.getElementById("nueva");
            const eye1 = document.getElementById("eye1");

            if (eye1 && nueva) {
                eye1.addEventListener('click', () => {
                    if (nueva.type === "password") {
                        nueva.type = "text";
                        eye1.textContent = "visibility";
                    } else {
                        nueva.type = "password";
                        eye1.textContent = "visibility_off";
                    }
                });
            }
        });
    </script>
</div>
