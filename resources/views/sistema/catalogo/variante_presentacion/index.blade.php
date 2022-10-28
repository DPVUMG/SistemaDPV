@extends('layouts.app')
@section('title', 'Variantes y Presentaciones')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Variantes y Presentaciones</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('variante_presentacion.store') }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('post')
                    <div class="card ">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">{{ __('Nueva variante y presentación') }}</h4>
                            <p class="card-category">{{ __('Registrar una nueva variante y presentación en el sistema')
                                }}</p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group{{ $errors->has('variante_id') ? ' has-danger' : '' }}">
                                        <label for="variante_id">Variante</label>
                                        <select data-live-search="true" data-style="btn-default"
                                            class="selectpicker form-control{{ $errors->has('variante_id') ? ' is-invalid' : '' }}"
                                            name="variante_id" id="input-variante_id">
                                            <option value="">Seleccionar una variante</option>
                                            @foreach ($variantes as $item)
                                            <option value="{{ $item->id }}" {{ ($item->id == old('variante_id')) ?
                                                'selected' : '' }}>{{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('variante_id'))
                                        <span id="variante_id-error" class="error text-danger"
                                            for="input-variante_id">{{ $errors->first('variante_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group{{ $errors->has('presentacion_id') ? ' has-danger' : '' }}">
                                        <label for="presentacion_id">Presentación</label>
                                        <select data-live-search="true" data-style="btn-default"
                                            class="selectpicker form-control{{ $errors->has('presentacion_id') ? ' is-invalid' : '' }}"
                                            name="presentacion_id" id="input-presentacion_id">
                                            <option value="">Seleccionar una presentacion</option>
                                            @foreach ($presentaciones as $item)
                                            <option value="{{ $item->id }}" {{ ($item->id == old('presentacion_id')) ?
                                                'selected' : '' }}>{{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('presentacion_id'))
                                        <span id="presentacion_id-error" class="error text-danger"
                                            for="input-presentacion_id">{{ $errors->first('presentacion_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                href="{{ route('variante_presentacion.index') }}" data-toggle="tooltip"
                                data-placement="top" title="Cancelar">
                                <i class="material-icons">block</i> Cancelar
                                <div class="ripple-container"></div>
                            </a>
                            <button rel="tooltip" type="submit" class="btn btn-flat btn-md btn-success"
                                data-toggle="tooltip" data-placement="top" title="Guardar información">
                                <i class="material-icons">add_box</i> Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">{{ __('Variantes y Presentaciones') }}</h4>
                        <p class="card-category"> {{ __('En esta pantalla el sistema muestra todas las Variantes y
                            Presentaciones
                            registradas.') }}</p>
                    </div>
                    <div class="card-body">
                        <form method="get" action="{{ route('variante_presentacion.index') }}" autocomplete="off"
                            class="form-horizontal">
                            @csrf
                            @method('get')
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search">
                                <div class="input-group-append">
                                    <button rel="tooltip" class="btn btn-sm btn-success" data-toggle="tooltip"
                                        data-placement="top" title="Buscar información" type="submit">Buscar</button>
                                </div>
                            </div>
                        </form>
                        <button type="button" class="btn btn-default pull-right">
                            Página
                            <span class="badge badge-light">{{ number_format($items->currentPage(),0,'',',') }}</span>
                            de
                            <span class="badge badge-light">{{ $items->total() > $items->perPage() ?
                                number_format($items->perPage(),0,'',',') : number_format($items->total(),0,'',',')
                                }}</span>
                            registros, mostrados
                            <span class="badge badge-light">{{ $items->total() > $items->perPage() ?
                                number_format($items->perPage() * $items->currentPage(),0,'',',') :
                                number_format($items->total(),0,'',',') }}</span>
                            de un total de
                            <span class="badge badge-light">{{ number_format($items->total(),0,'',',') }}</span>
                            registros
                        </button>
                        <div class="table-responsive">
                            <table class="dataTable display" style="width:100%">
                                <thead class="thead-dark">
                                    <th class="text-center">
                                        {{ __('Variante') }}
                                    </th>
                                    <th class="text-center">
                                        {{ __('Presentación') }}
                                    </th>
                                    <th class="text-center">
                                        {{ __('Opciones') }}
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td class="text-left">
                                            {{ $item->variante->nombre }}
                                        </td>
                                        <td class="text-left">
                                            {{ $item->presentacion->nombre }}
                                        </td>
                                        <td class="text-center">
                                            <form method="post"
                                                action="{{ route('variante_presentacion.destroy', $item) }}">
                                                @csrf
                                                @method('delete')
                                                <button rel="tooltip" data-toggle="tooltip" data-placement="top"
                                                    title="{{ __(" Eliminar {$item->variante->nombre} -
                                                    {$item->presentacion->nombre}") }}" type="submit"
                                                    class="btn btn-danger btn-sm btn-round">
                                                    <i class="material-icons">close</i>
                                                    <div class="ripple-container"></div>
                                                </button>
                                            </form>
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