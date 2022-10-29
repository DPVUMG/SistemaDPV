@if (!is_null($items))
<h3><strong>{{ $estado }}</strong></h3>
<div class="table-responsive">
    <table class="dataTable display" style="width:100%">
        <thead class="thead-dark">
            <th class="text-center">
                {{ __('Pedido #') }}
            </th>
            <th class="text-center">
                {{ __('Escuela') }}
            </th>
            <th class="text-center">
                {{ __('Monto Total Q') }}
            </th>
            <th class="text-center">
                {{ __('Fecha Pedido') }}
            </th>
            <th class="text-center">
                {{ __('Fecha Entrega') }}
            </th>
        </thead>
        <tbody>
            @foreach($items[$posicion] as $item)
            <tr>
                <td class="text-center">
                    #{{ $item->id }}
                </td>
                <td class="text-left">
                    {{ $item->escuela->establecimiento }}
                </td>
                <td class="text-right">
                    {{ number_format($item->total, 2, '.', ',') }}
                </td>
                <td class="text-center">
                    {{ date('d/m/Y', strtotime($item->fecha_pedido)) }}
                </td>
                <td class="text-center">
                    {{ date('d/m/Y', strtotime($item->fecha_entrega)) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif