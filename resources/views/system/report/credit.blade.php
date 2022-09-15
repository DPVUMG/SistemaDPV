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
                        <li class="breadcrumb-item active" aria-current="page">Reporte de créditos por cobrar</li>
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
                                <a rel="tooltip" class="btn btn-success btn-sm btn-round" href="{{ route('pdf.credit', ['date_start'=>$date_start, 'date_end'=>$date_end]) }}" data-toggle="tooltip" data-placement="top" title="Imprimir">PDF</a>
                            @endif
                        </p>
                    </div>
                    <div class="card-body">
                        <form method="get" action="{{ route('report.credit') }}" autocomplete="off" class="form-horizontal">
                            @csrf
                            @method('get')
                            <div class="input-group mb-3">
                                <div class="form-group{{ $errors->has('date_start') ? ' has-danger' : '' }}">
                                    <label for="date_start">Primer fecha</label>
                                    <input class="form-control{{ $errors->has('date_start') ? ' is-invalid' : '' }}" name="date_start" id="input-date_start" type="date" placeholder="{{ __('primer fecha') }}" value="{{ old('date_start',$date_start) }}" aria-required="true"/>
                                </div>
                                <div class="form-group{{ $errors->has('date_end') ? ' has-danger' : '' }}">
                                    <label for="date_end">Segunda fecha</label>
                                    <input class="form-control{{ $errors->has('date_end') ? ' is-invalid' : '' }}" name="date_end" id="input-date_end" type="date" placeholder="{{ __('segunda fecha') }}" value="{{ old('date_end',$date_end) }}" aria-required="true"/>
                                </div>
                                <div class="input-group-append">
                                    <button rel="tooltip" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Buscar información" type="submit">Buscar</button>
                                </div>
                            </div>
                            @if ($errors->has('date_start'))
                                <span id="date_start-error" class="error text-danger" for="input-date_start">{{ $errors->first('date_start') }}</span>
                            @endif
                            @if ($errors->has('date_end'))
                                <span id="date_end-error" class="error text-danger" for="input-date_end">{{ $errors->first('date_end') }}</span>
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
                                        @foreach($items as $item)
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
