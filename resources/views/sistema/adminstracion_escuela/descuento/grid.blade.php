<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Descuentos Activos</a></li>
        <li><a href="#tabs-2">Historial</a></li>
    </ul>
    <div id="tabs-1">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title ">
                    {{ __('Descuentos Activos') }}
                </h4>
                @if (is_null($establecimiento))
                <p class="card-category"> {{ __("En esta pantalla el sistema muestra todos los descuentos
                    registrados en el sistema.") }}</p>
                @else
                <p class="card-category"> {{ __("En esta pantalla el sistema muestra todos los descuentos
                    registrados en la escuela {$establecimiento}.") }}</p>
                @endif
            </div>
            <div class="card-body">
                <table class="dataTable display" style="width:100%">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center align-middle">Escuela</th>
                            <th rowspan="2" class="text-center align-middle">Fotografía</th>
                            <th colspan="3" class="text-center align-middle">Producto</th>
                            <th colspan="2" class="text-center align-middle">Información</th>
                            <th colspan="2" class="text-center align-middle">Precio</th>
                            <th rowspan="2" class="text-center align-middle">Registrado</th>
                            <th rowspan="2" class="text-center align-middle">
                                <img src="{{ asset('image/ico_opcion.png') }}" title="Opciones" height="20px"
                                    alt="Opciones">
                            </th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Código</th>
                            <th class="text-center align-middle">Nombre</th>
                            <th class="text-center align-middle">Descripción</th>

                            <th class="text-center align-middle">Variante</th>
                            <th class="text-center align-middle">Presentacion</th>

                            <th class="text-center align-middle">Precio Real</th>
                            <th class="text-center align-middle">Precio Descuento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data->filter(function($item) {
                        return $item->activo;
                        })->all() as $item)
                        <tr>
                            <td class="text-left align-middle">{{ $item->escuela->establecimiento }}</td>

                            <td class="text-center align-middle">
                                <img src="{{ $item->producto->getPictureAttribute() }}"
                                    alt="{{ $item->producto->codigo }}" width="100px" class="img img-thumbnail">
                            </td>

                            <td class="text-center align-middle">{{ $item->producto->codigo }}</td>
                            <td class="text-left align-middle">{{ $item->producto->nombre }}</td>
                            <td class="text-left align-middle">{!! $item->producto->descripcion !!}</td>

                            <td class="text-center align-middle">{{ $item->variante->nombre }}</td>
                            <td class="text-center align-middle">{{ $item->presentacion->nombre }}</td>

                            <td class="text-right align-middle">{{ number_format($item->precio_original,2) }}</td>
                            <td class="text-right align-middle">{{ number_format($item->precio,2) }}</td>

                            <td class="text-center align-middle">{{ date('d/m/Y H:i:s', strtotime($item->created_at))
                                }}</td>


                            <td class="text-center align-middle">
                                @if (is_null($establecimiento))
                                <form id="formStatus{{ $item->id }}" method="get"
                                    action="{{ route('escuela_descuento.status', $item) }}">
                                    @csrf
                                    @method('get')
                                    <button rel="tooltip" data-toggle="tooltip" data-placement="top"
                                        title="{{ $item->activo ? " Desactivar {$item->producto->nombre} descuento
                                        {$item->precio}" :
                                        "Activar {$item->producto->nombre} descuento {$item->precio}"
                                        }}"
                                        class="{{ $item->activo ? 'btn btn-info btn-sm btn-round' : 'btn
                                        btn-default btn-sm btn-round' }} btnStatus"
                                        id="btnStatus-{{ $item->id }}">
                                        <i class="material-icons">toggle_on</i>
                                        <div class="ripple-container"></div>
                                    </button>
                                </form>
                                @else
                                <form id="formStatus{{ $item->id }}" method="post"
                                    action="{{ route('escuela_descuento.destroy', $item) }}">
                                    @csrf
                                    @method('delete')
                                    <button rel="tooltip" data-toggle="tooltip" data-placement="top"
                                        title="{{ $item->activo ? " Desactivar {$item->producto->nombre} descuento
                                        {$item->precio}" :
                                        "Activar {$item->producto->nombre} descuento {$item->precio}"
                                        }}"
                                        class="{{ $item->activo ? 'btn btn-info btn-sm btn-round' : 'btn
                                        btn-default btn-sm btn-round' }} btnStatus"
                                        id="btnStatus-{{ $item->id }}">
                                        <i class="material-icons">toggle_on</i>
                                        <div class="ripple-container"></div>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="tabs-2">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title ">
                    {{ __('Descuentos históricos') }}
                </h4>
                @if (is_null($establecimiento))
                <p class="card-category"> {{ __("En esta pantalla el sistema muestra todos los descuentos
                    registrados en el sistema.") }}</p>
                @else
                <p class="card-category"> {{ __("En esta pantalla el sistema muestra todos los descuentos
                    registrados en la escuela {$establecimiento}.") }}</p>
                @endif
            </div>
            <div class="card-body">
                <table class="dataTable display" style="width:100%">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center align-middle">Escuela</th>
                            <th rowspan="2" class="text-center align-middle">Fotografía</th>
                            <th colspan="3" class="text-center align-middle">Producto</th>
                            <th colspan="2" class="text-center align-middle">Información</th>
                            <th colspan="2" class="text-center align-middle">Precio</th>
                            <th rowspan="2" class="text-center align-middle">Registrado</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Código</th>
                            <th class="text-center align-middle">Nombre</th>
                            <th class="text-center align-middle">Descripción</th>

                            <th class="text-center align-middle">Variante</th>
                            <th class="text-center align-middle">Presentacion</th>

                            <th class="text-center align-middle">Precio Real</th>
                            <th class="text-center align-middle">Precio Descuento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data->filter(function($item) {
                        return !$item->activo;
                        })->all() as $item)
                        <tr>
                            <td class="text-left align-middle">{{ $item->escuela->establecimiento }}</td>

                            <td class="text-center align-middle">
                                <img src="{{ $item->producto->getPictureAttribute() }}"
                                    alt="{{ $item->producto->codigo }}" width="100px" class="img img-thumbnail">
                            </td>

                            <td class="text-center align-middle">{{ $item->producto->codigo }}</td>
                            <td class="text-left align-middle">{{ $item->producto->nombre }}</td>
                            <td class="text-left align-middle">{!! $item->producto->descripcion !!}</td>

                            <td class="text-center align-middle">{{ $item->variante->nombre }}</td>
                            <td class="text-center align-middle">{{ $item->presentacion->nombre }}</td>

                            <td class="text-right align-middle">{{ number_format($item->precio_original,2) }}</td>
                            <td class="text-right align-middle">{{ number_format($item->precio,2) }}</td>

                            <td class="text-center align-middle">{{ date('d/m/Y H:i:s', strtotime($item->created_at))
                                }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('js')
<script type="text/javascript">
    $( function() {
$( "#tabs" ).tabs();
} );
</script>
@endpush
