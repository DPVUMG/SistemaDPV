@extends('layouts.app')
@section('title', 'Reporte de pagos realizados')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reporte.index') }}">Reportes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reporte de pagos realizados</li>
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
                            <a rel="tooltip" class="btn btn-success btn-sm btn-round"
                                href="{{ route('pdf.pagos_realizados', ['date_start'=>$date_start, 'date_end'=>$date_end]) }}"
                                data-toggle="tooltip" target="_blank" rel="noopener noreferrer" data-placement="top"
                                title="Imprimir">PDF</a>
                            @endif
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="get" action="{{ route('reporte.pagos_realizados') }}" autocomplete="off"
                                    class="form-horizontal jumbotron">
                                    @csrf
                                    @method('get')
                                    <div class="input-group mb-3">
                                        <div class="form-group{{ $errors->has('date_start') ? ' has-danger' : '' }}">
                                            <label for="date_start">Primer fecha</label>
                                            <input
                                                class="form-control{{ $errors->has('date_start') ? ' is-invalid' : '' }} datepicker"
                                                name="date_start" id="input-date_start"
                                                placeholder="{{ __('primer fecha') }}"
                                                value="{{ old('date_start',$date_start) }}" aria-required="true" />
                                            @if ($errors->has('date_start'))
                                            <span id="date_start-error" class="error text-danger"
                                                for="input-date_start">{{
                                                $errors->first('date_start') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('date_end') ? ' has-danger' : '' }}">
                                            <label for="date_end">Segunda fecha</label>
                                            <input
                                                class="form-control{{ $errors->has('date_end') ? ' is-invalid' : '' }} datepicker"
                                                name="date_end" id="input-date_end"
                                                placeholder="{{ __('segunda fecha') }}"
                                                value="{{ old('date_end',$date_end) }}" aria-required="true" />
                                            @if ($errors->has('date_end'))
                                            <span id="date_end-error" class="error text-danger" for="input-date_end">{{
                                                $errors->first('date_end') }}</span>
                                            @endif
                                        </div>
                                        <div class="input-group-append">
                                            <button rel="tooltip" class="btn btn-sm btn-success" data-toggle="tooltip"
                                                data-placement="top" title="Buscar información"
                                                type="submit">Buscar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12">
                                <hr>
                                @if (!is_null($items))
                                <div class="table-responsive">
                                    <table class="dataTable display" style="width:100%">
                                        <thead class="thead-dark">
                                            <th class="text-center">
                                                {{ __('Pedido #') }}
                                            </th>
                                            <th class="text-center">
                                                {{ __('Cheque #') }}
                                            </th>
                                            <th class="text-center">
                                                {{ __('Banco') }}
                                            </th>
                                            <th class="text-center">
                                                {{ __('Escuela') }}
                                            </th>
                                            <th class="text-center">
                                                {{ __('Monto Total Q') }}
                                            </th>
                                            <th class="text-center">
                                                {{ __('Fecha') }}
                                            </th>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $item)
                                            <tr>
                                                <td class="text-center">
                                                    #{{ $item->escuela_pedido_id }}
                                                </td>
                                                <td class="text-center">
                                                    #{{ $item->numero_cheque }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->banco->nombre }}
                                                </td>
                                                <td class="text-left">
                                                    {{ $item->escuela->establecimiento }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($item->monto, 2, '.', ',') }}
                                                </td>
                                                <td class="text-center">
                                                    {{ date('d/m/Y', strtotime($item->created_at)) }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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