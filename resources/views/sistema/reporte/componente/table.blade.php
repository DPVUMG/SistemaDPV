@if (!is_null($items))
<h3><strong>{{ $estado }}</strong></h3>
<div class="table-responsive">
    <table class="dataTable display" style="width:100%">
        <thead class="thead-dark">
            <th class="text-center">
                {{ __('Estado') }}
            </th>
            <th class="text-center">
                {{ __('Pedido #') }}
            </th>
            <th class="text-center">
                {{ __('Escuela') }}
            </th>
            <th class="text-center">
                {{ __('Fecha Pedido') }}
            </th>
            <th class="text-center">
                {{ __('Fecha Entrega') }}
            </th>
            <th class="text-center">
                {{ __('Monto Total Q') }}
            </th>
        </thead>
        <tbody>
            @php
            $total = 0;
            @endphp
            @foreach($items[$posicion] as $item)
            <tr>
                <td class="text-left">
                    {{ $item->estado_pedido->nombre }}
                </td>
                <td class="text-center">
                    #{{ $item->id }}
                </td>
                <td class="text-left">
                    {{ $item->escuela->establecimiento }}
                </td>
                <td class="text-center">
                    {{ date('d/m/Y', strtotime($item->fecha_pedido)) }}
                </td>
                <td class="text-center">
                    {{ date('d/m/Y', strtotime($item->fecha_entrega)) }}
                </td>
                <td class="text-right">
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
                <td colspan="5" class="text-right align-bottom">
                    <h4>
                        <strong>Total Q</strong>
                    </h4>
                </td>
                <td class="text-right display-3 text-info">
                    {{ number_format($total, 2, '.', ',') }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@endif