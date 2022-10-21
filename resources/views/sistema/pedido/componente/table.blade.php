<table class="dataTable display" style="width:100%">
    <thead>
        <tr>
            <th rowspan="2" class="text-center align-middle">Número</th>
            <th rowspan="2" class="text-center align-middle">Escuela</th>
            <th colspan="3" class="text-center align-middle">Fecha</th>
            <th rowspan="2" class="text-center align-middle">Descripción</th>
            <th colspan="3" class="text-center align-middle">Pedido</th>
            <th rowspan="2" class="text-center align-middle">Solicitante</th>
            <th rowspan="2" class="text-center align-middle">Mes</th>
            <th rowspan="2" class="text-center align-middle">Año</th>
            @if ($estado == 1)
            <th rowspan="2" class="text-center align-middle">
                <img src="{{ asset('image/ico_opcion.png') }}" title="Opciones" height="20px" alt="Opciones">
            </th>
            @endif
        </tr>
        <tr>
            <th class="text-center align-middle">Pedido</th>
            <th class="text-center align-middle">Entrega</th>
            <th class="text-center align-middle">Creado</th>

            <th class="text-center align-middle">Descuento</th>
            <th class="text-center align-middle">Sub Total</th>
            <th class="text-center align-middle">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td class="text-center align-middle">{{ $item->id }}</td>
            <td class="text-left align-middle">{{ $item->escuela }}</td>

            <td class="text-center align-middle">{{ date('d/m/Y', strtotime($item->fecha_pedido)) }}</td>
            <td class="text-center align-middle">{{ date('d/m/Y', strtotime($item->fecha_entrega)) }}</td>
            <td class="text-center align-middle">{{ date('d/m/Y H:i:s', strtotime($item->created_at)) }}</td>

            <td class="align-middle">{!! $item->descripcion !!}</td>

            <td class="text-right align-middle">{{ number_format($item->descuento, 2, ',', '.') }}</td>
            <td class="text-right align-middle">{{ number_format($item->sub_total, 2, ',', '.') }}</td>
            <td class="text-right align-middle">{{ number_format($item->total, 2, ',', '.') }}</td>

            <td class="text-left align-middle">{{ $item->solicitante }}</td>
            <td class="text-center align-middle">{{ $item->mes }}</td>
            <td class="text-center align-middle">{{ $item->anio }}</td>
            @if ($estado == 1)
            <td class="text-center align-middle">
                <a rel="tooltip" class="btn btn-success btn-sm btn-round"
                    href="{{ route('escuela_pedido_detalle.show', $item->id) }}" data-toggle="tooltip"
                    data-placement="top" title="Confirmar pedido número {{ $item->id }}">
                    <i class="fa fa-check-circle"></i>
                </a>
                <form id="formAnular{{ $item->id }}" method="post"
                    action="{{ route('escuela_pedido.destroy', $item) }}">
                    @csrf
                    @method('delete')
                    <button rel="tooltip" data-toggle="tooltip" data-placement="top"
                        title="Anular el pedido número {{ $item->id }}" class="btn btn-danger btn-sm btnAnular"
                        id="btnAnular-{{ $item->id }}">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>