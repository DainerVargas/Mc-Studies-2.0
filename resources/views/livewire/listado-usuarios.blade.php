<div class="user-table-card">
    <div class="header-listado"
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Lista de usuarios</h2>
        <div class="search-container" style="position: relative; width: 300px;">
            <input type="text" wire:model.live="search" placeholder="Buscar por nombre o email..."
                style="width: 100%; padding: 10px 15px; border-radius: 10px; border: 1px solid #ddd; outline: none; font-size: 0.9rem;">
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $key => $usuario)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <div class="user-info-cell">
                            @if ($usuario->image)
                                <img src="/users/{{ $usuario->image }}" class="avatar-small" alt="{{ $usuario->name }}">
                            @else
                                <img src="/images/perfil.png" class="avatar-small" alt="Default">
                            @endif
                            <span class="user-name">{{ $usuario->name }}</span>
                        </div>
                    </td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        <span class="role-badge">
                            {{ $usuario->rol->name }}
                        </span>
                    </td>
                    <td>
                        @if ($usuario->rol_id == 1)
                            <button class="btn-action safe">Protegido</button>
                        @else
                            <button class="btn-action delete"
                                wire:confirm="¿Desea eliminar el {{ $usuario->rol->name }} {{ $usuario->name }}?"
                                wire:click="eliminar({{ $usuario->id }})">
                                Eliminar
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
