@extends('Dashboard')
@section('title', 'Detalle de Horas')

@section('registerHours')
    <div class="componente">
        <div class="content-wrapper">
            <div class="premium-container">
                <div class="container-header">
                    <div class="header-info">
                        <div class="teacher-avatar">
                            @if ($teacher->image)
                                <img src="/users/{{ $teacher->image }}" alt="">
                            @else
                                <span class="material-symbols-outlined profile-placeholder">account_circle</span>
                            @endif
                        </div>
                        <div>
                            <h1>Informe de Horas: {{ $teacher->name }} {{ $teacher->apellido }}</h1>
                            <p>Consulte y filtre el historial detallado de horas registradas.</p>
                        </div>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('teacher.hours-form') }}" class="btn-new">
                            <span class="material-symbols-outlined">add</span>
                            <span>Registrar</span>
                        </a>
                        <a href="{{ route('registerHours') }}" class="btn-back">
                            <span class="material-symbols-outlined">arrow_back</span>
                        </a>
                    </div>
                </div>

                <div class="filters-section">
                    <div class="section-badge">
                        <span class="material-symbols-outlined">filter_list</span>
                        <span>Filtros Disponibles</span>
                    </div>
                    <form action="{{ route('teacher.hours-details', $teacher->id) }}" method="GET" class="filters-grid">
                        <div class="filter-group">
                            <label>Semana del Año</label>
                            <select name="semana" class="custom-select" onchange="this.form.submit()">
                                <option value="">Todas las semanas</option>
                                @for ($i = 1; $i <= 52; $i++)
                                    <option value="{{ $i }}" {{ request('semana') == $i ? 'selected' : '' }}>
                                        Semana {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Mes Específico</label>
                            <select name="mes" class="custom-select" onchange="this.form.submit()">
                                <option value="">Todos los meses</option>
                                @foreach ([1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'] as $num => $name)
                                    <option value="{{ $num }}" {{ request('mes') == $num ? 'selected' : '' }}>
                                        {{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Año Fiscal</label>
                            <select name="anio" class="custom-select" onchange="this.form.submit()">
                                <option value="">Todos los años</option>
                                @foreach ($availableYears as $year)
                                    <option value="{{ $year }}" {{ request('anio') == $year ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <div class="data-section">
                    <div class="table-outer">
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th>Lunes</th>
                                    <th>Martes</th>
                                    <th>Miércoles</th>
                                    <th>Jueves</th>
                                    <th>Viernes</th>
                                    <th>Sábado</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Horas</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalPrice = 0; @endphp
                                @forelse ($hoursDetails as $detail)
                                    <tr>
                                        <td><span class="date-chip">{{ $detail->lunes ?? '---' }}</span></td>
                                        <td><span class="date-chip">{{ $detail->martes ?? '---' }}</span></td>
                                        <td><span class="date-chip">{{ $detail->miercoles ?? '---' }}</span></td>
                                        <td><span class="date-chip">{{ $detail->jueves ?? '---' }}</span></td>
                                        <td><span class="date-chip">{{ $detail->viernes ?? '---' }}</span></td>
                                        <td><span class="date-chip">{{ $detail->sabado ?? '---' }}</span></td>
                                        <td class="text-center">
                                            <span class="badge {{ $detail->pago ? 'badge-paid' : 'badge-pending' }}">
                                                {{ $detail->pago ? 'Pagado' : 'Pendiente' }}
                                            </span>
                                        </td>
                                        <td class="text-center"><strong>{{ $detail->horas }}</strong></td>
                                        @php
                                            $subtotal = $detail->horas * $teacher->precio_hora;
                                            $totalPrice += $subtotal;
                                        @endphp
                                        <td class="text-right"><span
                                                class="price-tag">${{ number_format($subtotal, 0) }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="empty-state">
                                            <span class="material-symbols-outlined">database_off</span>
                                            <p>No se encontraron registros de horas con los filtros seleccionados.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if ($hoursDetails && $hoursDetails->count() > 0)
                                <tfoot>
                                    <tr>
                                        <td colspan="8" class="text-right total-label">Resumen Total General:</td>
                                        <td class="text-right total-value">
                                            <span class="total-price-tag"></span>${{ number_format($totalPrice, 0) }}</span>
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>

                <div class="container-footer">
                    @if ($hoursDetails && $hoursDetails->count() > 0)
                        <a href="{{ route('registroHoras', $teacher->id) }}" class="btn-download">
                            <span class="material-symbols-outlined">download</span>
                            <span>Exportar Informe PDF</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .content-wrapper {
            padding: 40px 20px;
            background: #f8fafc;
            min-height: calc(100vh - 80px);
            display: flex;
            justify-content: center;
        }

        .premium-container {
            width: 100%;
            max-width: 1300px;
            background: #fff;
            border-radius: 30px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container-header {
            padding: 40px;
            border-bottom: 2px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
        }

        .header-info {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .teacher-avatar img {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            object-fit: cover;
            border: 3px solid #f0f7e6;
        }

        .profile-placeholder {
            font-size: 70px;
            color: #cbd5e1;
        }

        .container-header h1 {
            margin: 0;
            font-size: 1.6rem;
            color: #0f172a;
            font-weight: 800;
        }

        .container-header p {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 1rem;
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .btn-new,
        .btn-back {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-new {
            background: #99BF51;
            color: white;
            box-shadow: 0 4px 12px rgba(153, 191, 81, 0.2);
        }

        .btn-new:hover {
            background: #84a844;
            transform: scale(1.05);
        }

        .btn-back {
            background: #f1f5f9;
            color: #64748b;
        }

        .btn-back:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .filters-section {
            padding: 30px 40px;
            background: #fafcf7;
            border-bottom: 1px solid #f1f5f9;
        }

        .section-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            color: #99BF51;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #475569;
        }

        .custom-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: #fff;
            color: #1e293b;
            font-size: 0.95rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .custom-select:focus {
            outline: none;
            border-color: #99BF51;
            box-shadow: 0 0 0 4px rgba(153, 191, 81, 0.1);
        }

        .data-section {
            padding: 30px 25px;
        }

        .table-outer {
            border-radius: 20px;
            border: 1px solid #f1f5f9;
            overflow: hidden;
            background: #ffffff;
        }

        .premium-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }

        .premium-table th {
            background: #f8fafc;
            padding: 16px 12px;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .premium-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            font-size: 0.85rem;
        }

        .date-chip {
            background: #f1f5f9;
            padding: 4px 8px;
            border-radius: 8px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            color: #475569;
            white-space: nowrap;
        }

        .badge {
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .badge-paid {
            background: #dcfce7;
            color: #166534;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .price-tag {
            color: #99BF51;
            font-weight: 800;
            font-size: 1.05rem;
        }

        .empty-state {
            text-align: center;
            padding: 60px !important;
            color: #94a3b8;
        }

        .empty-state span {
            font-size: 50px;
            margin-bottom: 15px;
            display: block;
        }

        tfoot .total-label {
            font-weight: 800;
            color: #64748b;
            font-size: 1rem;
            background: #f8fafc;
        }

        tfoot .total-value {
            font-weight: 800;
            background: #f8fafc;
            padding: 15px 12px;
        }

        .total-price-tag {
            color: #99BF51;
            font-size: 1.4rem;
            position: relative;
        }

        .container-footer {
            padding: 30px 40px;
            background: #f8fafc;
            display: flex;
            justify-content: center;
            border-top: 1px solid #f1f5f9;
        }

        .btn-download {
            background: #0f172a;
            color: white;
            text-decoration: none;
            padding: 15px 35px;
            border-radius: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-download:hover {
            background: #1e293b;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
            padding-right: 25px !important;
        }

        @media (max-width: 900px) {
            .filters-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 600px) {
            .container-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 25px;
                padding: 30px;
            }

            .filters-grid {
                grid-template-columns: 1fr;
            }

            .data-section {
                padding: 20px;
            }

            .premium-table thead {
                display: none;
            }

            .premium-table td {
                display: block;
                text-align: right;
                padding: 12px 20px;
                position: relative;
            }
        }
    </style>
@endsection
