@extends('layouts.app')
@section('title', 'Ordenes')

@section('content')
  <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('order.show', $order) }}">Pedidos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detalle del pedido #{{ $order->id }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h1 class="card-title ">{{ __("Pedido #{$order->id}") }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center"><h3>Nit: {{ $order->nit }}</h3></div>
                            <div class="col-md-9 text-center"><h3>Cliente: {{ $order->name_complete }}</h3></div>
                            <div class="col-md-12 text-center"><h3>Dirección: {{ $order->direction }}</h3></div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 text-center"><h3>Fecha: {{ $order->getStringFechaAttribute() }}</h3></div>
                                    <div class="col-md-12 text-center"><h3>Teléfono: {{ $order->phone }}</h3></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="button" class="btn btn-block btn-{{ $order->getStringColorAttribute() }}"><h1><strong>{{ $order->status }}</strong></h1></button>
                                    </div>
                                    <div class="col-md-12 text-center"><h3>Correo electrónico: {{ $order->email }}</h3></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <h3>
                                    Forma de pago: {{ $order->type_payment }}
                                    @if (!is_null($tipo_credito))
                                        ({{ $tipo_credito->getCreditConcatAttribute() }})
                                    @endif
                                </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                @if ($order->sold)
                                    <button type="button" class="btn btn-block btn-success"><h1><strong>PAGADO</strong></h1></button>
                                @else
                                    <button type="button" class="btn btn-block btn-danger"><h1><strong>NO PAGADO</strong></h1></button>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead class="thead-dark">
                                            <th class="text-center">{{ __('Cantidad') }}</th>
                                            <th class="text-center">{{ __('Producto') }}</th>
                                            <th class="text-center">{{ __('Precio Q') }}</th>
                                            <th class="text-center">{{ __('Descuento') }}</th>
                                            <th class="text-center">{{ __('Sub Total') }}</th>
                                        </thead>
                                        <tbody>
                                            @foreach($detalle as $item)
                                                <tr>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-left">{{ $item->product }}</td>
                                                    <td class="text-right">{{ $item->price }}</td>
                                                    <td class="text-right">{{ $item->getStringDiscountAttribute() }}</td>
                                                    <td class="text-right">{{ $item->getStringSubTotalAttribute() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right"><h3><strong>Total</strong></h3></td>
                                                <td class="text-right"><h3>{{ $order->getStringTotalAttribute() }}</h3></td>
                                            </tr>
                                        </tfoot>
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
@endsection
