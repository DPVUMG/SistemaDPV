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
                        <li class="breadcrumb-item active" aria-current="page">Reporte de pedidos</li>
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
                            @if (!is_null($items))
                                <a rel="tooltip" class="btn btn-success btn-sm btn-round" href="{{ route('pdf.traicing', ['month'=>$month]) }}" data-toggle="tooltip" data-placement="top" title="Imprimir">PDF</a>
                            @endif
                        </p>
                    </div>
                    <div class="card-body">
                        <form method="get" action="{{ route('report.traicing') }}" autocomplete="off" class="form-horizontal">
                            @csrf
                            @method('get')
                            <div class="input-group {{ $errors->has('month') ? ' has-danger' : '' }} mb-3">
                                <select data-live-search="true" style="color: white;" class="selectpicker form-control{{ $errors->has('month') ? ' is-invalid' : '' }}" name="month" id="input-month">
                                    <option value="">Seleccionar un mes</option>
                                    <option value="1" {{ (1 == old('month', $month)) ? 'selected' : '' }}>Enero</option>
                                    <option value="2" {{ (2 == old('month', $month)) ? 'selected' : '' }}>Febrero</option>
                                    <option value="3" {{ (3 == old('month', $month)) ? 'selected' : '' }}>Marzo</option>
                                    <option value="4" {{ (4 == old('month', $month)) ? 'selected' : '' }}>Abril</option>
                                    <option value="5" {{ (5 == old('month', $month)) ? 'selected' : '' }}>Mayo</option>
                                    <option value="6" {{ (6 == old('month', $month)) ? 'selected' : '' }}>Junio</option>
                                    <option value="7" {{ (7 == old('month', $month)) ? 'selected' : '' }}>Julio</option>
                                    <option value="8" {{ (8 == old('month', $month)) ? 'selected' : '' }}>Agosto</option>
                                    <option value="9" {{ (9 == old('month', $month)) ? 'selected' : '' }}>Septiembre</option>
                                    <option value="10" {{ (10 == old('month', $month)) ? 'selected' : '' }}>Octubre</option>
                                    <option value="11" {{ (11 == old('month', $month)) ? 'selected' : '' }}>Noviembre</option>
                                    <option value="12" {{ (12 == old('month', $month)) ? 'selected' : '' }}>Diciembre</option>
                                </select>
                                <div class="input-group-append">
                                    <button rel="tooltip" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Buscar información" type="submit">Buscar</button>
                                </div>
                            </div>
                            @if ($errors->has('month'))
                                <span id="month-error" class="error text-danger" for="input-month">{{ $errors->first('month') }}</span>
                            @endif
                        </form>
                        @if (!is_null($items))
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
                                            {{ __('Estado') }}
                                        </th>
                                        <th class="text-center">
                                            {{ __('Recorrido') }}
                                        </th>
                                    </thead>
                                    <tbody>
                                        @foreach($items as $item)
                                            <tr>
                                                <td class="text-center">
                                                    #{{ $item->id }}
                                                </td>
                                                <td class="text-left">
                                                    {{ $item->getUserAttribute() }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->status }}
                                                </td>
                                                <td>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <thead class="thead-dark">
                                                                <th class="text-center">
                                                                    {{ __('Empleado') }}
                                                                </th>
                                                                <th class="text-center">
                                                                    {{ __('Estado') }}
                                                                </th>
                                                                <th class="text-center">
                                                                    {{ __('Fecha') }}
                                                                </th>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($item->traicings as $j)
                                                                    <tr>
                                                                        <td class="text-left">
                                                                            {{ $j->getUserAttribute() }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $j->status }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $j->getDateAttribute() }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
