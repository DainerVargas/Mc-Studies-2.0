<div class="componente">
    <div class="conteFiltro" id="conteProfesor">
        <form>
            <div class="conteInput">
                <label for="filtro">Filtra por el nombre del Grupo</label>
                <input type="text" wire:model.live="filtroName" placeholder="Nombre del Grupo">
            </div>
        </form>
        <div class="conteSelect ">
            <div class="conteChecks">
                <div class="conteRadio">
                    <input wire:model.live="estado" value="" type="radio" checked="" id="option1">
                    <label for="option1">Todos</label>
                </div>
                <div class="conteRadio">
                    <input wire:model.live="estado" value="active" type="radio" id="option2">
                    <label for="option2">Mc-Kids</label>
                </div>
                <div class="conteRadio">
                    <input wire:model.live="estado" value="inactive" type="radio" id="option3">
                    <label for="option3">Mc-Teens</label>
                </div>
            </div>
        </div>
        <div class="conteBtnCreate">
            <a><button wire:click="update"><img src="/images/grupo2.png" alt="">
                    Crear</button></a>
        </div>
    </div>

    <div class="containerConte">
        <div class="conteTable">
            <table class="grupo">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nombre del Grupo</th>
                        <th>Profesor</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                        $cantidad = 0;
                    @endphp
                    @forelse ($grupos ?? [] as $grupo)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td style="cursor: pointer" class="relative" wire:click="verDetalle({{ $grupo->id }})">
                                {{ $grupo->name }}
                            </td>
                            @if (!$grupo->teacher)
                                <td>Sin Profesor</td>
                            @else
                                <td>{{ $grupo->teacher->name }} {{ $grupo->teacher->apellido }}</td>
                            @endif

                            <td>{{ $grupo->type->name }}</td>
                            <td>{{ count($grupo->apprentice) }}</td>
                            @php
                                $cantidad += count($grupo->apprentice);
                            @endphp
                            <td>
                                <div class="flex">
                                    <a><button type="button" class="update"
                                            wire:click="actualizar({{ $grupo->id }})"><span
                                                class="material-symbols-outlined">
                                                edit
                                            </span> Editar</button></a>
                                </div>
                            </td>
                            <td>
                                <div class="flex">
                                    <button class="delete" wire:click="delete({{ $grupo->id }})"
                                        wire:confirm="¿Desea elimiar el grupo {{ $grupo->name }} ?"><span
                                            class="material-symbols-outlined">
                                            delete
                                        </span> Eliminar</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <p class="nodatos">No hay datos</p>
                                <video class="video" src="/videos/video2.mp4" height="180vw" autoplay loop>
                                    <source src="/videos/video2.mp4" type="">
                                </video>
                            </td>
                        </tr>
                    @endforelse
                    <td id="start" colspan="4">Total cantidad:</td>
                    <td class="cantidad">{{ $cantidad }}</td>
                </tbody>
            </table>
        </div>
    </div>

    @if ($view != 0)
        <div class="conteUpdate">
            <div class="close">
                <span wire:click="ocultar" title="Cerrar" class="material-symbols-outlined">
                    close
                </span>
            </div>
            <form wire:submit="" id="formgroup">
                <div class="contetitulo">
                    <h1>CREAR UN GRUPO</h1>
                </div>
                <div class="containerContent">
                    <div class="conteInput">
                        <input wire:model.live="filtroTeacher" class="input" type="text" placeholder="nombre"
                            name="" id="">
                        <label class="label" for="">Filtrar</label>
                    </div>
                    <select name="teacher_id" wire:model="teacher_id" id="">
                        <option value="">Seleccione...</option>
                        @foreach ($profesores as $profesor)
                            @if ($profesor->type_teacher_id == 1 || $profesor->type_teacher_id == 2)
                                <option value="{{ $profesor->id }}">{{ $profesor->name }} -
                                    {{ $profesor->type_teacher->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <small class="errors" style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="containerContent">
                    <div class="conteInput">
                        <input class="input" wire:model="name" type="text" placeholder="name">
                        <label class="label" for="">Nombre del Grupo</label>
                        @error('name')
                            <small class="errors" id="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                    <select wire:model="type_id" name="" id="">
                        <option value="" selected hidden>Seleccione el tipo...</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('type_id')
                        <small class="errors" id="errors" style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="conteBtn">
                    <button class="cancelar" wire:click="ocultar">Cancelar</button>
                    <button class="registrar" wire:click="save">Registrar</button>
                </div>
            </form>
        </div>
    @endif

    @if ($view2 != 0)
        <div class="conteUpdate" id="updateGroup">
            <div class="close">
                <span wire:click="ocultar" title="Cerrar" class="material-symbols-outlined">
                    close
                </span>
            </div>
            <form wire:submit="" id="formgroup">
                <div class="containerContent">
                    <div class="conteInput">
                        <input class="input" wire:model="grupoNmae" type="text" placeholder="name">
                        <label class="label" for="">Nombre del Grupo</label>
                        @error('grupoNmae')
                            <small class="errors" id="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="conteInput">
                        <select name="teacher_id" wire:model="profesor_id" id="">
                            <option value="" selected hidden>seleccione...</option>
                            @if (isset($profesorName))
                                <option selected value="{{ $profesorName->id }}"> {{ $profesorName->name }}
                                </option>
                                @foreach ($profesores as $profesor)
                                    @if ($profesorName->id != $profesor->id)
                                        <option value="{{ $profesor->id }}">{{ $profesor->name }} </option>
                                    @endif
                                @endforeach
                            @else
                                @foreach ($profesores as $profesor)
                                    <option value="{{ $profesor->id }}">{{ $profesor->name }} </option>
                                @endforeach
                            @endif
                        </select>
                        @error('profesor_id')
                            <small class="errors" id="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="conteBtn">
                    <button class="registrar" wire:click="guardar({{ $grupoId }})">Actualizar</button>
                </div>
            </form>
        </div>
    @endif

    @if ($show)
        <div class="conteUpdate">
            <div class="close">
                <span wire:click="ocultar" title="Cerrar" class="material-symbols-outlined">
                    close
                </span>
            </div>

            <div class="conteDetalle">
                <div class="headerDetalle">
                    <div>
                        <h2>Detalle del Grupo: <span>{{ $groupName }}</span></h2>
                        <h3>Profesor: <span>{{ $nameTeacher }}</span></h3>
                        <h3>Tipo de Grupo: <span>{{ $typeGroup }}</span></h3>
                    </div>

                    <button wire:click="descargarReporte" class="btn-descargar">
                        <span class="material-symbols-outlined">download</span>
                        Descargar Reporte
                    </button>
                </div>

                <div class="grafica">
                    @foreach ($qualifications as $semestre => $data)
                        <div class="bar-container">
                            <span class="label">Semestre {{ $semestre }}</span>

                            <div class="bars">
                                @foreach (['listening', 'writing', 'reading', 'speaking', 'global'] as $key)
                                    @php
                                        $value = $data[$key];
                                        if ($key === 'global') {
                                            $color = '#99BF51';
                                        } else {
                                            $color = $value >= 75 ? '#05CCD1' : '#E74C3C';
                                        }
                                    @endphp
                                    <div class="bar"
                                        style="width: {{ $value }}%; background-color: {{ $color }}">
                                        <span>{{ ucfirst($key) }} {{ $value }}%</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <style>
        .conteUpdate {
            position: relative;
            background: #fff;
            border-radius: 16px;
            padding: 30px 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow-y: auto;
            max-height: 90vh;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            cursor: pointer;
        }

        .material-symbols-outlined {
            font-size: 26px;
            color: #777;
            transition: color 0.3s;
        }

        .material-symbols-outlined:hover {
            color: #99BF51;
        }

        .headerDetalle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .headerDetalle h2 {
            font-size: 22px;
            color: #333;
            font-weight: 700;
        }

        .headerDetalle h2 span {
            color: #99BF51;
        }

        .headerDetalle h3 {
            font-size: 16px;
            color: #666;
        }

        .headerDetalle h3 span {
            color: #333;
            font-weight: 600;
        }

        .btn-descargar {
            background: #99BF51;
            border: none;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 20px; 
        }

        .btn-descargar:hover {
            background: #7da63d;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(153, 191, 81, 0.4);
        }

        .grafica {
            display: flex;
            flex-direction: column;
            gap: 35px;
            max-height: 430px;
            overflow: hidden;
            overflow: scroll;
            padding-right: 10px;
            scrollbar-width: thin;
            max-width: 100%;
        }

        .bar-container {
            padding: 10px 0;
        }

        .label {
            font-weight: 700;
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
            display: inline-block;
        }

        .bars {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .bar {
            position: relative;
            border-radius: 8px;
            height: 28px;
            transition: width 0.6s ease-in-out, background-color 0.3s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .bar span {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 13px;
            font-weight: 600;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</div>
