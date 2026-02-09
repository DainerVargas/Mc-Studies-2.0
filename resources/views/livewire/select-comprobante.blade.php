<div class="src-container">
    <div class="src-form-card">
        <form wire:submit.prevent="">
            @csrf
            <h2>Datos del Estudiante</h2>
            <div class="src-grid">
                <div class="src-input-group">
                    <label>Nombre</label>
                    <input type="text" wire:model="name" placeholder="Ej: Juan">
                    @error('name')
                        <span class="src-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="src-input-group">
                    <label>Apellido</label>
                    <input type="text" wire:model="apellido" placeholder="Ej: Perez">
                    @error('apellido')
                        <span class="src-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="src-grid">
                <div class="src-input-group">
                    <label>Edad</label>
                    <input type="number" min="3" max="90" wire:model.live="edad" placeholder="00">
                    @error('edad')
                        <span class="src-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="src-input-group">
                    <label>Fecha de Nacimiento</label>
                    <input type="date" wire:model="fecha_nacimiento">
                    @error('fecha_nacimiento')
                        <span class="src-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="src-grid">
                <div class="src-input-group">
                    <label>Dirección</label>
                    <input type="text" wire:model="direccion" placeholder="Calle, Carrera, No.">
                    @error('direccion')
                        <span class="src-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="src-input-group">
                    <label>Sede de Estudio</label>
                    <select wire:model="sede_id">
                        <option value="" selected hidden>Selecciona una sede...</option>
                        <option value="1">Fonseca</option>
                        <option value="2">San Juan</option>
                    </select>
                    @error('sede_id')
                        <span class="src-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            @if ($edad >= 18)
                <div class="src-grid">
                    <div class="src-input-group">
                        <label>Email</label>
                        <input type="email" wire:model="email" placeholder="ejemplo@correo.com">
                        @error('email')
                            <span class="src-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="src-input-group">
                        <label>Teléfono / WhatsApp</label>
                        <input type="text" wire:model="telefono" placeholder="+57 321 ...">
                        @error('telefono')
                            <span class="src-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="src-grid">
                    <div class="src-input-group">
                        <label>Documento de Identidad</label>
                        <input type="text" wire:model="documento" placeholder="C.C. / T.I.">
                        @error('documento')
                            <span class="src-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif

            @if ($edad > 0 && $edad < 18)
                <h2 class="src-section-title">Datos del Acudiente</h2>
                <div class="src-grid">
                    <div class="src-input-group">
                        <label>Nombre del Acudiente</label>
                        <input type="text" wire:model="nameAcudiente" placeholder="Nombre completo">
                        @error('nameAcudiente')
                            <span class="src-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="src-input-group">
                        <label>Apellido del Acudiente</label>
                        <input type="text" wire:model="apellidoAcudiente" placeholder="Apellido">
                        @error('apellidoAcudiente')
                            <span class="src-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="src-grid">
                    <div class="src-input-group">
                        <label>Teléfono</label>
                        <input type="text" wire:model="telefonoAcudiente" placeholder="Celular de contacto">
                        @error('telefonoAcudiente')
                            <span class="src-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="src-input-group">
                        <label>Email</label>
                        <input type="email" wire:model="emailAcudiente" placeholder="correo@acudiente.com">
                        @error('emailAcudiente')
                            <span class="src-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="src-grid">
                    <div class="src-input-group">
                        <label>Documento del Acudiente</label>
                        <input type="text" wire:model="documentoAcudiente" placeholder="C.C.">
                        @error('documentoAcudiente')
                            <span class="src-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif

            <h2 class="src-section-title">Selecciona tu modalidad</h2>
            <div class="src-modalidades-grid">
                {{-- Pago Mensual --}}
                <div class="src-plan-card {{ $modality_id == 1 ? 'src-active' : '' }}" wire:click="modalidad(1)">
                    <div class="src-plan-badge">Adquirido</div>
                    <div class="src-plan-title">Pago Mensual</div>
                    <div class="src-plan-info">
                        <p>Divide el costo total del módulo en pagos mensuales cómodos.</p>
                        <strong class="src-price-big">$1.1M<small>/4 meses</small></strong>
                    </div>
                    <div class="src-plan-features">
                        <span>$460k</span>
                        <small>Primer pago (Inc. Plataforma)</small>
                    </div>
                    <button type="button" class="src-btn-plan" wire:click.stop="modalidad(1)">Seleccionar Plan</button>
                </div>

                {{-- Pago Completo --}}
                <div class="src-plan-card src-popular {{ $modality_id == 3 ? 'src-active' : '' }}"
                    wire:click="modalidad(3)">
                    <div class="src-plan-badge">Adquirido</div>
                    <div class="src-plan-title">Pago Completo</div>
                    <div class="src-plan-info">
                        <p>Obtén un 10% de descuento pagando el módulo por adelantado.</p>
                        <strong class="src-price-big">$1.15M<small>/Inc. Plataforma</small></strong>
                    </div>
                    <div class="src-plan-features">
                        <span>Ahorro del 10%</span>
                        <small>Incluido en el valor total</small>
                    </div>
                    <button type="button" class="src-btn-plan" wire:click.stop="modalidad(3)">Seleccionar
                        Plan</button>
                </div>

                {{-- Pago Dos Cuotas --}}
                <div class="src-plan-card {{ $modality_id == 2 ? 'src-active' : '' }}" wire:click="modalidad(2)">
                    <div class="src-plan-badge">Adquirido</div>
                    <div class="src-plan-title">Dos Cuotas</div>
                    <div class="src-plan-info">
                        <p>Realiza dos pagos iguales durante el desarrollo del módulo.</p>
                        <strong class="src-price-big">$1.1M<small>/4 meses</small></strong>
                    </div>
                    <div class="src-plan-features">
                        <span>$600k</span>
                        <small>Primer pago (Inc. Plataforma)</small>
                    </div>
                    <button type="button" class="src-btn-plan" wire:click.stop="modalidad(2)">Seleccionar
                        Plan</button>
                </div>

                {{-- Personalizado --}}
                <div class="src-plan-card {{ $modality_id == 4 ? 'src-active' : '' }}" wire:click="modalidad(4)">
                    <div class="src-plan-badge">Adquirido</div>
                    <div class="src-plan-title">Personalizado</div>
                    <div class="src-plan-info">
                        <p>Ajusta el valor según tus horas semanales de clases privadas.</p>
                        <div class="src-input-group">
                            <input type="number" wire:model.live="valor" placeholder="Ingresa el valor pactado"
                                onclick="event.stopPropagation()">
                        </div>
                    </div>
                    <div class="src-plan-features">
                        <span>Personalizado</span>
                        <small>Según acuerdo previo</small>
                    </div>
                    <button type="button" class="src-btn-plan" wire:click.stop="modalidad(4)">Seleccionar
                        Plan</button>
                </div>
            </div>
            @error('modality_id')
                <div class="src-error" style="text-align: center; margin-top: -30px; margin-bottom: 20px;">Debe
                    seleccionar una modalidad</div>
            @enderror

            <h2 class="src-section-title">Método de Pago</h2>
            <div class="src-payment-methods">
                <div class="src-method-card {{ $comprobante == 2 ? 'src-active' : '' }}" wire:click="active(2)">
                    <img src="/images/transferencia.png" alt="Transferencia">
                    <div class="src-method-info">
                        <p><span>Transferencia Bancaria</span></p>
                        <p>Bancolombia: <span>72400002457</span></p>
                        <p>NIT: <span>901809528-9</span></p>
                    </div>
                </div>

                <div class="src-method-card {{ $comprobante == 1 ? 'src-active' : '' }}" wire:click="active(1)">
                    <img src="/images/efectivo.png" alt="Efectivo">
                    <div class="src-method-info">
                        <p><span>Pago en Efectivo</span></p>
                        <p>Dirección: <span>Calle 10 #18-25</span></p>
                        <p>Fonseca, La Guajira</p>
                    </div>
                </div>
            </div>

            <div class="src-register-footer">
                @if ($comprobante == 2)
                    <button disabled class="src-btn-submit" style="opacity: 0.6; cursor: not-allowed;">
                        No disponible aún
                    </button>
                @elseif ($comprobante == 1)
                    <button wire:click="createApprentice" class="src-btn-submit" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="createApprentice">¡REGISTRARME AHORA!</span>
                        <span wire:loading wire:target="createApprentice">PROCESANDO...</span>
                    </button>
                @else
                    <button disabled class="src-btn-submit" style="opacity: 0.5;">
                        SELECCIONE PAGO
                    </button>
                @endif

                @if ($success)
                    <div class="src-success-msg">
                        {{ $success }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="src-error"
                        style="background: #fff5f5; padding: 20px; border-radius: 15px; width: 100%; max-width: 500px;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li style="margin-bottom: 5px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>
