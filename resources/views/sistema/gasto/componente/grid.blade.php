<div class="card">
    <div class="card-header card-header-info">
        <h4 class="card-title">{{ __('Gastos registrados') }}</h4>
        <p class="card-category">{{ "En esta sección se muestran todos los gastos registrados en el
            sistema." }}</p>
    </div>
    <div class="card-body">
        <table class="dataTable display" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center align-middle">Fecha</th>
                    <th class="text-center align-middle">Descripción</th>
                    <th class="text-center align-middle">Monto</th>
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
                    <td class="text-center align-middle">{{ date('d/m/Y H:i:s',
                        strtotime($item->created_at)) }}</td>
                    <td class="text-center align-middle">{{ $item->descripcion }}</td>
                    <td class="text-right align-middle">Q {{ number_format($item->monto, 2, '.', ',') }}
                    </td>
                    <td class="text-center align-middle">{{ $item->mes->nombre }}</td>
                    <td class="text-center align-middle">{{ $item->anio }}</td>
                    <td class="text-center align-middle">
                        <form id="formAnular{{ $item->id }}" method="post" action="{{ route('gasto.destroy', $item) }}">
                            @csrf
                            @method('delete')
                            <button rel="tooltip" data-toggle="tooltip" data-placement="top"
                                title="Anular el gasto número {{ $item->id }}" class="btn btn-danger btn-sm btnAnular"
                                id="btnAnular-{{ $item->id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>