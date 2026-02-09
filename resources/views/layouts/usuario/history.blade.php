@extends('layouts.usuario')

@section('title', 'Historial de acciones')

@section('history')
    <div class="history-container">
        <div class="history-header">
            <div class="header-info">
                <h2 class="history-title">
                    <span class="material-symbols-outlined">history</span>
                    Historial de Actividad
                </h2>
                <p class="history-subtitle">Registro detallado de acciones en la plataforma</p>
            </div>
            <div class="header-stats">
                <div class="stat-card">
                    <span class="stat-value">{{ $logs->total() }}</span>
                    <span class="stat-label">Acciones Encontradas</span>
                </div>
            </div>
        </div>

        <div class="history-filters">
            <a href="{{ route('history') }}" class="filter-tab {{ !$category ? 'active' : '' }}">
                <span class="material-symbols-outlined">data_thresholding</span> Todos
            </a>
            <a href="{{ route('history', ['category' => 'student']) }}"
                class="filter-tab {{ $category == 'student' ? 'active' : '' }}">
                <span class="material-symbols-outlined">school</span> Estudiante
            </a>
            <a href="{{ route('history', ['category' => 'teachers']) }}"
                class="filter-tab {{ $category == 'teachers' ? 'active' : '' }}">
                <span class="material-symbols-outlined">person_pin</span> Profesores
            </a>
            <a href="{{ route('history', ['category' => 'services']) }}"
                class="filter-tab {{ $category == 'services' ? 'active' : '' }}">
                <span class="material-symbols-outlined">settings_suggest</span> Servicios
            </a>
            <a href="{{ route('history', ['category' => 'payments']) }}"
                class="filter-tab {{ $category == 'payments' ? 'active' : '' }}">
                <span class="material-symbols-outlined">payments</span> Pagos
            </a>
            <a href="{{ route('history', ['category' => 'cashier']) }}"
                class="filter-tab {{ $category == 'cashier' ? 'active' : '' }}">
                <span class="material-symbols-outlined">account_balance_wallet</span> Caja
            </a>
        </div>

        @if ($logs->isEmpty())
            <div class="empty-state">
                <div class="empty-illustration">
                    <span class="material-symbols-outlined">event_busy</span>
                </div>
                <h3>Sin actividad reciente</h3>
                <p>Las acciones que realices aparecerán aquí para tu seguimiento.</p>
            </div>
        @else
            <div class="activity-timeline">
                @foreach ($logs as $log)
                    <div class="activity-item">
                        <div class="activity-marker {{ $log->action_type }}">
                            @php
                                $icon = 'info';
                                $action = strtolower($log->action_type);
                                if (str_contains($action, 'create')) {
                                    $icon = 'add_circle';
                                } elseif (str_contains($action, 'update')) {
                                    $icon = 'edit_square';
                                } elseif (str_contains($action, 'delete')) {
                                    $icon = 'delete_forever';
                                } elseif (str_contains($action, 'payment')) {
                                    $icon = 'payments';
                                } elseif (str_contains($action, 'login')) {
                                    $icon = 'login';
                                } elseif (str_contains($action, 'logout')) {
                                    $icon = 'logout';
                                } elseif (str_contains($action, 'backup')) {
                                    $icon = 'cloud_download';
                                }
                            @endphp
                            <span class="material-symbols-outlined">{{ $icon }}</span>
                        </div>

                        <div class="activity-card">
                            <div class="card-header">
                                <div class="action-tags">
                                    <span
                                        class="badge badge-action {{ $log->action_type }}">{{ ucfirst($log->action_type) }}</span>
                                    <span
                                        class="badge badge-entity">{{ class_basename($log->entity_type) ?: 'Sistema' }}</span>
                                    <span class="badge badge-user">
                                        <span class="material-symbols-outlined">person</span>
                                        {{ $log->user_name ?: 'Sistema' }}
                                    </span>
                                </div>
                                <time class="activity-time" title="{{ $log->created_at->format('d/m/Y H:i:s') }}">
                                    {{ $log->created_at->diffForHumans() }}
                                </time>
                            </div>

                            <div class="card-body">
                                <p class="activity-desc">{{ $log->description }}</p>

                                @if (($log->action_type == 'updated' || $log->action_type == 'update') && $log->old_values && $log->new_values)
                                    <details class="change-details">
                                        <summary>Ver cambios realizados</summary>
                                        <div class="changes-list">
                                            @foreach ($log->new_values as $key => $value)
                                                @if (isset($log->old_values[$key]) && $log->old_values[$key] != $value)
                                                    <div class="change-entry">
                                                        <span
                                                            class="attr-name">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                                        <div class="diff-view">
                                                            <span
                                                                class="val-old">{{ is_array($log->old_values[$key]) ? 'JSON' : ($log->old_values[$key] ?: '(vacío)') }}</span>
                                                            <span class="material-symbols-outlined">trending_flat</span>
                                                            <span
                                                                class="val-new">{{ is_array($value) ? 'JSON' : ($value ?: '(vacío)') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </details>
                                @endif
                            </div>

                            <div class="card-footer">
                                <div class="meta-item" title="{{ $log->user_agent }}">
                                    <span class="material-symbols-outlined">devices</span>
                                    <span class="meta-text">{{ Str::limit($log->user_agent, 45) }}</span>
                                </div>
                                <div class="meta-item">
                                    <span class="material-symbols-outlined">location_on</span>
                                    <span class="meta-text">{{ $log->ip_address }}</span>
                                </div>
                                <div class="meta-item">
                                    <span class="material-symbols-outlined">shield_person</span>
                                    <span class="meta-text">{{ $log->user_role ?: 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #05ccd1 0%, #04b0b4 100%);
            --success-glow: 0 0 15px rgba(72, 187, 120, 0.2);
            --info-glow: 0 0 15px rgba(66, 153, 225, 0.2);
            --danger-glow: 0 0 15px rgba(245, 101, 101, 0.2);
            --card-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        }

        .history-container {
            width: 90vw;
            padding: 2.5rem;
            background: #fdfdfd;
            border-radius: 20px;
            min-height: 80vh;
        }

        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #edf2f7;
        }

        .history-filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .filter-tab {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #fff;
            border: 1px solid #edf2f7;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            color: #718096;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .filter-tab span {
            font-size: 1.25rem;
        }

        .filter-tab:hover {
            transform: translateY(-2px);
            color: #05ccd1;
            border-color: #05ccd1;
        }

        .filter-tab.active {
            background: #05ccd1;
            color: #fff;
            border-color: #05ccd1;
            box-shadow: 0 10px 15px -3px rgba(5, 204, 209, 0.25);
        }

        .history-title {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.8rem;
            font-weight: 800;
            color: #1a202c;
            margin: 0;
        }

        .history-title span {
            font-size: 2.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .history-subtitle {
            color: #718096;
            margin: 0.5rem 0 0 0;
            font-size: 1rem;
        }

        .stat-card {
            background: #fff;
            padding: 1rem 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            border: 1px solid #edf2f7;
            text-align: center;
        }

        .stat-value {
            display: block;
            font-size: 1.75rem;
            font-weight: 900;
            color: #05ccd1;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #a0aec0;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 700;
        }

        /* Timeline */
        .activity-timeline {
            position: relative;
            padding-left: 4rem;
        }

        .activity-timeline::before {
            content: '';
            position: absolute;
            left: 1.75rem;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #edf2f7;
            border-radius: 3px;
        }

        .activity-item {
            position: relative;
            margin-bottom: 2.5rem;
            animation: slideUp 0.4s ease-out forwards;
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

        .activity-marker {
            position: absolute;
            left: -3.85rem;
            width: 3rem;
            height: 3rem;
            border-radius: 14px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: 2px solid #edf2f7;
            z-index: 2;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .activity-marker span {
            font-size: 1.5rem;
        }

        .activity-marker.created {
            color: #48bb78;
            border-color: #c6f6d5;
            background: #f0fff4;
        }

        .activity-marker.updated {
            color: #4299e1;
            border-color: #bee3f8;
            background: #ebf8ff;
        }

        .activity-marker.deleted {
            color: #f56565;
            border-color: #fed7d7;
            background: #fff5f5;
        }

        .activity-marker.payment {
            color: #ecc94b;
            border-color: #fef3c7;
            background: #fffbeb;
        }

        .activity-card {
            background: #fff;
            border: 1px solid #edf2f7;
            border-radius: 18px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .activity-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .action-tags {
            display: flex;
            gap: 0.75rem;
        }

        .badge {
            padding: 0.35rem 1rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .badge-action.created {
            background: #c6f6d5;
            color: #22543d;
        }

        .badge-action.updated {
            background: #bee3f8;
            color: #2a4365;
        }

        .badge-action.deleted {
            background: #fed7d7;
            color: #742a2a;
        }

        .badge-action.payment {
            background: #fef3c7;
            color: #744210;
        }

        .badge-entity {
            background: #f7fafc;
            color: #4a5568;
            border: 1px solid #e2e8f0;
        }

        .badge-user {
            background: #f0f7ff;
            color: #2b6cb0;
            border: 1px solid #bee3f8;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .badge-user .material-symbols-outlined {
            font-size: 1rem;
        }

        .activity-time {
            font-size: 0.85rem;
            color: #a0aec0;
            font-weight: 500;
        }

        .activity-desc {
            font-size: 1.05rem;
            color: #2d3748;
            line-height: 1.6;
            margin: 0 0 1.25rem 0;
        }

        /* Change Details Styling */
        .change-details {
            background: #f8fafc;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #edf2f7;
        }

        .change-details summary {
            padding: 0.75rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #4a5568;
            cursor: pointer;
            outline: none;
            user-select: none;
        }

        .changes-list {
            padding: 0 1.25rem 1.25rem 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .change-entry {
            background: #fff;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid #f1f5f9;
        }

        .attr-name {
            display: block;
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 800;
            margin-bottom: 0.4rem;
        }

        .diff-view {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
        }

        .val-old {
            color: #f56565;
            text-decoration: line-through;
            opacity: 0.6;
        }

        .val-new {
            color: #48bb78;
            font-weight: 700;
        }

        .diff-view span.material-symbols-outlined {
            font-size: 1.2rem;
            color: #cbd5e0;
        }

        .card-footer {
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid #f7fafc;
            display: flex;
            gap: 2rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #718096;
        }

        .meta-item span.material-symbols-outlined {
            font-size: 1.1rem;
        }

        .meta-text {
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 6rem 2rem;
        }

        .empty-illustration span {
            font-size: 6rem;
            color: #edf2f7;
            margin-bottom: 2rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #a0aec0;
        }

        .pagination-wrapper {
            margin-top: 4rem;
            display: flex;
            justify-content: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .history-container {
                padding: 1.5rem;
            }

            .history-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.5rem;
            }

            .activity-timeline {
                padding-left: 3rem;
            }

            .activity-timeline::before {
                left: 1rem;
            }

            .activity-marker {
                left: -3.35rem;
                width: 2.2rem;
                height: 2.2rem;
            }

            .activity-marker span {
                font-size: 1.2rem;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .activity-time {
                align-self: flex-end;
            }

            .card-footer {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
@endsection
