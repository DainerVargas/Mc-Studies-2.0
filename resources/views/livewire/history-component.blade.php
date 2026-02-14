<div>
    <div class="hst-container">
        {{-- ... content ... --}}
        <div class="hst-header">
            <div class="hst-header-info">
                <h2 class="hst-title">
                    <span class="material-symbols-outlined">history</span>
                    Historial de Actividad
                </h2>
                <p class="hst-subtitle">Registro detallado de acciones en la plataforma</p>
            </div>
            <div class="hst-header-stats">
                <div class="hst-stat-card">
                    <span class="hst-stat-value">{{ $totalLogsCount }}</span>
                    <span class="hst-stat-label">Acciones Encontradas</span>
                </div>
            </div>
        </div>

        <div class="hst-filters">
            <button wire:click.prevent="setCategory('')" class="hst-filter-tab {{ !$category ? 'hst-active' : '' }}">
                <span class="material-symbols-outlined">data_thresholding</span> Todos
            </button>
            <button wire:click.prevent="setCategory('student')"
                class="hst-filter-tab {{ $category == 'student' ? 'hst-active' : '' }}">
                <span class="material-symbols-outlined">school</span> Estudiante
            </button>
            <button wire:click.prevent="setCategory('teachers')"
                class="hst-filter-tab {{ $category == 'teachers' ? 'hst-active' : '' }}">
                <span class="material-symbols-outlined">person_pin</span> Profesores
            </button>
            <button wire:click.prevent="setCategory('services')"
                class="hst-filter-tab {{ $category == 'services' ? 'hst-active' : '' }}">
                <span class="material-symbols-outlined">settings_suggest</span> Servicios
            </button>
            <button wire:click.prevent="setCategory('payments')"
                class="hst-filter-tab {{ $category == 'payments' ? 'hst-active' : '' }}">
                <span class="material-symbols-outlined">payments</span> Pagos
            </button>
            <button wire:click.prevent="setCategory('cashier')"
                class="hst-filter-tab {{ $category == 'cashier' ? 'hst-active' : '' }}">
                <span class="material-symbols-outlined">account_balance_wallet</span> Caja
            </button>
        </div>

        @if ($logs->isEmpty())
            <div class="hst-empty-state">
                <div class="hst-empty-illustration">
                    <span class="material-symbols-outlined">event_busy</span>
                </div>
                <h3>Sin actividad reciente</h3>
                <p>Las acciones que realices aparecerán aquí para tu seguimiento.</p>
            </div>
        @else
            <div class="hst-scrollable-container">
                <div class="hst-timeline">
                    @foreach ($logs as $log)
                        <div class="hst-timeline-item" wire:key="log-{{ $log->id }}">
                            <div class="hst-marker {{ $log->action_type }}">
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

                            <div class="hst-card">
                                <div class="hst-card-header">
                                    <div class="hst-action-tags">
                                        <span
                                            class="hst-badge hst-badge-action {{ $log->action_type }}">{{ ucfirst($log->action_type) }}</span>
                                        <span
                                            class="hst-badge hst-badge-entity">{{ class_basename($log->entity_type) ?: 'Sistema' }}</span>
                                        <span class="hst-badge hst-badge-user">
                                            <span class="material-symbols-outlined">person</span>
                                            {{ $log->user_name ?: 'Sistema' }}
                                        </span>
                                    </div>
                                    <time class="hst-time" title="{{ $log->created_at->format('d/m/Y H:i:s') }}">
                                        {{ $log->created_at->diffForHumans() }}
                                    </time>
                                </div>

                                <div class="hst-card-body">
                                    <p class="hst-description">{{ $log->description }}</p>

                                    @if (($log->action_type == 'updated' || $log->action_type == 'update') && $log->old_values && $log->new_values)
                                        <details class="hst-change-details">
                                            <summary>Ver cambios realizados</summary>
                                            <div class="hst-changes-list">
                                                @foreach ($log->new_values as $key => $value)
                                                    @if (isset($log->old_values[$key]) && $log->old_values[$key] != $value)
                                                        <div class="hst-change-entry">
                                                            <span
                                                                class="hst-attr-name">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                                            <div class="hst-diff-view">
                                                                <span
                                                                    class="hst-val-old">{{ is_array($log->old_values[$key]) ? 'JSON' : ($log->old_values[$key] ?: '(vacío)') }}</span>
                                                                <span
                                                                    class="material-symbols-outlined">trending_flat</span>
                                                                <span
                                                                    class="hst-val-new">{{ is_array($value) ? 'JSON' : ($value ?: '(vacío)') }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </details>
                                    @endif
                                </div>

                                <div class="hst-card-footer">
                                    <div class="hst-meta-item" title="{{ $log->user_agent }}">
                                        <span class="material-symbols-outlined">devices</span>
                                        <span class="hst-meta-text">{{ Str::limit($log->user_agent, 45) }}</span>
                                    </div>
                                    <div class="hst-meta-item">
                                        <span class="material-symbols-outlined">location_on</span>
                                        <span class="hst-meta-text">{{ $log->ip_address }}</span>
                                    </div>
                                    <div class="hst-meta-item">
                                        <span class="material-symbols-outlined">shield_person</span>
                                        <span class="hst-meta-text">{{ $log->user_role ?: 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($logs->count() < $totalLogsCount)
                    <div class="hst-load-more-container">
                        <button wire:click="loadMore" class="hst-btn-load-more" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="loadMore">Cargar más historial</span>
                            <span wire:loading wire:target="loadMore">Cargando...</span>
                            <span class="material-symbols-outlined" wire:loading.remove
                                wire:target="loadMore">expand_more</span>
                        </button>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <style>
        :root {
            --hst-primary-gradient: linear-gradient(135deg, #05ccd1 0%, #04b0b4 100%);
            --hst-success-glow: 0 0 15px rgba(72, 187, 120, 0.2);
            --hst-info-glow: 0 0 15px rgba(66, 153, 225, 0.2);
            --hst-danger-glow: 0 0 15px rgba(245, 101, 101, 0.2);
            --hst-card-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        }

        .hst-container {
            width: 90vw;
            padding: 2.5rem;
            background: #fdfdfd;
            border-radius: 20px;
            min-height: 80vh;
        }

        .hst-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #edf2f7;
        }

        .hst-filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .hst-filter-tab {
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
            cursor: pointer;
        }

        .hst-filter-tab span {
            font-size: 1.25rem;
        }

        .hst-filter-tab:hover {
            transform: translateY(-2px);
            color: #05ccd1;
            border-color: #05ccd1;
        }

        .hst-filter-tab.hst-active {
            background: #05ccd1;
            color: #fff;
            border-color: #05ccd1;
            box-shadow: 0 10px 15px -3px rgba(5, 204, 209, 0.25);
        }

        .hst-title {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.8rem;
            font-weight: 800;
            color: #1a202c;
            margin: 0;
        }

        .hst-title span {
            font-size: 2.5rem;
            background: var(--hst-primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hst-subtitle {
            color: #718096;
            margin: 0.5rem 0 0 0;
            font-size: 1rem;
        }

        .hst-stat-card {
            background: #fff;
            padding: 1rem 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            border: 1px solid #edf2f7;
            text-align: center;
        }

        .hst-stat-value {
            display: block;
            font-size: 1.75rem;
            font-weight: 900;
            color: #05ccd1;
        }

        .hst-stat-label {
            font-size: 0.75rem;
            color: #a0aec0;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 700;
        }

        /* Scrollable Container */
        .hst-scrollable-container {
            max-height: 70vh;
            overflow-y: auto;
            padding-right: 15px;
            padding-top: 20px;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f1f1f1;
        }

        .hst-scrollable-container::-webkit-scrollbar {
            width: 8px;
        }

        .hst-scrollable-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .hst-scrollable-container::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
            border: 2px solid #f1f1f1;
        }

        .hst-scrollable-container::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Timeline */
        .hst-timeline {
            position: relative;
            padding-left: 6rem;
            padding-right: 2rem;
            margin-bottom: 20px;
            max-width: 95%;
            margin-left: auto;
            margin-right: auto;
        }

        .hst-timeline::before {
            content: '';
            position: absolute;
            left: 2.5rem;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, #05ccd1 0%, #cbd5e0 100%);
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(5, 204, 209, 0.1);
        }

        .hst-timeline-item {
            position: relative;
            margin-bottom: 2.5rem;
            animation: hstSlideUp 0.4s ease-out forwards;
        }

        @keyframes hstSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hst-marker {
            position: absolute;
            left: -5.4rem;
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 16px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            border: 3px solid #edf2f7;
            z-index: 2;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .hst-marker:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .hst-marker span {
            font-size: 1.6rem;
        }

        .hst-marker.created {
            color: #48bb78;
            border-color: #9ae6b4;
            background: linear-gradient(135deg, #f0fff4 0%, #c6f6d5 100%);
            box-shadow: 0 8px 20px rgba(72, 187, 120, 0.2);
        }

        .hst-marker.updated {
            color: #4299e1;
            border-color: #90cdf4;
            background: linear-gradient(135deg, #ebf8ff 0%, #bee3f8 100%);
            box-shadow: 0 8px 20px rgba(66, 153, 225, 0.2);
        }

        .hst-marker.deleted {
            color: #f56565;
            border-color: #fc8181;
            background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
            box-shadow: 0 8px 20px rgba(245, 101, 101, 0.2);
        }

        .hst-marker.payment {
            color: #ecc94b;
            border-color: #f6e05e;
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            box-shadow: 0 8px 20px rgba(236, 201, 75, 0.2);
        }

        .hst-card {
            background: #fff;
            border: 1px solid #edf2f7;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .hst-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #05ccd1 0%, #20e3b2 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .hst-card:hover {
            transform: translateY(-6px) translateX(4px);
            box-shadow: 0 20px 40px rgba(5, 204, 209, 0.15);
            border-color: rgba(5, 204, 209, 0.3);
        }

        .hst-card:hover::before {
            transform: scaleX(1);
        }

        .hst-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .hst-action-tags {
            display: flex;
            gap: 0.75rem;
        }

        .hst-badge {
            padding: 0.35rem 1rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .hst-badge-action.created {
            background: #c6f6d5;
            color: #22543d;
        }

        .hst-badge-action.updated {
            background: #bee3f8;
            color: #2a4365;
        }

        .hst-badge-action.deleted {
            background: #fed7d7;
            color: #742a2a;
        }

        .hst-badge-action.payment {
            background: #fef3c7;
            color: #744210;
        }

        .hst-badge-entity {
            background: #f7fafc;
            color: #4a5568;
            border: 1px solid #e2e8f0;
        }

        .hst-badge-user {
            background: #f0f7ff;
            color: #2b6cb0;
            border: 1px solid #bee3f8;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .hst-badge-user .material-symbols-outlined {
            font-size: 1rem;
        }

        .hst-time {
            font-size: 0.85rem;
            color: #a0aec0;
            font-weight: 500;
        }

        .hst-description {
            font-size: 1.05rem;
            color: #2d3748;
            line-height: 1.6;
            margin: 0 0 1.25rem 0;
        }

        /* Change Details Styling */
        .hst-change-details {
            background: #f8fafc;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #edf2f7;
        }

        .hst-change-details summary {
            padding: 0.75rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #4a5568;
            cursor: pointer;
            outline: none;
            user-select: none;
        }

        .hst-changes-list {
            padding: 0 1.25rem 1.25rem 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .hst-change-entry {
            background: #fff;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid #f1f5f9;
        }

        .hst-attr-name {
            display: block;
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 800;
            margin-bottom: 0.4rem;
        }

        .hst-diff-view {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
        }

        .hst-val-old {
            color: #f56565;
            text-decoration: line-through;
            opacity: 0.6;
        }

        .hst-val-new {
            color: #48bb78;
            font-weight: 700;
        }

        .hst-diff-view span.material-symbols-outlined {
            font-size: 1.2rem;
            color: #cbd5e0;
        }

        .hst-card-footer {
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid #f7fafc;
            display: flex;
            gap: 2rem;
        }

        .hst-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #718096;
        }

        .hst-meta-item span.material-symbols-outlined {
            font-size: 1.1rem;
        }

        .hst-meta-text {
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Empty State */
        .hst-empty-state {
            text-align: center;
            padding: 6rem 2rem;
        }

        .hst-empty-illustration span {
            font-size: 6rem;
            color: #edf2f7;
            margin-bottom: 2rem;
        }

        .hst-empty-state h3 {
            font-size: 1.5rem;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .hst-empty-state p {
            color: #a0aec0;
        }

        /* Load More Button */
        .hst-load-more-container {
            display: flex;
            justify-content: center;
            padding: 20px 0;
            margin-top: 10px;
        }

        .hst-btn-load-more {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            background-color: #f8f9fa;
            border: 1px solid #e1e1e1;
            border-radius: 30px;
            color: #636e72;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .hst-btn-load-more:hover {
            background-color: #fff;
            color: #05ccd1;
            border-color: #05ccd1;
            box-shadow: 0 4px 12px rgba(5, 204, 209, 0.2);
            transform: translateY(-2px);
        }

        .hst-btn-load-more:active {
            transform: translateY(0);
        }

        .hst-btn-load-more .material-symbols-outlined {
            font-size: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hst-container {
                padding: 1.5rem;
                width: 95vw;
            }

            .hst-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.5rem;
            }

            .hst-timeline {
                padding-left: 4rem;
                padding-right: 1rem;
                max-width: 100%;
            }

            .hst-timeline::before {
                left: 1.5rem;
                width: 3px;
            }

            .hst-marker {
                left: -3.8rem;
                width: 2.8rem;
                height: 2.8rem;
            }

            .hst-marker span {
                font-size: 1.3rem;
            }

            .hst-card {
                padding: 1.25rem;
            }

            .hst-card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .hst-action-tags {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .hst-time {
                align-self: flex-start;
                font-size: 0.75rem;
            }

            .hst-card-footer {
                flex-direction: column;
                gap: 1rem;
            }

            .hst-meta-item {
                font-size: 0.7rem;
            }
        }
    </style>
</div>
