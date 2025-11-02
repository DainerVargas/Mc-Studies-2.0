<div class="componente">
    <div class="conteFiltro conteFilter" id="conteProfesor">
        <form wire:submit="filtrar">
            <div class="conteInput">
                <label for="filtro">Filtra por el nombre</label>
                <input type="text" wire:model.live="filtro" placeholder="Nombre">
            </div>
        </form>

        <div class="conteInput" style="display:flex; justify-items: start; width: 200px;">
            <label style="text-align: start; width: 100%;" for="">Fecha</label>
            <input style="width: 200px; height: 28px; border-radius: 4px; border: 1px solid #787878;" type="date" wire:model.live="date">
        </div>

        <div style="gap: 10px" class="conteBtnCreate">
            <a><button wire:click="show()" class="register">Registrar Horas</button></a>
        </div>
    </div>

    <div class="containerConte">
        <div class="conteTable">
            <table class="teacher">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Profesor</th>
                        <th>Horas</th>
                        <th>Monto</th>
                        <th>lunes</th>
                        <th>martes</th>
                        <th>miercoles</th>
                        <th>jueves</th>
                        <th>viernes</th>
                        <th>sabado</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @forelse ($registerHours as $registerHour)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td class="relative">
                                <div class="conteName">
                                    @if ($registerHour->teacher)
                                        <img src="/users/{{ $registerHour->teacher->image }}" alt="">
                                    @else
                                        <img src="/images/perfil.png" alt="">
                                    @endif
                                    <a style="cursor: pointer"
                                        wire:click="showHours({{ $registerHour->teacher->id }})">{{ $registerHour->teacher->name }}
                                        {{ $registerHour->teacher->apellido }}</a>
                                </div>
                            </td>
                            <td>
                                <p>{{ $registerHour->horas }}</p>
                            </td>
                            <td>
                                <p>{{ number_format($registerHour->horas * $registerHour->teacher->precio_hora) }}</p>
                            </td>
                            <td>
                                <p>{{ $registerHour->lunes ?? '---' }}</p>
                            </td>
                            <td>
                                <p>{{ $registerHour->martes ?? '---' }}</p>
                            </td>
                            <td>
                                <p>{{ $registerHour->miercoles ?? '---' }}</p>
                            </td>
                            <td>
                                <p>{{ $registerHour->jueves ?? '---' }}</p>
                            </td>
                            <td>
                                <p>{{ $registerHour->viernes ?? '---' }}</p>
                            </td>
                            <td>
                                <p>{{ $registerHour->sabado ?? '---' }}</p>
                            </td>
                            <td>
                                <div class="flex">
                                    <a><button wire:click="show({{ $registerHour->id }})" class="update">
                                            <span class="material-symbols-outlined">
                                                edit
                                            </span> Editar
                                        </button>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="flex">
                                    <button class="delete" wire:click="delete({{ $registerHour->id }})"
                                        wire:confirm="¿Desea elimiar el?">
                                        <span class="material-symbols-outlined">
                                            delete
                                        </span>Eliminar</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12">
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

    @if ($view != 0)
        <div class="conteUpdate">
            <div class="close">
                <span wire:click="show()" title="Cerrar" class="material-symbols-outlined">
                    close
                </span>
            </div>
            <form wire:submit="">
                <div class="conteImage">
                    <h1 style="color: #99BF51">Registro de horas</h1>
                </div>
                <div class="containerContent">
                    <select wire:model="teacher_id">
                        <option value="" selected hidden>Seleccione el profesor...</option>
                        @foreach ($profesores as $profesor)
                            <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <small class="errors" style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="containerContent">
                    <div class="conteInput">
                        <input class="input" wire:model="horas" type="number" placeholder="Horas">
                        <label class="label" for="">Horas</label>
                        @error('horas')
                            <small class="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="conteInput">
                        <input wire:model="lunes" class="input" type="date" placeholder="Lunes">
                        <label class="label" for="">Lunes</label>
                        @error('lunes')
                            <small class="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="containerContent">
                    <div class="conteInput">
                        <input wire:model="martes" class="input" type="date" placeholder="Martes">
                        <label class="label" for="">martes</label>
                        @error('Martes')
                            <small class="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="conteInput">
                        <input wire:model="miercoles" class="input" type="date" placeholder="Miercoles">
                        <label class="label" for="">Miercoles</label>
                        @error('miercoles')
                            <small class="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="containerContent">
                    <div class="conteInput">
                        <input wire:model="jueves" class="input" type="date" placeholder="Jueves">
                        <label class="label" for="">Jueves</label>
                        @error('jueves')
                            <small class="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="conteInput">
                        <input wire:model="viernes" class="input" type="date" placeholder="Viernes">
                        <label class="label" for="">Viernes</label>
                        @error('viernes')
                            <small class="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="containerContent">
                    <div class="conteInput">
                    </div>
                    <div class="conteInput">
                        <input wire:model="sabado" class="input" type="date" placeholder="Sabado">
                        <label class="label" for="">Sabado</label>
                        @error('sabado')
                            <small class="errors" style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <button style="background-color: #99BF51" wire:click="save(1)">Registrar Horas</button>
            </form>
        </div>
    @endif
    @if ($showHour)
        <div class="conteUpdate">
            <div class="close">
                <span wire:click="showHours()" title="Cerrar" class="material-symbols-outlined">
                    close
                </span>
            </div>
            <div class="conteImage">
                <h1 style="color: #99BF51">Horas del profesor - {{ $hoursDetails[0]->teacher->name }}</h1>

                <table>
                    <thead>
                        <tr>
                            <th>lunes</th>
                            <th>martes</th>
                            <th>miercoles</th>
                            <th>jueves</th>
                            <th>viernes</th>
                            <th>sabado</th>
                            <th>Horas</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalPrice = 0;
                        @endphp
                        @foreach ($hoursDetails as $detail)
                            <tr>
                                <td>
                                    <p>{{ $detail->lunes ?? '---' }}</p>
                                </td>
                                <td>
                                    <p>{{ $detail->martes ?? '---' }}</p>
                                </td>
                                <td>
                                    <p>{{ $detail->miercoles ?? '---' }}</p>
                                </td>
                                <td>
                                    <p>{{ $detail->jueves ?? '---' }}</p>
                                </td>
                                <td>
                                    <p>{{ $detail->viernes ?? '---' }}</p>
                                </td>
                                <td>
                                    <p>{{ $detail->sabado ?? '---' }}</p>
                                </td>
                                <td>{{ $detail->horas }}</td>
                                @php
                                    $totalPrice += $detail->horas * $detail->teacher->precio_hora;
                                @endphp
                                <td>{{ number_format($detail->horas * $detail->teacher->precio_hora, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="7" style="text-align: right; font-weight: bold;">Total General:</td>
                            <td style="font-weight: bold;">{{ number_format($totalPrice, 2) }}</td>
                    </tbody>
                </table>
            </div>
            <div class="flex">
                <button class="button" wire:click="donwload({{ $hoursDetails[0]->teacher->id }})">Descargar</button>
            </div>
        </div>
    @endif

    <style>
        .conteImage h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: #99BF51;
            text-align: center;
            margin-bottom: 25px;
        }

        .conteImage {
            height: 84%;
            overflow-y: auto;
        }

        .conteImage table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .conteImage thead {
            background-color: #f5f7fa;
            color: #333;
            font-weight: 600;
            text-transform: capitalize;
        }

        .conteImage thead th {
            padding: 12px;
            border-bottom: 2px solid #e0e0e0;
            text-align: center;
        }

        .conteImage tbody td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }

        .conteImage tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .conteImage tbody tr:hover {
            background-color: #f0f8e7;
        }

        /* Botón Descargar */
        .flex {
            display: flex;
            justify-content: center;
            margin-top: 25px;
        }

        .flex .button {
            background-color: #99BF51;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 22px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .flex .button:hover {
            background-color: #8ab44a;
            box-shadow: 0 4px 10px rgba(153, 191, 81, 0.4);
            transform: translateY(-2px);
        }
    </style>
</div>
