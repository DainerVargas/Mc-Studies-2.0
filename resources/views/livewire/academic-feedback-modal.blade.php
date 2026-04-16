<div>
    @if ($isOpen)
        <div class="ux-modal-overlay">
            <div class="ux-modal-card">
                <div class="ux-modal-header">
                    <h3>Calificar Actividad: {{ $activityTitle }}</h3>
                    <button type="button" wire:click="$set('isOpen', false)" class="ux-close-btn">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <form action="{{ route('listaActividades.feedback', $activityId ?? 0) }}" method="POST">
                    @csrf
                    <div class="ux-modal-body">
                        <div class="ux-form-group">
                            <label>Calificacion / Resultado</label>
                            <select name="calificacion" class="ux-form-control" required>
                                <option value="">Seleccione una calificacion...</option>
                                <option value="Excelente" {{ $calificacion == 'Excelente' ? 'selected' : '' }}>Excelente</option>
                                <option value="Sobresaliente" {{ $calificacion == 'Sobresaliente' ? 'selected' : '' }}>Sobresaliente</option>
                                <option value="Aceptable" {{ $calificacion == 'Aceptable' ? 'selected' : '' }}>Aceptable</option>
                                <option value="Insuficiente" {{ $calificacion == 'Insuficiente' ? 'selected' : '' }}>Insuficiente</option>
                                <option value="Pendiente" {{ $calificacion == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            </select>
                        </div>

                        <div class="ux-form-group">
                            <label>Comentarios / Observaciones</label>
                            <textarea name="comentario" class="ux-form-control" rows="5" required
                                placeholder="Escribe aqui tus comentarios para el acudiente...">{{ $comentario }}</textarea>
                        </div>
                    </div>
                    <div class="ux-modal-footer">
                        <button type="button" wire:click="$set('isOpen', false)" class="ux-btn-secondary">Cancelar</button>
                        <button type="submit" class="ux-btn-primary">
                            <span>Guardar Calificacion</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <style>
        /* Reusing styles from previous modals for consistency */
        .ux-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.82);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            padding: 20px;
        }

        .ux-modal-card {
            background: white;
            width: 100%;
            max-width: 550px;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
            animation: ux-modal-in 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes ux-modal-in {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .ux-modal-header {
            padding: 24px 30px;
            background: #f8fafc;
            border-bottom: 1px solid #edf2f7;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .ux-modal-header h3 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.5px;
        }

        .ux-close-btn {
            background: white;
            border: 1px solid #e2e8f0;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            color: #64748b;
        }

        .ux-close-btn:hover {
            background: #fee2e2;
            color: #ef4444;
            border-color: #fecaca;
        }

        .ux-modal-body {
            padding: 30px;
        }

        .ux-form-group {
            margin-bottom: 24px;
        }

        .ux-form-group:last-child {
            margin-bottom: 0;
        }

        .ux-form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 700;
            color: #334155;
            font-size: 0.95rem;
        }

        .ux-form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            background: #f8fafc;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #1e293b;
        }

        .ux-form-control:focus {
            outline: none;
            border-color: #6c5ce7;
            background: white;
            box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.12);
        }

        .ux-modal-footer {
            padding: 24px 30px;
            background: #f8fafc;
            border-top: 1px solid #edf2f7;
            display: flex;
            gap: 16px;
            justify-content: flex-end;
        }

        .ux-btn-secondary {
            padding: 12px 24px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            background: white;
            color: #64748b;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .ux-btn-secondary:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .ux-btn-primary {
            padding: 12px 32px;
            border-radius: 14px;
            border: none;
            background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
            color: white;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 15px -3px rgba(108, 92, 231, 0.25);
            transition: all 0.3s;
        }

        .ux-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(108, 92, 231, 0.4);
        }

        .ux-error {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 8px;
            display: block;
            font-weight: 600;
        }
    </style>
</div>
