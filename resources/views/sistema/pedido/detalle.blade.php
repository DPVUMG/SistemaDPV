@extends('layouts.app')
@section('title', 'Detalle del Pedido')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a onclick="window.history.back()">Regresar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Detalle del Pedido #{{ $escuela_pedido->id }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-success">
                        <h4 class="card-title">
                            Información del Pedido #{{ $escuela_pedido->id }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <br><br><br>
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="card card-profile">
                                    <div class="card-avatar">
                                        <a href="{{ route('escuela.edit', $escuela_pedido->escuela_id) }}">
                                            <img class="img"
                                                src="{{ $escuela_pedido->escuela->getPictureAttribute() }}">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title text-uppercase">
                                            Pedido #{{ $escuela_pedido->id }}
                                        </h3>
                                        <h6 class="card-category text-gray">
                                            {{ $escuela_pedido->escuela->establecimiento }}
                                        </h6>
                                        <h4 class="card-title">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <ul class="list-group list-group-flush text-nowrap">
                                                        <li class="list-group-item">
                                                            <small class="text-left"><b>Sub Total Q</b></small>
                                                            <p class="display-4" id="sub_total">
                                                                {{
                                                                number_format($escuela_pedido->sub_total, 2, '.', ',')
                                                                }}
                                                            </p>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <small class="text-left"><b>Descuento Q</b></small>
                                                            <p class="display-4" id="descuento">
                                                                {{
                                                                number_format($escuela_pedido->descuento, 2, '.', ',')
                                                                }}
                                                            </p>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <small class="text-left"><b>Total Q</b></small>
                                                            <p class="display-4" id="total">
                                                                {{
                                                                number_format($escuela_pedido->total, 2, '.', ',')
                                                                }}
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </h4>
                                        @if (!is_null($escuela_pedido->pago_pedido))
                                        <div class="alert alert-info info">
                                            <div class="icon icon-primary">
                                                <i class="material-icons text-white">money</i>
                                            </div>
                                            <h4 class="info-title text-white">Pago realizado</h4>
                                            <p>
                                                Número de Cheque: {{ $escuela_pedido->pago_pedido->numero_cheque }}
                                                <hr>
                                                Banco: {{ $escuela_pedido->pago_pedido->banco->nombre }}
                                                <hr>
                                                Fecha: {{
                                                date('d-m-Y H:i:s', strtotime($escuela_pedido->pago_pedido->created_at))
                                                }}
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <p class="card-category text-primary">
                                                <i class="material-icons">access_time</i>
                                                Pedido
                                                {{ date('d-m-Y', strtotime($escuela_pedido->fecha_pedido)) }}
                                            </p>
                                        </div>
                                        <div class="stats">
                                            <p class="card-category text-info">
                                                <i class="material-icons">access_time</i>
                                                Entrega
                                                {{ date('d-m-Y', strtotime($escuela_pedido->fecha_entrega)) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                                <div class="card card-profile">
                                    @php
                                    $persona = $escuela_pedido->escuela_usuario->persona;
                                    @endphp
                                    <div class="card-avatar">
                                        <a
                                            href="{{ route('escuela_usuario.edit', $escuela_pedido->escuela_usuario_id) }}">
                                            <img class="img" src="{{ $persona->getPictureAttribute() }}">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title">
                                            {{ $escuela_pedido->escuela_usuario->usuario }}
                                        </h3>
                                        <h6 class="card-category text-gray">
                                            {{ $persona->nombre }} {{ $persona->apellido }}
                                        </h6>
                                        {!! $escuela_pedido->descripcion !!}
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Bitácora</h3>
                                        <div class="timeline">
                                            @foreach ($escuela_pedido->escuela_pedido_historial as $item)<div
                                                class="{{ $item->getColorAttribute($item->estado_pedido_id) }}">
                                                <div class="timeline-icon">
                                                    <i
                                                        class="{{ $item->getIconAttribute($item->estado_pedido_id) }}"></i>
                                                </div>
                                                <div class="timeline-body">
                                                    <h4 class="timeline-title">
                                                        <span class="badge">
                                                            {{ $item->estado_anterior }}
                                                        </span>
                                                    </h4>
                                                    <p>
                                                        {{ $item->descripcion }}
                                                    </p>
                                                    <p class="timeline-subtitle">
                                                        <i class=" fa fa-clock-o"></i>
                                                        {{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}
                                                    </p>
                                                    <p class="timeline-subtitle">
                                                        <i class="fa fa-user"></i>
                                                        {{ $item->usuario }}
                                                    </p>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-8 jumbotron">
                                <p class="display-4 bg-primary text-center">
                                    Detalle del Pedido #{{ $escuela_pedido->id }}
                                </p>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm dataTableCodigos display"
                                                style="width:100%">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th rowspan="2" class="text-center align-middle">Cantidad
                                                        </th>
                                                        <th colspan="4" class="text-center align-middle">Producto
                                                        </th>
                                                        <th colspan="2" class="text-center align-middle">Precio Q
                                                        </th>
                                                        <th rowspan="2" class="text-center align-middle">Sub Total Q
                                                        </th>
                                                        <th rowspan="2" class="text-center align-middle">Descuento Q
                                                        </th>
                                                        <th rowspan="2" class="text-center align-middle">Total Q
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center align-middle">Imagen</th>
                                                        <th class="text-center align-middle">Nombre</th>
                                                        <th class="text-center align-middle">Variante</th>
                                                        <th class="text-center align-middle">Presentación</th>

                                                        <th class="text-center align-middle">Real</th>
                                                        <th class="text-center align-middle">Escuela</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($escuela_pedido->escuela_detalle_pedido as $item)
                                                    <tr class="{{ !$item->activo ? 'bg-danger text-white' : '' }}">
                                                        <td class="text-center align-middle">
                                                            {{ $item->cantidad }}
                                                        </td>

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
                                                            <h4 class="card-title text-black">
                                                                {{ $item->producto->nombre }}
                                                            </h4>
                                                            <h6 class="card-category text-black">
                                                                {{ $item->producto->codigo }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $item->variante->nombre }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $item->presentacion->nombre }}
                                                        </td>

                                                        <td class="text-right">
                                                            {{ number_format($item->precio_real, 2, '.', ',') }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ number_format($item->precio_descuento, 2, '.', ',')
                                                            }}
                                                        </td>

                                                        <td class="text-right align-middle">
                                                            {{ number_format($item->sub_total + $item->descuento, 2,
                                                            '.', ',') }}
                                                        </td>
                                                        <td class="text-right align-middle">
                                                            {{ number_format($item->descuento, 2, '.', ',') }}
                                                        </td>
                                                        <td class="text-right align-middle">
                                                            {{ number_format($item->sub_total, 2, '.', ',') }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
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