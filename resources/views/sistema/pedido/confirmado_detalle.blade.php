@extends('layouts.app')
@section('title', 'Detalle de Confirmación')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('escuela_pedido.index') }}">Pedidos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detalle de Confirmación</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-success">
                        <h4 class="card-title">
                            Pedidos en estado Detalle de Confirmación
                        </h4>
                    </div>
                    <div class="card-body">
                        <br><br><br>
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="card card-profile">
                                    <div class="card-avatar">
                                        <a href="{{ route('escuela.edit', $escuela_pedido_detalle->escuela_id) }}">
                                            <img class="img"
                                                src="{{ $escuela_pedido_detalle->escuela->getPictureAttribute() }}">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title text-uppercase">
                                            Pedido #{{ $escuela_pedido_detalle->id }}
                                        </h3>
                                        <h6 class="card-category text-gray">
                                            {{ $escuela_pedido_detalle->escuela->establecimiento }}
                                        </h6>
                                        <h4 class="card-title">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <ul class="list-group list-group-flush text-nowrap">
                                                        <li class="list-group-item">
                                                            <small class="text-left"><b>Sub Total Q</b></small>
                                                            <p class="display-4" id="sub_total">
                                                                {{ $escuela_pedido_detalle->sub_total }}
                                                            </p>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <small class="text-left"><b>Descuento Q</b></small>
                                                            <p class="display-4" id="descuento">
                                                                {{ $escuela_pedido_detalle->descuento }}
                                                            </p>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <small class="text-left"><b>Total Q</b></small>
                                                            <p class="display-4" id="total">
                                                                {{ $escuela_pedido_detalle->total }}
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </h4>
                                        <a id="btnConfirmarForm"
                                            class="btn btn-block btn-success btn-round">Confirmar</a>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <p class="card-category text-primary">
                                                <i class="material-icons">access_time</i>
                                                Pedido
                                                {{ date('d-m-Y', strtotime($escuela_pedido_detalle->fecha_pedido)) }}
                                            </p>
                                        </div>
                                        <div class="stats">
                                            <p class="card-category text-info">
                                                <i class="material-icons">access_time</i>
                                                Entrega
                                                {{ date('d-m-Y', strtotime($escuela_pedido_detalle->fecha_entrega)) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                                <div class="card card-profile">
                                    @php
                                    $persona = $escuela_pedido_detalle->escuela_usuario->persona;
                                    @endphp
                                    <div class="card-avatar">
                                        <a
                                            href="{{ route('escuela_usuario.edit', $escuela_pedido_detalle->escuela_usuario_id) }}">
                                            <img class="img" src="{{ $persona->getPictureAttribute() }}">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title">
                                            {{ $escuela_pedido_detalle->escuela_usuario->usuario }}
                                        </h3>
                                        <h6 class="card-category text-gray">
                                            {{ $persona->nombre }} {{ $persona->apellido }}
                                        </h6>
                                        {!! $escuela_pedido_detalle->descripcion !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-8 jumbotron">
                                <p class="display-4 bg-primary text-center">
                                    Detalle del Pedido #{{
                                    $escuela_pedido_detalle->id
                                    }}</p>

                                <div class="row">
                                    @php
                                    $registros =
                                    $escuela_pedido_detalle->escuela_detalle_pedido->filter(function($query)
                                    {
                                    return $query->activo;
                                    })->all();
                                    @endphp
                                    <div class="col-sm-12 col-md-12">
                                        <div class=" table-responsive">
                                            <table class="table table-bordered table-sm dataTableCodigos display"
                                                style="width:100%">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th colspan="4" class="text-center align-middle">Producto</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center align-middle">Imagen</th>
                                                        <th class="text-center align-middle">Nombre</th>
                                                        <th class="text-center align-middle">Variante</th>
                                                        <th class="text-center align-middle">Presentación</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($registros as $key => $item)
                                                    <tr>
                                                        <td class="text-center align-middle">
                                                            <div class="card-avatar">
                                                                <a href="{{ route('producto.edit', $item->producto_id) }}"
                                                                    target="_blank">
                                                                    <img class="img" width="75px"
                                                                        src="{{ $item->producto->getPictureAttribute() }}">
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <h4 class="card-title">
                                                                {{ $item->producto->nombre }}
                                                            </h4>
                                                            <h6 class="card-category text-gray">
                                                                {{ $item->producto->codigo }}
                                                            </h6>
                                                            <form id="formAnular{{ $item->id }}" method="post"
                                                                action="{{ route('escuela_pedido_detalle.destroy', $item) }}">
                                                                @csrf
                                                                @method('delete')
                                                                <button rel="tooltip" data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Anular el producto {{ $item->producto->codigo }}"
                                                                    class="btn btn-danger btn-sm btnAnular"
                                                                    id="btnAnular-{{ $item->id }}">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $item->variante->nombre }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $item->presentacion->nombre }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class=" table-responsive">
                                            <table class="table table-bordered table-sm dataTableCodigos display"
                                                style="width:100%">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th rowspan="2" class="text-center align-middle">Cantidad</th>
                                                        <th colspan="3" class="text-center align-middle">Producto</th>
                                                        <th colspan="2" class="text-center align-middle">Precio Q</th>
                                                        <th rowspan="2" class="text-center align-middle">Sub Total Q
                                                        </th>
                                                        <th rowspan="2" class="text-center align-middle">Descuento Q
                                                        </th>
                                                        <th rowspan="2" class="text-center align-middle">Total Q</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center align-middle">Nombre</th>
                                                        <th class="text-center align-middle">Variante</th>
                                                        <th class="text-center align-middle">Presentación</th>

                                                        <th class="text-center align-middle">Real</th>
                                                        <th class="text-center align-middle">Escuela</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <form id="AccionConfirmarForm" method="post"
                                                        action="{{ route('escuela_pedido_detalle.update', $escuela_pedido_detalle->id) }}"
                                                        autocomplete="off" class="form-horizontal">
                                                        @csrf
                                                        @method('PUT')
                                                        @foreach($registros as $key => $item)

                                                        <input name="{{ 'detale['.$key.'][id]' }}"
                                                            value="{{ $item->id }}" aria-required="true" hidden />
                                                        <input name="{{ 'detale['.$key.'][precio_real]' }}"
                                                            value="{{ $item->precio_real }}" aria-required="true"
                                                            hidden />
                                                        <input name="{{ 'detale['.$key.'][precio_descuento]' }}"
                                                            value="{{ $item->precio_descuento }}" aria-required="true"
                                                            hidden />

                                                        <tr>
                                                            <td class="text-center align-middle border-success">
                                                                <div class="form-group">
                                                                    <input
                                                                        class="form-control text-center
                                                        {{ $errors->has('detale['.$key.'][cantidad]') ? ' is-invalid' : '' }} solo-numero"
                                                                        name="{{ 'detale['.$key.'][cantidad]' }}"
                                                                        id="{{ 'detale['.$key.'][cantidad]' }}"
                                                                        type="number" minlength="1"
                                                                        value="{{ old('detale['.$key.'][cantidad]', $item->cantidad) }}"
                                                                        aria-required="true"
                                                                        onchange="reCalcular({{ $key }})" />
                                                                    @if ($errors->has('detale['.$key.'][cantidad]'))
                                                                    <span class="error text-danger">
                                                                        {{ $errors->first('detale['.$key.'][cantidad]')
                                                                        }}
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </td>

                                                            <td class="text-center align-middle">
                                                                <h4 class="card-title">
                                                                    {{ $item->producto->nombre }}
                                                                </h4>
                                                                <h6 class="card-category text-gray">
                                                                    {{ $item->producto->codigo }}
                                                                </h6>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                {{ $item->variante->nombre }}
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                {{ $item->presentacion->nombre }}
                                                            </td>

                                                            @if ($item->precio_descuento == 0)
                                                            <td class="text-right align-middle bg-info">
                                                                {{ $item->precio_real }}
                                                            </td>
                                                            <td class="text-right align-middle">
                                                                <div class="form-group">
                                                                    <input
                                                                        class="form-control text-right
                                                            {{ $errors->has('detale['.$key.'][precio]') ? ' is-invalid' : '' }} decimales"
                                                                        name="{{ 'detale['.$key.'][precio]' }}"
                                                                        id="{{ 'detale['.$key.'][precio]' }}"
                                                                        type="text"
                                                                        value="{{ old('detale['.$key.'][precio]',$item->precio_descuento) }}"
                                                                        aria-required="true"
                                                                        onchange="reCalcular({{ $key }})" />
                                                                    @if ($errors->has('detale['.$key.'][precio]'))
                                                                    <span class="error text-danger">{{
                                                                        $errors->first('detale['.$key.'][precio]')
                                                                        }}</span>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            @else
                                                            <td class="text-right align-middle">
                                                                {{ $item->precio_real }}
                                                            </td>
                                                            <td class="text-right align-middle bg-info">
                                                                <div class="form-group">
                                                                    <input
                                                                        class="form-control text-right
                                                            {{ $errors->has('detale['.$key.'][precio]') ? ' is-invalid' : '' }} decimales"
                                                                        name="{{ 'detale['.$key.'][precio]' }}"
                                                                        id="{{ 'detale['.$key.'][precio]' }}"
                                                                        type="text"
                                                                        value="{{ old('detale['.$key.'][precio]',$item->precio_descuento) }}"
                                                                        aria-required="true"
                                                                        onchange="reCalcular({{ $key }}, true)" />
                                                                    @if ($errors->has('detale['.$key.'][precio]'))
                                                                    <span class="error text-danger">{{
                                                                        $errors->first('detale['.$key.'][precio]')
                                                                        }}</span>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            @endif

                                                            <td class="text-right align-middle"
                                                                id="{{ 'detale['.$key.'][sub_total]' }}">
                                                                {{ $item->sub_total + $item->descuento }}
                                                            </td>
                                                            <td class="text-right align-middle"
                                                                id="{{ 'detale['.$key.'][descuento]' }}">
                                                                {{ $item->descuento }}
                                                            </td>
                                                            <td class="text-right align-middle"
                                                                id="{{ 'detale['.$key.'][total]' }}">
                                                                {{ $item->sub_total }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </form>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    function reCalcular(index, precio_escuela = false) {
        let precio_real = $(`input[name="detale[${index}][precio_real]"]`).val();
        let precio_descuento = $(`input[name="detale[${index}][precio_descuento]"]`).val();
        let descuento_aplicado = parseFloat(precio_real) - parseFloat(precio_descuento);

        let cantidad = $(`input[name="detale[${index}][cantidad]"]`).val();
        let precio = $(`input[name="detale[${index}][precio]"]`).val();
        let sub_totalArray = $(`td[id="detale[${index}][sub_total]"]`).text().replace(/ /g, "").replace(/(\r\n|\n|\r)/gm, "");
        let descuentoArray = $(`td[id="detale[${index}][descuento]"]`).text().replace(/ /g, "").replace(/(\r\n|\n|\r)/gm, "");
        let totalArray = $(`td[id="detale[${index}][total]"]`).text().replace(/ /g, "").replace(/(\r\n|\n|\r)/gm, "");

        let sub_total = $("#sub_total").text().replace(/ /g, "").replace(/(\r\n|\n|\r)/gm, "");
        let descuento = $("#descuento").text().replace(/ /g, "").replace(/(\r\n|\n|\r)/gm, "");
        let total = $("#total").text().replace(/ /g, "").replace(/(\r\n|\n|\r)/gm, "");

        if(cantidad && precio)
        {
            precio = parseFloat(precio) == 0 ? parseFloat(precio_real) : parseFloat(precio);

            let sub_totalArrayNew = parseInt(cantidad) * parseFloat(precio_real);
            let descuentoArrayNew = parseInt(cantidad) * (parseFloat(precio_real) - parseFloat(precio));
            let totalArrayNew = parseInt(cantidad) * parseFloat(precio);

            let sub_totalNew = (parseFloat(sub_total) - parseFloat(sub_totalArray)) + sub_totalArrayNew
            let descuentoNew = (parseFloat(descuento) - parseFloat(descuentoArray)) + descuentoArrayNew
            let totalNew = (parseFloat(total) - parseFloat(totalArray)) + totalArrayNew

            $(`td[id="detale[${index}][sub_total]"]`).text(sub_totalArrayNew)
            if(parseFloat(precio) > 0 || parseFloat(precio_descuento) > 0) {
                $(`td[id="detale[${index}][descuento]"]`).text(descuentoArrayNew)
            }
            $(`td[id="detale[${index}][total]"]`).text(totalArrayNew)

            $("#sub_total").text(sub_totalNew)
            if(parseFloat(precio) > 0 || parseFloat(precio_descuento) > 0) {
                $("#descuento").text(descuentoNew)
            }
            $("#total").text(totalNew)
        } else {
            !cantidad ? $(`input[name="detale[${index}][cantidad]"]`).val(1) : null
            !precio ? $(`input[name="detale[${index}][precio]"]`).val(0) : null
        }
    }

    $("#btnConfirmarForm").on( "click", function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Confirmar Pedido?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'SI',
            cancelButtonText: 'NO'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#AccionConfirmarForm").first().submit();
            }
        })
    });
</script>
@endpush