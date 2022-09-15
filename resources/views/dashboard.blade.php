@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
  <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">{{ __('Pedidos') }}</h4>
                        <p class="card-category"> {{ __('Sección que muestra todos los pedidos registrados.') }}</p>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-default pull-right">
                            Página
                            <span class="badge badge-light">{{ number_format($pedidos->currentPage(),0,'',',') }}</span>
                            de
                            <span class="badge badge-light">{{ $pedidos->total() > $pedidos->perPage() ? number_format($pedidos->perPage(),0,'',',') : number_format($pedidos->total(),0,'',',') }}</span>
                            registros, mostrados
                            <span class="badge badge-light">{{ $pedidos->total() > $pedidos->perPage() ? number_format($pedidos->perPage() * $pedidos->currentPage(),0,'',',') : number_format($pedidos->total(),0,'',',') }}</span>
                            de un total de
                            <span class="badge badge-light">{{ number_format($pedidos->total(),0,'',',') }}</span>
                            registros
                        </button>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <th class="text-center">{{ __('#') }}</th>
                                    <th class="text-center">{{ __('Cliente') }}</th>
                                    <th class="text-center">{{ __('Dirección') }}</th>
                                    <th class="text-center">{{ __('Teléfono') }}</th>
                                    <th class="text-center">{{ __('Total') }}</th>
                                    <th class="text-center">{{ __('Fecha') }}</th>
                                    <th class="text-center">{{ __('Opciones') }}</th>
                                </thead>
                                <tbody>
                                    @foreach($pedidos as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->id }}</td>
                                            <td class="text-left">{{ $item->nit.' '.$item->name_complete }}</td>
                                            <td class="text-left">{{ $item->direction }}</td>
                                            <td class="text-center">{{ $item->phone }}</td>
                                            <td class="text-right">{{ $item->getStringTotalAttribute() }}</td>
                                            <td class="text-center">{{ $item->getStringFechaAttribute() }}</td>
                                            <td class="text-center">
                                                <form method="post" action="{{ route('order.delete', $item) }}">
                                                    @csrf
                                                    @method('delete')
                                                    @if (Auth::user()->admin)
                                                        <button rel="tooltip" data-toggle="tooltip" data-placement="top" title="Anular" type="button" class="btn btn-danger btn-sm btn-round" onclick="confirm('{{ __("¿Está seguro que desea eliminar el registro {$item->id}?") }}') ? this.parentElement.submit() : ''">
                                                            <i class="material-icons">thumb_down</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                    @endif
                                                    <a rel="tooltip" class="btn btn-primary btn-sm btn-round" href="{{ route('order.show', $item) }}" data-toggle="tooltip" data-placement="top" title="Ver detalle del pedido">
                                                        <i class="material-icons">speaker_notes</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                    <a rel="tooltip" class="btn btn-info btn-sm btn-round" href="{{ route('order.update', $item) }}" data-toggle="tooltip" data-placement="top" title="Enviar al proceso">
                                                        <i class="material-icons">thumb_up</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end">
                                {{ $pedidos->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-success">
                        <h4 class="card-title ">{{ __('Procesos') }}</h4>
                        <p class="card-category"> {{ __('Sección que muestra todos los procesos registrados.') }}</p>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-default pull-right">
                            Página
                            <span class="badge badge-light">{{ number_format($procesos->currentPage(),0,'',',') }}</span>
                            de
                            <span class="badge badge-light">{{ $procesos->total() > $procesos->perPage() ? number_format($procesos->perPage(),0,'',',') : number_format($procesos->total(),0,'',',') }}</span>
                            registros, mostrados
                            <span class="badge badge-light">{{ $procesos->total() > $procesos->perPage() ? number_format($procesos->perPage() * $procesos->currentPage(),0,'',',') : number_format($procesos->total(),0,'',',') }}</span>
                            de un total de
                            <span class="badge badge-light">{{ number_format($procesos->total(),0,'',',') }}</span>
                            registros
                        </button>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <th class="text-center">{{ __('#') }}</th>
                                    <th class="text-center">{{ __('Cliente') }}</th>
                                    <th class="text-center">{{ __('Dirección') }}</th>
                                    <th class="text-center">{{ __('Teléfono') }}</th>
                                    <th class="text-center">{{ __('Total') }}</th>
                                    <th class="text-center">{{ __('Fecha') }}</th>
                                    <th class="text-center">{{ __('Opciones') }}</th>
                                </thead>
                                <tbody>
                                    @foreach($procesos as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->id }}</td>
                                            <td class="text-left">{{ $item->nit.' '.$item->name_complete }}</td>
                                            <td class="text-left">{{ $item->direction }}</td>
                                            <td class="text-center">{{ $item->phone }}</td>
                                            <td class="text-right">{{ $item->getStringTotalAttribute() }}</td>
                                            <td class="text-center">{{ $item->getStringFechaAttribute() }}</td>
                                            <td class="text-center">
                                                <form method="post" action="{{ route('order.delete', $item) }}">
                                                    @csrf
                                                    @method('delete')
                                                    @if (Auth::user()->admin)
                                                        <button rel="tooltip" data-toggle="tooltip" data-placement="top" title="Anular" type="button" class="btn btn-danger btn-sm btn-round" onclick="confirm('{{ __("¿Está seguro que desea eliminar el registro {$item->id}?") }}') ? this.parentElement.submit() : ''">
                                                            <i class="material-icons">thumb_down</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                    @endif
                                                    <a rel="tooltip" class="btn btn-primary btn-sm btn-round" href="{{ route('order.show', $item) }}" data-toggle="tooltip" data-placement="top" title="Ver detalle del pedido">
                                                        <i class="material-icons">speaker_notes</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                    <a rel="tooltip" class="btn btn-success btn-sm btn-round" href="{{ route('order.update', $item) }}" data-toggle="tooltip" data-placement="top" title="Facturar producto">
                                                        <i class="material-icons">thumb_up</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end">
                                {{ $procesos->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-success">
                        <h4 class="card-title ">{{ __('Facturados') }}</h4>
                        <p class="card-category"> {{ __('Sección que muestra todos los pedidos facturados.') }}</p>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-default pull-right">
                            Página
                            <span class="badge badge-light">{{ number_format($procesos->currentPage(),0,'',',') }}</span>
                            de
                            <span class="badge badge-light">{{ $procesos->total() > $procesos->perPage() ? number_format($procesos->perPage(),0,'',',') : number_format($procesos->total(),0,'',',') }}</span>
                            registros, mostrados
                            <span class="badge badge-light">{{ $procesos->total() > $procesos->perPage() ? number_format($procesos->perPage() * $procesos->currentPage(),0,'',',') : number_format($procesos->total(),0,'',',') }}</span>
                            de un total de
                            <span class="badge badge-light">{{ number_format($procesos->total(),0,'',',') }}</span>
                            registros
                        </button>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <th class="text-center">{{ __('#') }}</th>
                                    <th class="text-center">{{ __('Cliente') }}</th>
                                    <th class="text-center">{{ __('Dirección') }}</th>
                                    <th class="text-center">{{ __('Teléfono') }}</th>
                                    <th class="text-center">{{ __('Total') }}</th>
                                    <th class="text-center">{{ __('Fecha') }}</th>
                                    <th class="text-center">{{ __('Opciones') }}</th>
                                </thead>
                                <tbody>
                                    @foreach($facturados as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->id }}</td>
                                            <td class="text-left">{{ $item->nit.' '.$item->name_complete }}</td>
                                            <td class="text-left">{{ $item->direction }}</td>
                                            <td class="text-center">{{ $item->phone }}</td>
                                            <td class="text-right">{{ $item->getStringTotalAttribute() }}</td>
                                            <td class="text-center">{{ $item->getStringFechaAttribute() }}</td>
                                            <td class="text-center">
                                                <form method="post" action="{{ route('order.delete', $item) }}">
                                                    @csrf
                                                    @method('delete')
                                                    @if (Auth::user()->admin)
                                                        <button rel="tooltip" data-toggle="tooltip" data-placement="top" title="Anular" type="button" class="btn btn-danger btn-sm btn-round" onclick="confirm('{{ __("¿Está seguro que desea eliminar el registro {$item->id}?") }}') ? this.parentElement.submit() : ''">
                                                            <i class="material-icons">thumb_down</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                    @endif
                                                    <a rel="tooltip" class="btn btn-primary btn-sm btn-round" href="{{ route('order.show', $item) }}" data-toggle="tooltip" data-placement="top" title="Ver detalle del pedido">
                                                        <i class="material-icons">speaker_notes</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                    <a rel="tooltip" class="btn btn-success btn-sm btn-round" href="{{ route('order.update', $item) }}" data-toggle="tooltip" data-placement="top" title="Entregar producto">
                                                        <i class="material-icons">thumb_up</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end">
                                {{ $procesos->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title ">{{ __('Entregados') }}</h4>
                        <p class="card-category"> {{ __('Sección que muestra todos los entregados registrados.') }}</p>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-default pull-right">
                            Página
                            <span class="badge badge-light">{{ number_format($entregados->currentPage(),0,'',',') }}</span>
                            de
                            <span class="badge badge-light">{{ $entregados->total() > $entregados->perPage() ? number_format($entregados->perPage(),0,'',',') : number_format($entregados->total(),0,'',',') }}</span>
                            registros, mostrados
                            <span class="badge badge-light">{{ $entregados->total() > $entregados->perPage() ? number_format($entregados->perPage() * $entregados->currentPage(),0,'',',') : number_format($entregados->total(),0,'',',') }}</span>
                            de un total de
                            <span class="badge badge-light">{{ number_format($entregados->total(),0,'',',') }}</span>
                            registros
                        </button>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <th class="text-center">{{ __('#') }}</th>
                                    <th class="text-center">{{ __('Cliente') }}</th>
                                    <th class="text-center">{{ __('Dirección') }}</th>
                                    <th class="text-center">{{ __('Teléfono') }}</th>
                                    <th class="text-center">{{ __('Total') }}</th>
                                    <th class="text-center">{{ __('Fecha') }}</th>
                                </thead>
                                <tbody>
                                    @foreach($entregados as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->id }}</td>
                                            <td class="text-left">{{ $item->nit.' '.$item->name_complete }}</td>
                                            <td class="text-left">{{ $item->direction }}</td>
                                            <td class="text-center">{{ $item->phone }}</td>
                                            <td class="text-right">{{ $item->getStringTotalAttribute() }}</td>
                                            <td class="text-center">{{ $item->getStringFechaAttribute() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end">
                                {{ $entregados->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-danger">
                        <h4 class="card-title ">{{ __('Anulados') }}</h4>
                        <p class="card-category"> {{ __('Sección que muestra todos los anulados registrados.') }}</p>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-default pull-right">
                            Página
                            <span class="badge badge-light">{{ number_format($anulados->currentPage(),0,'',',') }}</span>
                            de
                            <span class="badge badge-light">{{ $anulados->total() > $anulados->perPage() ? number_format($anulados->perPage(),0,'',',') : number_format($anulados->total(),0,'',',') }}</span>
                            registros, mostrados
                            <span class="badge badge-light">{{ $anulados->total() > $anulados->perPage() ? number_format($anulados->perPage() * $anulados->currentPage(),0,'',',') : number_format($anulados->total(),0,'',',') }}</span>
                            de un total de
                            <span class="badge badge-light">{{ number_format($anulados->total(),0,'',',') }}</span>
                            registros
                        </button>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <th class="text-center">{{ __('#') }}</th>
                                    <th class="text-center">{{ __('Cliente') }}</th>
                                    <th class="text-center">{{ __('Dirección') }}</th>
                                    <th class="text-center">{{ __('Teléfono') }}</th>
                                    <th class="text-center">{{ __('Total') }}</th>
                                    <th class="text-center">{{ __('Fecha') }}</th>
                                </thead>
                                <tbody>
                                    @foreach($anulados as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->id }}</td>
                                            <td class="text-left">{{ $item->nit.' '.$item->name_complete }}</td>
                                            <td class="text-left">{{ $item->direction }}</td>
                                            <td class="text-center">{{ $item->phone }}</td>
                                            <td class="text-right">{{ $item->getStringTotalAttribute() }}</td>
                                            <td class="text-center">{{ $item->getStringFechaAttribute() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end">
                                {{ $anulados->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
