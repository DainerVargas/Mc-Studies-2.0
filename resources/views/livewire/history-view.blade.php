<div class="contenedorHistorial">
    <div class="conteTable">
        <table>
            <thead>
                <tr>
                    <th class="titulo" colspan="6">
                        <span class="material-symbols-outlined back" wire:click="activeYear(1)">
                            stat_2
                        </span>
                        INFORME MC 20{{ $year }}
                        <span class="material-symbols-outlined next" wire:click="activeYear(2)">
                            stat_2
                        </span>
                    </th>
                </tr>
                <tr>
                    <th class="titulo2" colspan="3">Enero / Junio</th>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $porcentaje = 0;
                @endphp
                @forelse ($histories as $history)
                    @if ($history->mes <= 6 && $history->year == $year)
                        <tr>
                            <td>{{ $history->name }}</td>
                            <td>{{ $history->cantidad }}</td>
                            <td>
                                @if ($history->cantidad == 0)
                                    0%
                                    @php
                                        $porcentaje = 0;
                                    @endphp
                                @else
                                    100%
                                    @php
                                        $porcentaje = 100;
                                    @endphp
                                @endif
                            </td>
                        </tr>
                        @php
                            $total += $history->cantidad;
                        @endphp
                    @endif
                @empty
                    <tr>
                        <td colspan="3">No hay datos</td>
                    </tr>
                @endforelse
                <tr>
                    <td>Total:</td>
                    <td>{{ $total }}</td>
                    <td>{{ $porcentaje }}%</td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th class="titulo2" colspan="3">Julio / Diciembre</th>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total2 = 0;
                    $porcentaje = 0;
                    $totalPorcentaje = 0;
                    $count = 0;
                @endphp
                @forelse ($histories as $history)
                    @if ($history->mes >= 7 && $history->year == $year)
                        <tr>
                            <td>{{ $history->name }}</td>
                            <td>{{ $history->cantidad }}</td>
                            @php
                                if ($history->cantidad != 0 && $history->total != 0) {
                                    $porcentaje = (($history->cantidad - $history->total) / $history->total) * 100;
                                    $totalPorcentaje += $porcentaje;
                                    $count++;
                                }
                            @endphp
                            @if ($history->total == 0)
                                <td>-- 100% --</td>
                            @else
                                <td>{{ round($porcentaje, 1) }}%</td>
                            @endif
                        </tr>
                        @php
                            $total2 += $history->cantidad;
                        @endphp
                    @endif
                @empty
                    <tr>
                        <td colspan="3">No hay datos</td>
                    </tr>
                @endforelse
                <tr>
                    <td>Total:</td>
                    <td>{{ $total2 }}</td>
                    @php
                        if ($count == 0) {
                            $count = 1;
                        }
                    @endphp
                    <td>{{ round($totalPorcentaje / $count, 1) }}%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
