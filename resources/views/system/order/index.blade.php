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
                        <li class="breadcrumb-item active" aria-current="page">Ordenes</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">{{ __('Ordenes') }}</h4>
                        <p class="card-category"> {{ __('Sección que muestra todos las ordenes registradas.') }}</p>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-default pull-right">
                            Página
                            <span class="badge badge-light">{{ number_format($items->currentPage(),0,'',',') }}</span>
                            de
                            <span class="badge badge-light">{{ $items->total() > $items->perPage() ? number_format($items->perPage(),0,'',',') : number_format($items->total(),0,'',',') }}</span>
                            registros, mostrados
                            <span class="badge badge-light">{{ $items->total() > $items->perPage() ? number_format($items->perPage() * $items->currentPage(),0,'',',') : number_format($items->total(),0,'',',') }}</span>
                            de un total de
                            <span class="badge badge-light">{{ number_format($items->total(),0,'',',') }}</span>
                            registros
                        </button>
                        <form method="get" action="{{ route('order.index') }}" autocomplete="off" class="form-horizontal">
                            @csrf
                            @method('get')
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search">
                                <div class="input-group-append">
                                    <button rel="tooltip" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Buscar información" type="submit">Buscar</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <th class="text-center">{{ __('#') }}</th>
                                    <th class="text-center">{{ __('Cliente') }}</th>
                                    <th class="text-center">{{ __('Dirección') }}</th>
                                    <th class="text-center">{{ __('Teléfono') }}</th>
                                    <th class="text-center">{{ __('Total') }}</th>
                                    <th class="text-center">{{ __('Fecha') }}</th>
                                    <th class="text-center">{{ __('Forma de Pago') }}</th>
                                    <th class="text-center">{{ __('Pagado') }}</th>
                                    <th class="text-center">{{ __('Opciones') }}</th>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->id }}</td>
                                            <td class="text-left">{{ $item->nit.' '.$item->name_complete }}</td>
                                            <td class="text-left">{{ $item->direction }}</td>
                                            <td class="text-center">{{ $item->phone }}</td>
                                            <td class="text-right">{{ $item->getStringTotalAttribute() }}</td>
                                            <td class="text-center">{{ $item->getStringFechaAttribute() }}</td>
                                            <td class="text-center">{{ $item->type_payment }}</td>
                                            <td class="text-center">
                                                @if ($item->sold)
                                                    <button type="button" class="btn btn-block btn-success"><strong>PAGADO</strong></button>
                                                @else
                                                    <button type="button" class="btn btn-block btn-danger"><strong>NO PAGADO</strong></button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a rel="tooltip" class="btn btn-primary btn-sm btn-round" href="{{ route('order.show', $item) }}" data-toggle="tooltip" data-placement="top" title="Ver detalle del pedido">
                                                    <i class="material-icons">speaker_notes</i>
                                                    <div class="ripple-container"></div>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end">
                                {{ $items->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
