<div>
    <button type="button" wire:click="openAssignModal" class="ux-assign-btn">
        <span class="material-symbols-outlined">add_task</span>
        Asignar Actividad
    </button>

    @if ($confirmingActivityAssignment)
        <div class="ux-modal-overlay">
            <div class="ux-modal-card">
                <div class="ux-modal-header">
                    <h3>Asignar Nueva Actividad por Grupos</h3>
                    <button type="button" wire:click="$set('confirmingActivityAssignment', false)" class="ux-close-btn">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="ux-modal-body">
                    <div class="ux-form-group">
                        <label>Título de la Actividad</label>
                        <input type="text" wire:model="assign_titulo" class="ux-form-control"
                            placeholder="Ej: Lectura semanal, Taller de refuerzo...">
                        @error('assign_titulo')
                            <span class="ux-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="ux-form-group">
                        <label>Grupos Destinatarios</label>
                        <div class="ux-groups-grid">
                            @foreach ($groups as $group)
                                <label class="ux-checkbox-label">
                                    <input type="checkbox" wire:model="assign_groups" value="{{ $group->id }}">
                                    <span>{{ $group->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('assign_groups')
                            <span class="ux-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="ux-form-group">
                        <label>Observaciones / Instrucciones</label>
                        <textarea wire:model="assign_descripcion" class="ux-form-control" rows="3"
                            placeholder="Escribe aquí las instrucciones para los estudiantes de los grupos seleccionados..."></textarea>
                        @error('assign_descripcion')
                            <span class="ux-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="ux-form-group">
                        <label>Adjuntar Archivo (Opcional)</label>
                        <div class="ux-file-input-wrapper">
                            <input type="file" wire:model="assign_archivo" id="assign-file-input">
                            <label for="assign-file-input">
                                <span class="material-symbols-outlined">cloud_upload</span>
                                {{ $assign_archivo ? $assign_archivo->getClientOriginalName() : 'Subir guía o material...' }}
                            </label>
                        </div>
                        @error('assign_archivo')
                            <span class="ux-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="ux-modal-footer">
                    <button type="button" wire:click="$set('confirmingActivityAssignment', false)"
                        class="ux-btn-secondary">Cancelar</button>
                    <button type="button" wire:click="saveAssignedActivity" class="ux-btn-primary">
                        <span wire:loading.remove wire:target="saveAssignedActivity">Asignar Actividad</span>
                        <span wire:loading wire:target="saveAssignedActivity">Asignando...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <style>
        .ux-assign-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
            color: white;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 20px -10px rgba(108, 92, 231, 0.5);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .ux-assign-btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 15px 30px -12px rgba(108, 92, 231, 0.6);
            background: linear-gradient(135deg, #5849c4 0%, #6c5ce7 100%);
        }

        .ux-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
        }

        .ux-modal-card {
            background: white;
            width: 100%;
            max-width: 650px;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: ux-modal-in 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            max-height: 90vh;
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
            padding: 20px 28px;
            background: #f8fafc;
            border-bottom: 1px solid #eef2f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .ux-modal-header h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 800;
            color: #1e293b;
        }

        .ux-close-btn {
            background: #fff;
            border: 1px solid #e2e8f0;
            width: 36px;
            height: 36px;
            border-radius: 10px;
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
            padding: 24px 28px;
            overflow-y: auto;
            flex-grow: 1;
        }

        .ux-form-group {
            margin-bottom: 18px;
        }

        .ux-form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: #475569;
            font-size: 0.9rem;
        }

        .ux-form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #eef2f6;
            border-radius: 14px;
            background: #f8fafc;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .ux-form-control:focus {
            outline: none;
            border-color: #6c5ce7;
            background: white;
            box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.1);
        }

        .ux-form-control {
            padding: 12px 16px;
        }

        .ux-groups-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 10px;
            padding: 14px;
            background: #f1f5f9;
            border-radius: 16px;
            max-height: 160px;
            overflow-y: auto;
        }

        .ux-checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            padding: 8px 12px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            color: #475569;
            transition: all 0.2s;
            border: 1px solid #e2e8f0;
        }

        .ux-checkbox-label:hover {
            border-color: #6c5ce7;
            color: #6c5ce7;
        }

        .ux-checkbox-label input:checked+span {
            color: #6c5ce7;
        }

        .ux-file-input-wrapper input {
            display: none;
        }

        .ux-file-input-wrapper label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 24px;
            border: 2px dashed #cbd5e1;
            border-radius: 20px;
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s;
            background: #f8fafc;
            text-align: center;
        }

        .ux-file-input-wrapper label:hover {
            border-color: #6c5ce7;
            background: #f0eeff;
            color: #6c5ce7;
        }

        .ux-modal-footer {
            padding: 20px 28px;
            background: #f8fafc;
            border-top: 1px solid #eef2f6;
            display: flex;
            gap: 16px;
            justify-content: flex-end;
            flex-shrink: 0;
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
            background: #6c5ce7;
            color: white;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);
            transition: all 0.3s;
        }

        .ux-btn-primary:hover {
            background: #5849c4;
            box-shadow: 0 6px 18px rgba(108, 92, 231, 0.4);
            transform: translateY(-2px);
        }

        .ux-error {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 6px;
            display: block;
            font-weight: 600;
        }
    </style>
</div>
