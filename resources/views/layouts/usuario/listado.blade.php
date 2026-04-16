@extends('layouts.usuario')
@section('title', 'Listado Usuarios')

@section('listado')
    <div class="user-table-card">
        <div class="header-listado"
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Lista de usuarios</h2>
            <form action="{{ route('listado') }}" method="GET" class="search-container"
                style="position: relative; width: 300px;">
                <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por nombre o email..."
                    style="width: 100%; padding: 10px 15px; border-radius: 10px; border: 1px solid #ddd; outline: none; font-size: 0.9rem;"
                    onchange="this.form.submit()">
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="color: green; margin-bottom: 15px;">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" style="color: red; margin-bottom: 15px;">{{ session('error') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
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
                        <td>{{ $usuario->usuario }}</td>
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
                                <form action="{{ route('user.destroy', $usuario->id) }}" method="POST"
                                    onsubmit="return confirm('¿Desea eliminar el {{ $usuario->rol->name }} {{ $usuario->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete">
                                        Eliminar
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
