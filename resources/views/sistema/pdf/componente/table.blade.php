<table class="datagrid" style="width: 100%">
    <thead>
        <tr>
            <th colspan="6" style="text-align:center;" scope="col">
                <h2>{{ $estado }}</h2>
            </th>
        </tr>
        <tr>
            <th style="text-align:center;" scope="col">{{ __('Estado') }}</th>
            <th style="text-align:center;" scope="col">{{ __('Pedido') }}</th>
            <th style="text-align:center;" scope="col">{{ __('Escuela') }}</th>
            <th style="text-align:center;" scope="col">{{ __('Fecha Pedido') }}</th>
            <th style="text-align:center;" scope="col">{{ __('Fecha Entrega') }}</th>
            <th style="text-align:center;" scope="col">{{ __('Monto Total Q') }}</th>
        </tr>
    </thead>
    <tbody>
        @php
        $total = 0;
        @endphp
        @foreach($items[$posicion] as $item)
        <tr>
            <td width="40" style="text-align:center;">{{ $item->estado_pedido->nombre }}</td>
            <td width="40" style="text-align:center;">#{{ $item->id }}</td>
            <td width="100" style="text-align:left;">{{ $item->escuela->establecimiento }}</td>
            <td width="100" style="text-align:center;">{{ date('d/m/Y', strtotime($item->fecha_pedido)) }}</td>
            <td width="100" style="text-align:center;">{{ date('d/m/Y', strtotime($item->fecha_entrega)) }}</td>
            <td width="60" style="text-align:right;">
                @php
                $total += $item->total;
                @endphp
                {{ number_format($item->total, 2, '.', ',') }}
            </td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <td colspan="5" style="text-align:right; vertical-align: bottom !important;">
                <h4>
                    <strong>Total Q</strong>
                </h4>
            </td>
            <td style="text-align:right; color:#00bcd4 !important; font-size: 14px;">
                {{ number_format($total, 2, '.', ',') }}
            </td>
        </tr>
        <tr>
            <th style="text-align:left; background: grey;" colspan="6" scope="col">{{ $footer }}</th>
        </tr>
    </tfoot>
</table>