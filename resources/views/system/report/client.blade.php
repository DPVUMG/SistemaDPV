@extends('layouts.app')
@section('title', 'Reporte')

@section('content')
  <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reporte de cliente</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">{{$title}}</h4>
                        <p class="card-category">
                            {{ $description }}
                            @if (!is_null($client))
                                <a rel="tooltip" class="btn btn-success btn-sm btn-round" href="{{ route('pdf.client', ['user_id'=>$user_id]) }}" data-toggle="tooltip" data-placement="top" title="Imprimir">PDF</a>
                            @endif
                        </p>
                    </div>
                    <div class="card-body">
                        <form method="get" action="{{ route('report.client') }}" autocomplete="off" class="form-horizontal">
                            @csrf
                            @method('get')
                            <div class="input-group {{ $errors->has('user_id') ? ' has-danger' : '' }} mb-3">
                                <select data-live-search="true" data-style="btn-default" class="selectpicker form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}" name="user_id" id="input-user_id">
                                    <option value="">Seleccionar un cliente</option>
                                    @foreach ($clientes as $item)
                                        <option value="{{ $item->id }}"
                                        {{ ($item->id == old('user_id',$user_id)) ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button rel="tooltip" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Buscar información" type="submit">Buscar</button>
                                </div>
                            </div>
                            @if ($errors->has('user_id'))
                                <span id="user_id-error" class="error text-danger" for="input-user_id">{{ $errors->first('user_id') }}</span>
                            @endif
                        </form>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                @if (!is_null($pedidos_creditos))
                                    <h3>Pedidos al crédito ({{ $pedidos_creditos->count() }})</h3>
                                    <button type="button" class="btn btn-default pull-right">
                                        Página
                                        <span class="badge badge-light">{{ number_format($pedidos_creditos->currentPage(),0,'',',') }}</span>
                                        de
                                        <span class="badge badge-light">{{ $pedidos_creditos->total() > $pedidos_creditos->perPage() ? number_format($pedidos_creditos->perPage(),0,'',',') : number_format($pedidos_creditos->total(),0,'',',') }}</span>
                                        registros, mostrados
                                        <span class="badge badge-light">{{ $pedidos_creditos->total() > $pedidos_creditos->perPage() ? number_format($pedidos_creditos->perPage() * $pedidos_creditos->currentPage(),0,'',',') : number_format($pedidos_creditos->total(),0,'',',') }}</span>
                                        de un total de
                                        <span class="badge badge-light">{{ number_format($pedidos_creditos->total(),0,'',',') }}</span>
                                        registros
                                    </button>

                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead class="thead-dark">
                                                <th class="text-center">
                                                    {{ __('Pedido') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Monto') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Fecha') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Estado') }}
                                                </th>
                                            </thead>
                                            <tbody>
                                                @foreach($pedidos_creditos as $item)
                                                    <tr>
                                                        <td class="text-center">
                                                            #{{ $item->id }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ $item->getStringTotalAttribute() }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $item->getStringFechaAttribute() }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $item->status }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav aria-label="...">
                                        <ul class="pagination justify-content-end">
                                            {{ $pedidos_creditos->links() }}
                                        </ul>
                                    </nav>
                                @endif
                            </div>

                            <div class="col-sm-12 col-md-6">
                                @if (!is_null($pedidos_contado))
                                    <h3>Pedidos al contado ({{ $pedidos_contado->count() }})</h3>
                                    <button type="button" class="btn btn-default pull-right">
                                        Página
                                        <span class="badge badge-light">{{ number_format($pedidos_contado->currentPage(),0,'',',') }}</span>
                                        de
                                        <span class="badge badge-light">{{ $pedidos_contado->total() > $pedidos_contado->perPage() ? number_format($pedidos_contado->perPage(),0,'',',') : number_format($pedidos_contado->total(),0,'',',') }}</span>
                                        registros, mostrados
                                        <span class="badge badge-light">{{ $pedidos_contado->total() > $pedidos_contado->perPage() ? number_format($pedidos_contado->perPage() * $pedidos_contado->currentPage(),0,'',',') : number_format($pedidos_contado->total(),0,'',',') }}</span>
                                        de un total de
                                        <span class="badge badge-light">{{ number_format($pedidos_contado->total(),0,'',',') }}</span>
                                        registros
                                    </button>

                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead class="thead-dark">
                                                <th class="text-center">
                                                    {{ __('Pedido') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Monto') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Fecha') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Estado') }}
                                                </th>
                                            </thead>
                                            <tbody>
                                                @foreach($pedidos_contado as $item)
                                                    <tr>
                                                        <td class="text-center">
                                                            #{{ $item->id }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ $item->getStringTotalAttribute() }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $item->getStringFechaAttribute() }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $item->status }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav aria-label="...">
                                        <ul class="pagination justify-content-end">
                                            {{ $pedidos_contado->links() }}
                                        </ul>
                                    </nav>
                                @endif
                            </div>

                            <div class="col-sm-12 col-md-6">
                                @if (!is_null($pagar))
                                    <h3>Pagos por realizar ({{ $pagar->count() }})</h3>
                                    <button type="button" class="btn btn-default pull-right">
                                        Página
                                        <span class="badge badge-light">{{ number_format($pagar->currentPage(),0,'',',') }}</span>
                                        de
                                        <span class="badge badge-light">{{ $pagar->total() > $pagar->perPage() ? number_format($pagar->perPage(),0,'',',') : number_format($pagar->total(),0,'',',') }}</span>
                                        registros, mostrados
                                        <span class="badge badge-light">{{ $pagar->total() > $pagar->perPage() ? number_format($pagar->perPage() * $pagar->currentPage(),0,'',',') : number_format($pagar->total(),0,'',',') }}</span>
                                        de un total de
                                        <span class="badge badge-light">{{ number_format($pagar->total(),0,'',',') }}</span>
                                        registros
                                    </button>

                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead class="thead-dark">
                                                <th class="text-center">
                                                    {{ __('Pedido') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Cliente') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Crédito') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Monto') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Fecha') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Días restantes') }}
                                                </th>
                                            </thead>
                                            <tbody>
                                                @foreach($pagar as $item)
                                                    <tr>
                                                        <td class="text-center">
                                                            #{{ $item->order_id }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ $item->getUsuarioAttribute() }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $item->credit->getCreditConcatAttribute() }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ $item->getTotalConcatAttribute() }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $item->getDateIAttribute().' - '.$item->getDateFAttribute() }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($item->getPasoAttribute())
                                                                <button type="button" class="btn btn-block btn-danger"><strong>{{ $item->getRestaAttribute() }}</strong></button>
                                                            @else
                                                                <button type="button" class="btn btn-block btn-success"><strong>{{ $item->getRestaAttribute() }}</strong></button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav aria-label="...">
                                        <ul class="pagination justify-content-end">
                                            {{ $pagar->links() }}
                                        </ul>
                                    </nav>
                                @endif
                            </div>

                            <div class="col-sm-12 col-md-6">
                                @if (!is_null($creditos))
                                    <h3>Créditos solicitados ({{ $creditos->count() }})</h3>
                                    <button type="button" class="btn btn-default pull-right">
                                        Página
                                        <span class="badge badge-light">{{ number_format($creditos->currentPage(),0,'',',') }}</span>
                                        de
                                        <span class="badge badge-light">{{ $creditos->total() > $creditos->perPage() ? number_format($creditos->perPage(),0,'',',') : number_format($creditos->total(),0,'',',') }}</span>
                                        registros, mostrados
                                        <span class="badge badge-light">{{ $creditos->total() > $creditos->perPage() ? number_format($creditos->perPage() * $creditos->currentPage(),0,'',',') : number_format($creditos->total(),0,'',',') }}</span>
                                        de un total de
                                        <span class="badge badge-light">{{ number_format($creditos->total(),0,'',',') }}</span>
                                        registros
                                    </button>

                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead class="thead-dark">
                                                <th class="text-center">
                                                    {{ __('Cliente') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Aplicando al crédito') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Empleado respondio') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Respuesta') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('En uso') }}
                                                </th>
                                            </thead>
                                            <tbody>
                                                @foreach($creditos as $item)
                                                    <tr>
                                                        <td class="text-left">
                                                            {{ $item->getUsuarioAttribute() }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $item->getCreditConcatAttribute() }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ $item->getEmpleadoAttribute() }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ "Aprobación: $item->approved" }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $item->getUsoAttribute() }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav aria-label="...">
                                        <ul class="pagination justify-content-end">
                                            {{ $creditos->links() }}
                                        </ul>
                                    </nav>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
