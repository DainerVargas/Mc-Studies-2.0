@extends('layouts.usuario')
@section('title', 'Agregar Usuarios')

@section('anadir')
    <div class="user-content-wrapper">
        <div class="profile-header-card">
            <div class="profile-image-container">
                <img id="preview" src="/images/perfil.png" alt="Imagen por defecto">
                <label for="file" class="image-upload-overlay">
                    <span class="material-symbols-outlined">add_a_photo</span>
                </label>
            </div>

            <div class="profile-info">
                <h2 id="previewName">Nuevo Usuario</h2>
                <p id="previewRole">Rol</p>
            </div>
        </div>

        <div class="password-update-card">
            <h2>Agregar Usuario</h2>
            <form action="{{ route('storeUser') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" id="file" name="image" hidden accept="image/*"
                    onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">

                <div class="input-group">
                    <label for="name">Nombre</label>
                    <div class="input-wrapper">
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Nombre completo"
                            oninput="document.getElementById('previewName').innerText = this.value || 'Nuevo Usuario'">
                        <span class="material-symbols-outlined eye-icon" style="pointer-events: none;">person</span>
                    </div>
                    @error('name')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="usuario">Usuario</label>
                    <div class="input-wrapper">
                        <input type="text" id="usuario" name="usuario" value="{{ old('usuario') }}"
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
                        <input type="text" id="email" name="email" value="{{ old('email') }}"
                            placeholder="Correo electrónico">
                        <span class="material-symbols-outlined eye-icon" style="pointer-events: none;">mail</span>
                    </div>
                    @error('email')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                    @if (session('message'))
                        <small class="success-message">{{ session('message') }}</small>
                    @endif
                </div>

                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <div class="input-wrapper">
                        <input type="password" id="nueva" name="password" placeholder="Contraseña">
                        <span id="eye1" class="material-symbols-outlined eye-icon"
                            style="cursor: pointer;">visibility_off</span>
                    </div>
                    @error('password')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>

                <div class="input-group">
                    <label>Rol</label>
                    <select name="type" id="roleSelector">
                        <option value="" selected hidden>Seleccione...</option>
                        @foreach ($rols as $rol)
                            <option value="{{ $rol->id }}" data-name="{{ $rol->name }}">{{ $rol->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>

                <div id="teacherGroup" class="input-group" style="display: none;">
                    <label>Profesor Asociado</label>
                    <select name="teacher_id" id="teacherSelector">
                        <option value="" selected>Ninguno</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" data-name="{{ $teacher->name }}"
                                data-email="{{ $teacher->email }}">
                                {{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="attendantGroup" class="input-group" style="display: none;">
                    <label>Acudiente Asociado</label>
                    <select name="attendant_id" id="attendantSelector">
                        <option value="" selected>Ninguno</option>
                        @foreach ($attendants as $attendant)
                            <option value="{{ $attendant->id }}"
                                data-name="{{ $attendant->name }} {{ $attendant->apellido }}"
                                data-email="{{ $attendant->email }}">
                                {{ $attendant->name }} {{ $attendant->apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-update">Añadir Usuario</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const roleSelector = document.getElementById('roleSelector');
            const teacherGroup = document.getElementById('teacherGroup');
            const attendantGroup = document.getElementById('attendantGroup');
            const previewRole = document.getElementById('previewRole');

            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');

            roleSelector.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                previewRole.innerText = selectedOption.dataset.name;

                // Reset display
                teacherGroup.style.display = 'none';
                attendantGroup.style.display = 'none';

                if (this.value == 4) { // Profesor
                    teacherGroup.style.display = 'block';
                } else if (this.value == 5 || this.value == 6) { // Acudiente o Rol 6
                    attendantGroup.style.display = 'block';
                }
            });

            document.getElementById('teacherSelector').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (this.value) {
                    nameInput.value = selectedOption.dataset.name;
                    emailInput.value = selectedOption.dataset.email;
                    document.getElementById('previewName').innerText = selectedOption.dataset.name;
                }
            });

            document.getElementById('attendantSelector').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (this.value) {
                    nameInput.value = selectedOption.dataset.name;
                    emailInput.value = selectedOption.dataset.email;
                    document.getElementById('previewName').innerText = selectedOption.dataset.name;
                }
            });

            // Toggle Password
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
@endsection
