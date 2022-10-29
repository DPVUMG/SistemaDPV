@extends('layouts.app')
@section('title', 'Pedidos por Escuela')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reporte.index') }}">Reportes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pedidos por Escuela</li>
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
                                href="{{ route('pdf.pedidos_escuelas', ['escuela_id'=>$escuela_id]) }}"
                                data-toggle="tooltip" target="_blank" rel="noopener noreferrer" data-placement="top"
                                title="Imprimir">PDF</a>
                            @endif
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="get" action="{{ route('reporte.pedidos_escuelas') }}" autocomplete="off"
                                    class="form-horizontal jumbotron">
                                    @csrf
                                    @method('get')
                                    <div class="input-group mb-3">
                                        <div class="form-group{{ $errors->has('escuela_id') ? ' has-danger' : '' }}">
                                            <label for="escuela_id">Escuela</label>
                                            <select data-live-search="true" data-style="btn-default"
                                                class="selectpicker form-control-plaintext form-control-lg {{ $errors->has('escuela_id') ? ' is-invalid' : '' }}"
                                                name="escuela_id" id="input-escuela_id">
                                            </select>
                                            @if ($errors->has('escuela_id'))
                                            <span id="escuela_id-error" class="error text-danger"
                                                for="input-escuela_id">{{
                                                $errors->first('escuela_id') }}</span>
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
                            <div class="col-md-6">
                                <hr>
                                @include('sistema.reporte.componente.table', [
                                'items' => $items,
                                'posicion' => 1,
                                'estado' => 'Ingresado'
                                ])
                            </div>
                            <div class="col-md-6">
                                <hr>
                                @include('sistema.reporte.componente.table', [
                                'items' => $items,
                                'posicion' => 2,
                                'estado' => 'Confirmado'
                                ])
                            </div>
                            <div class="col-md-6">
                                <hr>
                                @include('sistema.reporte.componente.table', [
                                'items' => $items,
                                'posicion' => 3,
                                'estado' => 'Entregado'
                                ])
                            </div>
                            <div class="col-md-6">
                                <hr>
                                @include('sistema.reporte.componente.table', [
                                'items' => $items,
                                'posicion' => 4,
                                'estado' => 'Pagado'
                                ])
                            </div>
                            <div class="col-md-6">
                                <hr>
                                @include('sistema.reporte.componente.table', [
                                'items' => $items,
                                'posicion' => 5,
                                'estado' => 'Anulado'
                                ])
                            </div>
                            <div class="col-md-6">
                                <hr>
                                @include('sistema.reporte.componente.table', [
                                'items' => $items,
                                'posicion' => 6,
                                'estado' => 'Cancelado'
                                ])
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
<script type="text/javascript">
    $(document).ready(function () {
        if(@json($escuela_id)) {
            cargarListEscuelas(true, false, @json($escuela_id))
        } else {
            cargarListEscuelas(true, false)
        }
    });
</script>
@endpush