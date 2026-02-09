<div>
    <div class="componente">
        <div class="form-wrapper">
            <div class="premium-form">
                <div class="form-header">
                    <div class="header-main">
                        <span class="material-symbols-outlined header-icon">schedule</span>
                        <div>
                            <h1>{{ $editId ? 'Editar Registro' : 'Nuevo Registro de Horas' }}</h1>
                            <p>Complete los campos para registrar las horas trabajadas por el profesor.</p>
                        </div>
                    </div>
                    <a href="{{ route('registerHours') }}" class="back-link">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span>Volver</span>
                    </a>
                </div>

                <form wire:submit.prevent="save" class="main-form">
                    <div class="form-section">
                        <div class="section-title">
                            <span class="material-symbols-outlined">person</span>
                            <h3>Información General</h3>
                        </div>
                        <div class="top-fields">
                            <div class="form-group flex-2">
                                <label>Profesor Responsable</label>
                                <div class="input-with-icon">
                                    <span class="material-symbols-outlined input-icon">person_search</span>
                                    <select wire:model="teacher_id" class="modern-select">
                                        <option value="" selected hidden>Seleccione el profesor...</option>
                                        @foreach ($profesores as $profesor)
                                            <option value="{{ $profesor->id }}">{{ $profesor->name }}
                                                {{ $profesor->apellido }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('teacher_id')
                                    <small class="error-msg">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group flex-1">
                                <label>Horas Totales</label>
                                <div class="input-with-icon">
                                    <span class="material-symbols-outlined input-icon">timer</span>
                                    <input class="modern-input" wire:model="horas" type="number" step="0.5"
                                        placeholder="0.0">
                                </div>
                                @error('horas')
                                    <small class="error-msg">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-title">
                            <span class="material-symbols-outlined">calendar_month</span>
                            <h3>Fechas Trabajadas</h3>
                            <p class="section-hint">Indique la fecha correspondiente a cada día laborado.</p>
                        </div>

                        <div class="days-grid">
                            <div class="day-input">
                                <label>Lunes</label>
                                <input wire:model="lunes" class="modern-date" type="date">
                                @error('lunes')
                                    <small class="error-msg">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="day-input">
                                <label>Martes</label>
                                <input wire:model="martes" class="modern-date" type="date">
                                @error('martes')
                                    <small class="error-msg">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="day-input">
                                <label>Miércoles</label>
                                <input wire:model="miercoles" class="modern-date" type="date">
                                @error('miercoles')
                                    <small class="error-msg">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="day-input">
                                <label>Jueves</label>
                                <input wire:model="jueves" class="modern-date" type="date">
                                @error('jueves')
                                    <small class="error-msg">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="day-input">
                                <label>Viernes</label>
                                <input wire:model="viernes" class="modern-date" type="date">
                                @error('viernes')
                                    <small class="error-msg">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="day-input">
                                <label>Sábado</label>
                                <input wire:model="sabado" class="modern-date" type="date">
                                @error('sabado')
                                    <small class="error-msg">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" onclick="window.location='{{ route('registerHours') }}'"
                            class="btn-secondary">Cancelar</button>
                        <button type="submit" class="btn-submit">
                            <span class="material-symbols-outlined">save</span>
                            {{ $editId ? 'Guardar Cambios' : 'Confirmar Registro' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .form-wrapper {
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            background: #f8fafc;
            min-height: calc(100vh - 80px);
        }

        .premium-form {
            background: #ffffff;
            width: 100%;
            max-width: 950px;
            border-radius: 30px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e2e8f0;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-header {
            padding: 40px;
            background: #ffffff;
            border-bottom: 2px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-main {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .header-icon {
            font-size: 45px;
            color: #99BF51;
            background: #f0f7e6;
            padding: 15px;
            border-radius: 20px;
        }

        .form-header h1 {
            margin: 0;
            font-size: 1.8rem;
            color: #0f172a;
            font-weight: 800;
        }

        .form-header p {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 1rem;
        }

        .back-link {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: #64748b;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 15px;
            transition: all 0.2s;
            background: #f1f5f9;
        }

        .back-link:hover {
            background: #e2e8f0;
            color: #0f172a;
            transform: translateX(-5px);
        }

        .main-form {
            padding: 45px;
        }

        .form-section {
            margin-bottom: 45px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 15px;
            flex-wrap: wrap;
        }

        .section-title span {
            color: #99BF51;
            font-size: 28px;
        }

        .section-title h3 {
            margin: 0;
            font-size: 1.2rem;
            color: #1e293b;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section-hint {
            width: 100%;
            margin: 8px 0 0;
            font-size: 0.9rem;
            color: #94a3b8;
        }

        .top-fields {
            display: flex;
            gap: 30px;
        }

        .flex-2 {
            flex: 2;
        }

        .flex-1 {
            flex: 1;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #475569;
        }

        .input-with-icon {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            color: #94a3b8;
            font-size: 22px;
        }

        .modern-select,
        .modern-input {
            width: 100%;
            padding: 16px 20px 16px 52px;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            background: #ffffff;
            font-size: 1.05rem;
            transition: all 0.3s;
            color: #1e293b;
        }

        .modern-select:focus,
        .modern-input:focus {
            outline: none;
            border-color: #99BF51;
            box-shadow: 0 0 0 5px rgba(153, 191, 81, 0.1);
            background: #fafdf5;
        }

        .days-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .day-input label {
            display: block;
            margin-bottom: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
        }

        .modern-date {
            width: 80%;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            color: #334155;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .modern-date:focus {
            outline: none;
            border-color: #99BF51;
            background: #fafdf5;
            box-shadow: 0 0 0 5px rgba(153, 191, 81, 0.1);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            padding-top: 40px;
            border-top: 2px solid #f1f5f9;
        }

        .btn-secondary {
            padding: 16px 32px;
            border-radius: 16px;
            border: 2px solid #e2e8f0;
            background: transparent;
            color: #64748b;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .btn-secondary:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .btn-submit {
            background: #99BF51;
            color: white;
            border: none;
            border-radius: 16px;
            padding: 16px 40px;
            font-weight: 700;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 6px 15px rgba(153, 191, 81, 0.3);
        }

        .btn-submit:hover {
            background: #84a844;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(153, 191, 81, 0.4);
        }

        .error-msg {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 8px;
            display: block;
            font-weight: 500;
        }

        @media (max-width: 1000px) {
            .premium-form {
                max-width: 95%;
            }
        }

        @media (max-width: 800px) {
            .days-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .top-fields {
                flex-direction: column;
                gap: 20px;
            }
        }

        @media (max-width: 600px) {
            .days-grid {
                grid-template-columns: 1fr;
            }

            .form-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 25px;
                padding: 30px;
            }

            .main-form {
                padding: 30px;
            }

            .back-link {
                width: 100%;
                justify-content: center;
            }

            .btn-submit {
                width: 100%;
                justify-content: center;
            }

            .btn-secondary {
                display: none;
            }
        }
    </style>
</div>
