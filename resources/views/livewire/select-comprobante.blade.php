<div class="conteForm">
    <form wire:submit="store">
        @csrf
        <h2>Datos del Estudiante</h2>
        <div class="containerContents">
            <div class="conteInput">
                <label for="" class="labels">Nombre</label>
                <input type="text" class="inputs" wire:model="name" placeholder="Nombre" value="{{ old('name') }}">
                @error('name')
                    <small class="errors" style="color red">{{ $message }}</small>
                @enderror
            </div>
            <div class="conteInput">
                <label for="" class="labels">Apellido</label>
                <input type="text" class="inputs" wire:model="apellido" placeholder="Apellido"
                    value="{{ old('apellido') }}">
                @error('apellido')
                    <small class="errors" style="color red">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="containerContents top">
            <div class="conteInput">
                <label for="" class="labels">Edad</label>
                <input type="number" min="3" max="90" class="inputs" wire:model="edad" placeholder="Edad"
                    value="{{ old('edad') }}">
                @error('edad')
                    <small class="errors" style="color red">{{ $message }}</small>
                @enderror
            </div>
            <div class="conteInput">
                <label for="" class="labels">Fecha Nacimiento</label>
                <input type="date" class="inputs" wire:model="fecha_nacimiento" placeholder="fecha"
                    value="{{ old('apellido') }}">
                @error('fecha_nacimiento')
                    <small class="errors" style="color red">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <h2>Datos del Acudiente</h2>
        <div class="containerContents">
            <div class="conteInput">
                <label for="" class="labels">Nombre</label>
                <input type="text" class="inputs" wire:model="nameAcudiente" placeholder="Nombre Acudiente"
                    value="{{ old('nameAcudiente') }}">
                @error('nameAcudiente')
                    <small class="errors" style="color red">{{ $message }}</small>
                @enderror
            </div>
            <div class="conteInput">
                <label for="" class="labels">Apellido</label>
                <input type="text" class="inputs" wire:model="apellidoAcudiente" placeholder="apellido Acudiente"
                    value="{{ old('apellidoAcudiente') }}">
                @error('apellidoAcudiente')
                    <small class="errors" style="color red">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="containerContents top">
            <div class="conteInput">
                <label for="" class="labels">Telefono</label>
                <input type="text" class="inputs" wire:model="telefono" placeholder="Telefono"
                    value="{{ old('telefono') }}">
                @error('telefono')
                    <small class="errors" style="color red">{{ $message }}</small>
                @enderror
            </div>
            <div class="conteInput">
                <label for="" class="labels">Email</label>
                <input type="text" class="inputs" wire:model="email" placeholder="Email"
                    value="{{ old('email') }}">
                @error('email')
                    <small class="errors" style="color red">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <h2>¿Cual modalidad te gustaría adquirir?</h2>
        <div class="modalidad">
            <div class="pagomensual">
                <div class="titulo">
                    <p>Pago Mensual</p>
                </div>
                <div class="informacion">
                    <p>Pago mensual durante 4 meses sin descuento sería de:</p>
                    <strong class="valor">$200.000<small>/1 mes</small></strong>
                </div>
                <div class="plataforma">
                    <p>Acceso a la plataforma Valor </p>
                    <span>$120.000</span>
                </div>
                <p class="info">Por consignación. Ten en cuenta que, si realizas consignación fuera del
                    departamento de La
                    Guajira, debes asumir el costo de $14.000 pesos.</p>
                <div class="informacion">
                    <small>Valor total del modulo:</small>
                    <strong class="valor">$320.000<small>/1 mes</small></strong>
                </div>
                <div class="conteBtn">
                    <button type="button" wire:click="modalidad(1)" class="btnModulo">Adquirir plan</button>
                </div>
                @if ($modality_id == 1)
                    <div class="absolute">
                        <p>Adquirido</p>
                    </div>
                @endif
            </div>
            <div class="pagocompleto">
                <div class="titulo">
                    <p>Pago Completo</p>
                    <small>Most popular</small>
                </div>
                <div class="informacion">
                    <p>Pago total del modulo $800.000 pesos, este cuenta con un 10% de descuento, el valor sería de:
                    </p>
                    <strong class="valor">$720.000<small>/4 meses</small></strong>
                </div>
                <div class="plataforma">
                    <p>Acceso a la plataforma Valor </p>
                    <span>$120.000</span>
                </div>
                <p class="info">Por consignación. Ten en cuenta que, si realizas consignación fuera del
                    departamento de La
                    Guajira, debes asumir el costo de $14.000 pesos.</p>
                <div class="informacion">
                    <small>Valor total del modulo:</small>
                    <strong class="valor">$840.000<small>/4 meses</small></strong>
                </div>
                <div class="conteBtn">
                    <button type="button" wire:click="modalidad(3)" class="btnModulo completo">Adquirir
                        plan</button>
                </div>
                @if ($modality_id == 3)
                    <div class="absolute">
                        <p>Adquirido</p>
                    </div>
                @endif
            </div>
            <div class="pagodoscuotas">
                <div class="titulo">
                    <p>Pago a dos Cuotas</p>
                </div>
                <div class="informacion">
                    <p>Dos pagos en el transcurso del módulo sin descuentos, sería de:</p>
                    <strong class="valor">$400.000<small>/2 meses</small></strong>
                </div>
                <div class="plataforma">
                    <p> Más el acceso a la plataforma </p>
                    <span>$120.000</span>
                </div>
                <p class="info">Por consignación. Ten en cuenta que, si realizas consignación fuera del
                    departamento de La
                    Guajira, debes asumir el costo de $14.000 pesos.</p>
                <div class="informacion">
                    <small>Valor total del modulo:</small>
                    <strong class="valor">$520.000<small>/2 meses</small></strong>
                </div>
                <div class="conteBtn">
                    <button type="button" wire:click="modalidad(2)" class="btnModulo">Adquirir plan</button>
                </div>
                @if ($modality_id == 2)
                    <div class="absolute">
                        <p>Adquirido</p>
                    </div>
                @endif
                <input type="text" wire:model="modality_id" hidden>
                @error('modality_id')
                    <small class="errors smallErrors" style="color: red">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <h2>Seleccione un metodo de Pago</h2>

        <div class="metodosPagos">
            <div class="bancolombia bancolombia{{$comprobante}}" wire:click="active(2)">
                <img src="/images/Bancolombia2.png" alt="">
                <p>Cuenta: <span>72445855970</span></p>
                <p>Nombre: <span>MC Studies S.A.S</span></p>
                <p>Nit: <span>900870738-3</span></p>
            </div>
            <div class="pagoFisico pagoFisico{{$comprobante}}" wire:click="active(1)"">
                <img src="/images/fisico.png" alt="">
                <p>Dirección: <span>calle 10 #18-25</span></p>
                <p>Telefono: <span>3173961175</span></p>
                <p>Email: <span>info.mcstudies@gmail.com</span></p>
            </div>
        </div>
        @if ($comprobante > 1)
            <h2>Sube tu comprobate de pago</h2>
            <div class="comprobante">
                <input type="file" id="comprobante" wire:model="imagen" accept="image/*" hidden>
                <label for="comprobante">
                    @if ($imagen)
                        <img class="perfil" src="{{ $imagen->temporaryUrl() }}" alt="">
                    @else
                        <img src="/images/comprobante.png" alt="Click para subir comprobante">
                    @endif
                </label>
                <div class="absolute" wire:loading>
                    <span class="material-symbols-outlined loading" >
                        directory_sync
                    </span>
                </div>
                @error('comprobante')
                    <small class="errors top" style="color: red">{{ $message }}</small>
                @enderror
            </div>
        @endif
        @if ($comprobante >= 1)
            <div class="boton">
                <button type="submit" class="btnRegistro">¡REGISTRARME! <small wire:loading="store">Cargando...</small></button>
            </div>
        @endif

        <p class="success" style="color: green">{{ $success }}</p>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</div>
