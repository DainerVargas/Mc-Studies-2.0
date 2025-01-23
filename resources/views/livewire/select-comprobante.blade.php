<div class="conteForm">
    <form wire:submit="">
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
        <div class="containerContents">
            <div class="conteInput">
                <label for="" class="labels">Edad</label>
                <input type="number" min="3" max="90" class="inputs" wire:model.live="edad"
                    placeholder="Edad" value="{{ old('edad') }}">
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
        <div class="containerContents top">
            <div class="conteInput">
                <label for="" class="labels">Dirección</label>
                <input type="text" class="inputs" wire:model="direccion" placeholder="Dirección"
                    value="{{ old('direccion') }}">
                @error('direccion')
                    <small class="errors" style="color red">{{ $message }}</small>
                @enderror
            </div>
        </div>
        @if ($edad >= 18)
            <div class="containerContents top">
                <div class="conteInput">
                    <label for="" class="labels">Email</label>
                    <input type="text" class="inputs" wire:model="email" placeholder="email"
                        value="{{ old('email') }}">
                    @error('email')
                        <small class="errors" style="color red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="conteInput">
                    <label for="" class="labels">Teléfono</label>
                    <input type="text" class="inputs" wire:model="telefono" placeholder="Teléfono"
                        value="{{ old('telefono') }}">
                    @error('telefono')
                        <small class="errors" style="color red">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @endif
        @if ($edad < 18)
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
                    <label for="" class="labels">Teléfono</label>
                    <input type="text" class="inputs" wire:model="telefonoAcudiente" placeholder="Teléfono"
                        value="{{ old('telefono') }}">
                    @error('telefonoAcudiente')
                        <small class="errors" style="color red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="conteInput">
                    <label for="" class="labels">Email</label>
                    <input type="text" class="inputs" wire:model="emailAcudiente" placeholder="Email"
                        value="{{ old('email') }}">
                    @error('emailAcudiente')
                        <small class="errors" style="color red">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        @else
        @endif
        <h2>¿Cúal modalidad te gustaría adquirir?</h2>
        <div class="modalidad">
            <div class="pagomensual">
                <div class="titulo">
                    <p>Pago mensual</p>
                </div>
                <div class="informacion">
                    <p>Pago mensual durante 4 meses:</p>
                    <strong class="valor">$300.000<small>/un mes</small></strong>
                </div>
                <div class="plataforma">
                    <p>Plataforma virtual de aprendizaje </p>
                    <span>$140.000</span>
                </div>
                <div class="informacion">
                    <small>Valor total del módulo:</small>
                    <strong class="valor">$440.000<small>/primer mes</small></strong>
                    <strong class="valor">$300.000<small>/tres pagos durante el módulo</small></strong>
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
                    <p>Pago completo</p>
                    <small>Most popular</small>
                </div>
                <div class="informacion">
                    <p>Pago total del módulo $900.000 pesos, este cuenta con un 10% de descuento:
                    </p>
                    <strong class="valor">$810.000<small>/cuatro meses</small></strong>
                </div>
                <div class="plataforma">
                    <p>Plataforma virtual de aprendizaje</p>
                    <span>$140.000</span>
                </div>
                <div class="informacion">
                    <small>Valor total del módulo:</small>
                    <strong class="valor">$950.000<small>/un solo pago</small></strong>
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
                    <p>Pago a dos cuotas</p>
                </div>
                <div class="informacion">
                    <p>Dos pagos en el transcurso del módulo:</p>
                    <strong class="valor">$450.000<small>/dos meses</small></strong>
                </div>
                <div class="plataforma">
                    <p>Plataforma virtual de aprendizaje</p>
                    <span>$140.000</span>
                </div>
                <div class="informacion">
                    <small>Valor total del módulo:</small>
                    <strong class="valor">$590.000<small>/dos meses</small></strong>
                    <strong class="valor">$450.000<small>/dos pagos durante el módulo</small></strong>
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
            <div class="pagodoscuotas">
                <div class="titulo">
                    <p>Pago clases personalizadas</p>
                </div>
                <div class="informacion">
                    <p>Escribe el valor según las horas semanales seleccionadas</p>
                    <p>Valor del plan:</p> <br>
                    <br>
                    <div class="conteInput">
                        <input type="number" class="input" wire:model.live="valor" placeholder="Ingrese el valor">
                        <label for="" class="label">Ingrese el valor</label>
                    </div>
                    <div class="plataforma">
                        <p>Plataforma virtual de aprendizaje</p>
                        <span>(No aplica)</span>
                    </div>
                    <div class="informacion">
                        <small>Valor total del módulo:</small>
                        <strong class="valor">{{ $valor }}<small></small></strong>
                    </div>
                    <div class="conteBtn">
                        <button type="button" wire:click="modalidad(4)" class="btnModulo">Adquirir plan</button>
                    </div>
                    @if ($modality_id == 4)
                        <div class="absolute">
                            <p>Adquirido</p>
                        </div>
                    @endif
                    <small class="errors smallErrors" style="color: red">{{ $error }}</small>
                </div>
            </div>
        </div>

        <div class="metodosPagos">
            <h2>Seleccione un método de Pago</h2>
            <div class="colum">
                <div class="bancolombia bancolombia{{ $comprobante }}" wire:click="active(2)">
                    <div class="imagen">
                        <img src="/images/transferencia.png" alt="">
                    </div>
                    <p>Método: <span>Transferencia electrónica</span></p>
                    <p>Cuenta: <span>72400002457</span></p>
                    <p>Nombre: <span>MC Language S.A.S .</span></p>
                    <p>Nit: <span>901809528-9</span></p>
                </div>
                <div class="pagoFisico pagoFisico{{ $comprobante }}" wire:click="active(1)"">
                    <div class="imagen">
                        <img src="/images/efectivo.png" alt="">
                    </div>
                    <p>Método: <span>Efectivo</span></p>
                    <p>Dirección: <span>calle 10 #18-25</span></p>
                    <p>Telefono: <span>3173961175</span></p>
                    <p>Email: <span>info@mcstudies.com</span></p>
                </div>
            </div>
        </div>
        @if ($comprobante == 2)
            <div class="boton">
                <button disabled class="btnRegistro">Aun no está dispoblie <small
                        wire:loading="" >Cargando...</small></button>
            </div>
        @elseif ($comprobante == 1)
            <div class="boton">
                <button wire:click="createApprentice" class="btnRegistro">¡REGISTRARME! <small
                    wire:loading="createApprentice" >Cargando...</small></button>
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
