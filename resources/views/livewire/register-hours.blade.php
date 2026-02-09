<div class="componente">
    <div class="main-container">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="header-content">
                    <span class="material-symbols-outlined header-icon">history_edu</span>
                    <div>
                        <h1>Gestión de Horas Docentes</h1>
                        <p>Visualice y administre los registros de horas y pagos de los profesores.</p>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('teacher.hours-form') }}" class="btn-create">
                        <span class="material-symbols-outlined">add_circle</span>
                        <span>Registrar Horas</span>
                    </a>
                </div>
            </div>

            <div class="card-filters">
                <div class="filter-wrapper">
                    <div class="filter-box">
                        <span class="material-symbols-outlined">search</span>
                        <input type="text" wire:model.live="filtro" placeholder="Buscar por nombre de profesor...">
                    </div>
                    <div class="filter-box">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <input type="date" wire:model.live="date">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th width="50">No.</th>
                            <th>Profesor</th>
                            <th class="text-center">Horas</th>
                            <th class="text-right">Monto Total</th>
                            <th>Estado de Pago</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1; @endphp
                        @forelse ($registerHours as $registerHour)
                            <tr>
                                <td class="text-muted">{{ $count++ }}</td>
                                <td>
                                    <div class="teacher-info">
                                        @if ($registerHour->teacher && $registerHour->teacher->image)
                                            <img src="/users/{{ $registerHour->teacher->image }}" class="avatar">
                                        @else
                                            <img src="/images/perfil.png" class="avatar">
                                        @endif
                                        <div class="name-box">
                                            <a href="{{ route('teacher.hours-details', $registerHour->teacher->id) }}"
                                                class="teacher-link">
                                                {{ $registerHour->teacher->name }}
                                                {{ $registerHour->teacher->apellido }}
                                            </a>
                                            <span class="sub-text">Ver historial detallado</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="hours-badge">{{ $registerHour->horas }}h</span>
                                </td>
                                <td class="text-right">
                                    <span
                                        class="amount-tag">${{ number_format($registerHour->horas * $registerHour->teacher->precio_hora) }}</span>
                                </td>
                                <td>
                                    @if ($registerHour->pago)
                                        <div class="status-pill status-paid">
                                            <span class="material-symbols-outlined">check_circle</span>
                                            <span>Completado</span>
                                        </div>
                                    @else
                                        <button wire:confirm="¿Confirma que se ha realizado el pago?"
                                            wire:click="pay({{ $registerHour->id }})" class="btn-pay">
                                            <span class="material-symbols-outlined">payments</span>
                                            <span>Pendiente</span>
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-grid">
                                        <a href="{{ route('teacher.hours-form', $registerHour->id) }}"
                                            class="action-btn edit-btn" title="Editar">
                                            <span class="material-symbols-outlined">edit</span>
                                        </a>
                                        <button class="action-btn delete-btn"
                                            wire:click="delete({{ $registerHour->id }})"
                                            wire:confirm="¿Desea eliminar este registro permanentemente?"
                                            title="Eliminar">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-row">
                                    <div class="empty-content">
                                        <video class="empty-animation" src="/videos/video2.mp4" autoplay loop
                                            muted></video>
                                        <p>No se encontraron registros para mostrar en este momento.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .main-container {
            padding: 30px;
            background: #f8fafc;
        }

        .dashboard-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .card-header {
            padding: 32px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f1f5f9;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-icon {
            font-size: 36px;
            color: #99BF51;
            background: #f0f7e6;
            padding: 12px;
            border-radius: 16px;
        }

        .card-header h1 {
            margin: 0;
            font-size: 1.5rem;
            color: #1e293b;
            font-weight: 800;
        }

        .card-header p {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 0.95rem;
        }

        .btn-create {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #99BF51;
            color: white;
            padding: 14px 24px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(153, 191, 81, 0.2);
        }

        .btn-create:hover {
            background: #84a844;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(153, 191, 81, 0.3);
        }

        .card-filters {
            padding: 24px 40px;
            background: #fafcf7;
            border-bottom: 1px solid #f1f5f9;
        }

        .filter-wrapper {
            display: flex;
            gap: 20px;
        }

        .filter-box {
            position: relative;
            display: flex;
            align-items: center;
            flex: 1;
            max-width: 400px;
        }

        .filter-box span {
            position: absolute;
            left: 15px;
            color: #94a3b8;
            font-size: 20px;
        }

        .filter-box input {
            width: 100%;
            padding: 12px 16px 12px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .filter-box input:focus {
            outline: none;
            border-color: #99BF51;
            box-shadow: 0 0 0 4px rgba(153, 191, 81, 0.1);
        }

        .table-responsive {
            padding: 20px 40px 40px;
            overflow-x: auto;
        }

        .premium-table {
            width: 100%;
            border-collapse: collapse;
        }

        .premium-table th {
            padding: 16px;
            text-align: left;
            font-size: 0.8rem;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #f1f5f9;
        }

        .premium-table td {
            padding: 20px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .teacher-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            background: #f1f5f9;
        }

        .name-box {
            display: flex;
            flex-direction: column;
        }

        .teacher-link {
            text-decoration: none;
            color: #1e293b;
            font-weight: 700;
            font-size: 1rem;
            transition: 0.2s;
        }

        .teacher-link:hover {
            color: #99BF51;
        }

        .sub-text {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .hours-badge {
            background: #f1f5f9;
            color: #334155;
            padding: 6px 12px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .amount-tag {
            color: #1e293b;
            font-weight: 800;
            font-size: 1.1rem;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .status-paid {
            background: #dcfce7;
            color: #15803d;
        }

        .btn-pay {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fefce8;
            color: #a16207;
            border: 2px solid #fef08a;
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-pay:hover {
            background: #fef9c3;
            transform: scale(1.05);
        }

        .action-grid {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .action-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: 0.2s;
            text-decoration: none;
        }

        .edit-btn {
            background: #f1f5f9;
            color: #475569;
        }

        .edit-btn:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .delete-btn {
            background: #fef2f2;
            color: #ef4444;
        }

        .delete-btn:hover {
            background: #fee2e2;
            transform: rotate(8deg);
        }

        .empty-row {
            padding: 60px !important;
            text-align: center;
        }

        .empty-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .empty-animation {
            height: 150px;
            border-radius: 20px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-muted {
            color: #94a3b8;
        }
    </style>
</div>
