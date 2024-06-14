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
        <h2>Lista de usuarios</h2>
        <div class="containerConte">
            <div class="conteTable">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $key => $usuario)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <div class="conteImage">
                                        @if ($usuario->image)
                                            <img src="/users/{{ $usuario->image }}" alt="">
                                        @else
                                            <img src="/images/perfil.png" alt="">
                                        @endif
                                        <p>{{ $usuario->name }}</p>
                                    </div>
                                </td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->rol->name }}</td>
                                <td>
                                    @if ($usuario->id == 1)
                                        <button class="safe">Seguro</button>
                                    @else
                                        
                                    <button class="delete"
                                    wire:confirm="¿Desea eliminar el {{ $usuario->rol->name }} {{ $usuario->name }}"
                                    wire:click="eliminar({{ $usuario->id }})">Eliminar</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
