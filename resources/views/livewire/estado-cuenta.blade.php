<div class="account-state-container">
    <style>
        .account-state-container {
            padding: 2rem;
            background: #f8fafc;
            min-height: 100vh;
        }

        .account-header {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 6px solid #05ccd1;
        }

        .account-info h1 {
            color: #1a202c;
            font-size: 1.875rem;
            font-weight: 800;
            margin: 0;
        }

        .account-info p {
            color: #718096;
            font-size: 1.125rem;
            margin-top: 0.25rem;
        }

        .btn-download-report {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #05ccd1;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 14px 0 rgba(5, 204, 209, 0.39);
        }

        .btn-download-report:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(5, 204, 209, 0.45);
            background: #04b0b5;
        }

        .data-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .modern-table th {
            background: #f1f5f9;
            color: #475569;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            padding: 1rem;
            text-align: left;
            letter-spacing: 0.05em;
        }

        .modern-table td {
            padding: 1rem;
            background: white;
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: 0.95rem;
        }

        .modern-table tr:hover td {
            background: #f8fafc;
        }

        .modern-table tr td:first-child {
            border-left: 1px solid #f1f5f9;
            border-radius: 12px 0 0 12px;
        }

        .modern-table tr td:last-child {
            border-right: 1px solid #f1f5f9;
            border-radius: 0 12px 12px 0;
        }

        .badge-type {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            background: #e2f9fa;
            color: #04a5a9;
        }

        .price-text {
            font-weight: 700;
            color: #1e293b;
        }

        .abono-text {
            color: #27ae60;
            font-weight: 700;
        }

        .pendiente-text {
            color: #e11d48;
            font-weight: 700;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
            gap: 4px;
        }

        .btn-view {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-view:hover {
            background: #e2e8f0;
        }

        .btn-upload {
            background: #f0fdf4;
            color: #166534;
            border: 1px dashed #bbf7d0;
        }

        .btn-upload:hover {
            background: #dcfce7;
        }

        .btn-restore {
            background: #fff7ed;
            color: #9a3412;
        }

        .btn-restore:hover {
            background: #ffedd5;
        }

        .btn-delete {
            background: #fef2f2;
            color: #991b1b;
        }

        .btn-delete:hover {
            background: #fee2e2;
        }

        .footer-totals {
            margin-top: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border-bottom: 4px solid #e2e8f0;
        }

        .stat-card.primary {
            border-bottom-color: #05ccd1;
        }

        .stat-card.success {
            border-bottom-color: #27ae60;
        }

        .stat-card.danger {
            border-bottom-color: #e11d48;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .stat-value {
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 800;
            margin-top: 0.5rem;
        }

        .image-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .modal-image-container {
            max-width: 90%;
            max-height: 90%;
            position: relative;
        }

        .modal-image-container img {
            border-radius: 12px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .btn-close-modal {
            position: absolute;
            top: -40px;
            right: -40px;
            color: white;
            cursor: pointer;
            font-size: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <div class="account-header">
        <div class="account-info">
            <h1>Estado de la Cuenta</h1>
            <p>{{ $aprendiz->name . ' ' . $aprendiz->apellido }}</p>
        </div>
        <a href="{{ route('descargarInforme', $aprendiz) }}" class="btn-download-report">
            <span class="material-symbols-outlined">download</span>
            Descargar Informe
        </a>
    </div>

    @if ($message2)
        <div
            style="background: #fef2f2; color: #991b1b; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid #fee2e2; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <span class="material-symbols-outlined">error</span>
            {{ $message2 }}
        </div>
    @endif

    <div class="data-card">
        <div style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
            <span class="badge-type">Modalidad: {{ $aprendiz->modality->name }}</span>
        </div>

        <table class="modern-table">
            <thead>
                <tr>
                    <th>Precio Módulo</th>
                    <th>Descuento</th>
                    <th>Abono</th>
                    <th>Pendiente</th>
                    <th>Método</th>
                    <th>Fecha</th>
                    <th>Comprobante</th>
                    @if ($user->rol_id == 1)
                        <th>Acceso Admin</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                    $precioBase = $aprendiz->modality->valor;
                    $descuentoBase = $aprendiz->descuento;
                    $acumuladoAbono = 0;
                @endphp
                @forelse ($informes as $informe)
                    @php
                        $acumuladoAbono += $informe->abono;
                        $pendienteAlMomento = $precioBase - $descuentoBase - $acumuladoAbono;
                    @endphp
                    <tr wire:key="informe-{{ $informe->id }}">
                        <td class="price-text">${{ number_format($precioBase, 0, ',', '.') }}</td>
                        <td style="color: #64748b;">${{ number_format($descuentoBase, 0, ',', '.') }}</td>
                        <td class="abono-text">${{ number_format($informe->abono, 0, ',', '.') }}</td>
                        <td class="pendiente-text">
                            ${{ number_format($pendienteAlMomento > 0 ? $pendienteAlMomento : 0, 0, ',', '.') }}</td>
                        <td>
                            <span
                                style="font-size: 0.85rem; font-weight: 600; color: #475569;">{{ $informe->metodo ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span
                                style="color: #64748b; font-size: 0.85rem;">{{ $informe->fecha ?? 'Sin fecha' }}</span>
                        </td>
                        <td>
                            @if ($informe->urlImage == null)
                                <div wire:click="setInformeId({{ $informe->id }})">
                                    <label class="action-btn btn-upload" for="cargar_{{ $informe->id }}">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">upload</span>
                                        Cargar
                                    </label>
                                    <input type="file" wire:model="comprobante" hidden
                                        id="cargar_{{ $informe->id }}">
                                </div>
                            @else
                                @php $extension = pathinfo($informe->urlImage, PATHINFO_EXTENSION); @endphp
                                @if ($extension != 'pdf')
                                    <button class="action-btn btn-view" wire:click="show({{ $informe->id }})">
                                        <span class="material-symbols-outlined"
                                            style="font-size: 18px;">visibility</span>
                                        Ver
                                    </button>
                                @else
                                    <a href="{{ asset('users/' . $informe->urlImage) }}" download
                                        class="action-btn btn-view" style="text-decoration: none;">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">download</span>
                                        PDF
                                    </a>
                                @endif
                            @endif
                        </td>
                        @if ($user->rol_id == 1)
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <button class="action-btn btn-restore"
                                        wire:click="reseter({{ $informe->id }} , {{ $informe->apprentice_id }})"
                                        wire:confirm="¿Deseas restablecer este pago? Los datos se pondrán en 0.">
                                        <span class="material-symbols-outlined"
                                            style="font-size: 18px;">restart_alt</span>
                                    </button>
                                    <button class="action-btn btn-delete" wire:click="eliminar({{ $informe->id }})"
                                        wire:confirm="¿Deseas eliminar este registro permanentemente?">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                    </button>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $user->rol_id == 1 ? 8 : 7 }}"
                            style="text-align: center; padding: 3rem; color: #94a3b8;">
                            <span class="material-symbols-outlined" style="font-size: 48px;">receipt_long</span>
                            <p style="margin-top: 1rem;">No se han registrado pagos para este módulo.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer-totals">
        <div class="stat-card primary">
            <div class="stat-label">Total Módulo</div>
            <div class="stat-value">${{ number_format($precioBase - $descuentoBase, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card success">
            <div class="stat-label">Total Abonado</div>
            <div class="stat-value">${{ number_format($acumuladoAbono, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card danger">
            <div class="stat-label">Saldo Pendiente</div>
            @php $resaltante = ($precioBase - $descuentoBase - $acumuladoAbono); @endphp
            <div class="stat-value">${{ number_format($resaltante > 0 ? $resaltante : 0, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Plataforma</div>
            @if ($count != 0)
                <div class="stat-value" style="color: #05ccd1;">
                    ${{ number_format($aprendiz->plataforma, 0, ',', '.') }}</div>
            @else
                <div class="stat-value" style="color: #27ae60; font-size: 1rem;">✓ PAGADA</div>
            @endif
        </div>
    </div>

    @if ($viewComprobante == 1)
        <div class="image-modal-overlay" wire:click="close">
            <div class="modal-image-container" wire:click.stop>
                <span class="material-symbols-outlined btn-close-modal" wire:click="close">close</span>
                <img src="{{ asset('users/' . $urlImage) }}" alt="Comprobante">
            </div>
        </div>
    @endif

    <div wire:loading wire:target="comprobante" class="image-modal-overlay">
        <div style="color: white; display: flex; flex-direction: column; align-items: center; gap: 1rem;">
            <div class="justify-content-center jimu-primary-loading"></div>
            <p style="font-weight: 600;">Subiendo comprobante...</p>
        </div>
    </div>
</div>
