<table class="dataTable display" style="width:100%">
    <thead>
        <tr>
            <th class="text-center align-middle">Número Cheque</th>
            <th class="text-center align-middle">Banco</th>
            <th class="text-center align-middle">Escuela</th>
            <th class="text-center align-middle">Fecha</th>
            <th class="text-center align-middle">Pedido</th>
            <th class="text-center align-middle">Mes</th>
            <th class="text-center align-middle">Año</th>
            <th class="text-center align-middle">
                <img src="{{ asset('image/ico_opcion.png') }}" title="Opciones" height="20px" alt="Opciones">
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td class="text-center align-middle">{{ $item->numero_cheque }}</td>
            <td class="text-center align-middle">{{ $item->banco->nombre }}</td>
            <td class="text-left align-middle">{{ $item->escuela->establecimiento }}</td>
            <td class="text-center align-middle">{{ date('d/m/Y H:i:s', strtotime($item->created_at)) }}</td>
            <td class="text-center align-middle">
                <a href="{{ route('escuela_pedido.show', $item->escuela_pedido_id) }}" target="_blank"
                    title="Ver información del pedido {{ $item->escuela_pedido_id }}" rel="noopener noreferrer">
                    <img src="{{ asset('image/menu/pedido.png') }}" height="20px" alt="Pedido">
                </a>
            </td>
            <td class="text-center align-middle">{{ $item->mes->nombre }}</td>
            <td class="text-center align-middle">{{ $item->anio }}</td>
            @if ($estado == 1)
            <td class="text-center align-middle">
                <form id="formAnular{{ $item->id }}" method="post" action="{{ route('pago.destroy', $item) }}">
                    @csrf
                    @method('delete')
                    <button rel="tooltip" data-toggle="tooltip" data-placement="top"
                        title="Anular el pago número {{ $item->id }}" class="btn btn-danger btn-sm btnAnular"
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