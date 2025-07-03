<div class="componente">
    <div class="headerInfo">
        <div class="back">
            <a href="{{ route('listaAprendiz') }}">
                <img title="Go back" src="/images/atras.png" alt="">
            </a>
            <div class="conteImage">
                @if ($aprendiz->imagen)
                    <img class="perfilImg" src="{{ asset('users/' . $aprendiz->imagen) }}" alt="">
                @else
                    <img class="perfilImg" src="{{ asset('images/perfil.png') }}" alt="">
                @endif
            </div>
        </div>
        <div class="nameTeacher">
            @php
                if ($aprendiz->group_id == null) {
                    $profesor = 'Sin profesor';
                } elseif ($aprendiz->group->teacher_id != null) {
                    $profesor = $aprendiz->group->teacher->name . ' ' . $aprendiz->group->teacher->apellido;
                } else {
                    $profesor = 'Sin profesor';
                }
            @endphp
            <p>Profesor: <span>{{ $profesor }}</span></p>
        </div>
        @if ($user->rol_id == 1)
            <div class="estado">
                @if ($aprendiz->estado == 1)
                    <div class="active">
                        <p class="textestado">Active</p>
                    </div>
                    <div class="botonActive">
                        <button wire:click="toggleEstado({{ $aprendiz->id }})"
                            wire:confirm="¿Quieres deshabilitar al aprendiz: {{ $aprendiz->name }}?"></button>
                    </div>
                @else
                    <div class="inactive">
                        <p class="textestado">Inactive</p>
                    </div>
                    <div class="botonInactive">
                        <button wire:click="toggleEstado({{ $aprendiz->id }})"
                            wire:confirm="¿Quieres habilitar al aprendiz: {{ $aprendiz->name }}?"></button>
                    </div>
                @endif
            </div>
        @else
            <div>

            </div>
        @endif
    </div>

    <div class="mainInfo">
        <div class="infoEstado">
            <p class="name">{{ $aprendiz->name }} {{ $aprendiz->apellido }}</p>
            <p>{{ $aprendiz->modality->name }}</p>

            <div class="eye">
                @if ($aprendiz->group_id == null)
                    <p>Sin Grupo</p>
                @else
                    <p>{{ $aprendiz->group->name }}</p>
                @endif

                <span title="Visualizar comprobante de pago" wire:click="show(1)" class="material-symbols-outlined">
                    visibility
                </span>
                <a href="{{ route('donwload', $aprendiz->id) }}">
                    <span class="material-symbols-outlined" title="Descargar documento">
                        download
                    </span>
                </a>
                @if ($aprendiz->comprobante == null && $valor == 1)
                    <small>No hay comprobante de pago</small>
                @endif
            </div>
            <div class="estado">
                <span>Estatus:</span>
                @if ($aprendiz->estado == 0)
                    <button class="inactive">Inactive</button>
                @else
                    <button class="active">active</button>
                @endif
            </div>
        </div>
        <div class="informacion">
            <p class="title">Información Personal</p>
            <div class="datos">
                <p>Nombre: <span>{{ $aprendiz->name }}</span> </p>
                <p>Apellido: <span>{{ $aprendiz->apellido }}</span> </p>
                <p>Edad: <span>{{ $edadActualizada }}</span> </p>
                <p>Fecha-Nacimiento: <span>{{ $aprendiz->fecha_nacimiento }}</span> </p>
                <p>Dirección:
                    <span>{{ isset($aprendiz->direccion) ? $aprendiz->direccion : 'No hay dirección' }}</span>
                </p>
                @if ($aprendiz->edad > 17)
                    <p>Documento: <span>{{ $aprendiz->documento ?? 'No hay documento' }}</span></p>
                @endif
                <p>Fecha-Inicio: <span>{{ $aprendiz->fecha_inicio }}</span></p>
                <p>Fecha-Finalización: <span>{{ $aprendiz->fecha_fin }}</span></p>
            </div>
        </div>
        <div class="infoAcudiente">
            <p class="title">Información Acudiente</p>
            <div class="datos">
                <p>Nombre: <span>{{ $aprendiz->attendant->name }} {{ $aprendiz->attendant->apellido }}</span>
                </p>
                <p>Email: <span>{{ $aprendiz->attendant->email }}</span>
                </p>
                <p>Telefono: <span>{{ $aprendiz->attendant->telefono }}</span>
                </p>
                @if ($aprendiz->edad < 18)
                    <p>Documento: <span>{{ $aprendiz->attendant->documento ?? 'No hay documento' }}</span></p>
                @endif
            </div>
            @if ($user->rol_id == 1)
                <a href="{{ route('viewUpdate', $aprendiz->id) }}"><button> Ir Actualizar <span
                            class="material-symbols-outlined">
                            directions_run
                        </span> </button></a>
            @endif
        </div>
        @if ($valor > 0)
            <div class="absolute">
                @if ($aprendiz->comprobante == 'Sin comprobante' || $aprendiz->comprobante == null)
                @else
                    <img src="/users/{{ $aprendiz->comprobante }}" alt="">
                    <span wire:click="show(0)" class="material-symbols-outlined close" title="Cerrar">
                        close
                    </span>
                    <a href="/users/{{ $aprendiz->comprobante }}" download="">
                        <span class="material-symbols-outlined download" title="Descargar">
                            download
                        </span>
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
