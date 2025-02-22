<div class="componente">
    <div class="conteFiltro">
        <form>
            <div class="conteInput">
                <label for="filtro">Filtra por el nombre del aprendiz</label>
                <input type="text" wire:model.live="nameAprendiz" placeholder="Nombre del Aprendiz">
            </div>
            <button type="submit" class="btnFiltro">Buscar</button>
        </form>
    </div>

    <div class="conteSelect">
        <select wire:model.live="grupo">
            <option value="all" selected>Filtra por grupos</option>
            <option value="none">Sin grupos</option>
            @foreach ($grupos as $grupoItem)
                <option value="{{ $grupoItem->id }}">{{ $grupoItem->name }}</option>
            @endforeach
        </select>
        
        <div class="conteChecks">
            <div class="conteRadio">
                <input wire:model.live="estado" value="all" type="radio" id="option1">
                <label for="option1">Todos</label>
            </div>
            <div class="conteRadio">
                <input wire:model.live="estado" value="active" type="radio" id="option2">
                <label for="option2">Active</label>
            </div>
            <div class="conteRadio">
                <input wire:model.live="estado" value="inactive" type="radio" id="option3">
                <label for="option3">Inactive</label>
            </div>
        </div>
    </div>

    <div class="containerConte">
        <div class="conteTable">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Aprendiz</th>
                        <th>Grupo</th>
                        <th>Estado</th>
                        @if ($user->rol_id == 1)
                            <th>Actualizar</th>
                            <th>Eliminar</th>
                        @else
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @forelse ($aprendices as $aprendiz)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td class="relative">
                                <div class="conteName">
                                    @if ($aprendiz->imagen)
                                        <img src="/users/{{ $aprendiz->imagen }}" alt="">
                                    @else
                                        <img src="/images/perfil.png" alt="">
                                    @endif
                                    <a href="{{ route('informacion', $aprendiz->id) }}">{{ $aprendiz->name }}
                                        {{ $aprendiz->apellido }}</a>
                                </div>
                                @if ($aprendiz->group_id == null || $aprendiz->group->teacher_id == null)
                                    <div class="new">
                                        <small>new</small>
                                    </div>
                                @endif
                            </td>
                            @php
                                if ($aprendiz->group_id == null) {
                                    $grupo = 'Sin grupo';
                                } else {
                                    $grupo = $aprendiz->group->name;
                                }
                            @endphp
                            <td>{{ $grupo }}</td>
                            @php
                                $estado = $aprendiz->estado == 1 ? 'active' : 'inactive';
                            @endphp
                            <td>
                                <div class="flex">
                                    <button class="{{ $estado }}">{{ $estado }}</button>
                                </div>
                            </td>
                            @if ($user->rol_id == 1)
                                <td>
                                    <div class="flex">
                                        <a href="{{ route('viewUpdate', $aprendiz->id) }}"><button class="update">
                                                <span class="material-symbols-outlined">
                                                    edit
                                                </span>
                                                Editar</button></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex">
                                        <button class="delete" wire:click="delete({{ $aprendiz->id }})"
                                            wire:confirm="¿Desea elimiar el aprendiz {{ $aprendiz->name }}?"><span
                                                class="material-symbols-outlined">
                                                delete
                                            </span> Eliminar</button>
                                    </div>
                                </td>
                            @else
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <p class="nodatos">No hay datos</p>
                                <video class="video" src="/videos/video2.mp4" height="180vw" autoplay loop>
                                    <source src="/videos/video2.mp4" type="">
                                </video>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
