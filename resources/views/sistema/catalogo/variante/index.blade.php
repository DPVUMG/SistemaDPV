@extends('layouts.app')
@section('title', 'Variantes')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Variantes</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('variante.store') }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('post')
                    <div class="card ">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">{{ __('Nueva variante') }}</h4>
                            <p class="card-category">{{ __('Registrar una nueva variante en el sistema') }}</p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                            name="nombre" id="input-nombre" type="text"
                                            placeholder="{{ __('variante') }}" value="{{ old('nombre') }}"
                                            aria-required="true" />
                                        @if ($errors->has('nombre'))
                                        <span id="nombre-error" class="error text-danger" for="input-nombre">{{
                                            $errors->first('nombre') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger" href="{{ route('variante.index') }}"
                                data-toggle="tooltip" data-placement="top" title="Cancelar">
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
                        <h4 class="card-title ">{{ __('Variantes') }}</h4>
                        <p class="card-category"> {{ __('En esta pantalla el sistema muestra todas las Variantes
                            registradas.') }}</p>
                    </div>
                    <div class="card-body">
                        <form method="get" action="{{ route('variante.index') }}" autocomplete="off"
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
                                        {{ __('Nombre') }}
                                    </th>
                                    <th class="text-center">
                                        {{ __('Opciones') }}
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td class="text-left">
                                            {{ $item->nombre }}
                                        </td>
                                        <td class="text-center">
                                            <form id="formDelete{{ $item->id }}" method="post"
                                                action="{{ route('variante.destroy', $item) }}">
                                                @csrf
                                                @method('delete')
                                                <a rel="tooltip" class="btn btn-warning btn-sm btn-round"
                                                    href="{{ route('variante.edit', $item) }}" data-toggle="tooltip"
                                                    data-placement="top" title="Editar información">
                                                    <i class="material-icons">edit</i>
                                                    <div class="ripple-container"></div>
                                                </a>
                                                <button id="btnDelete-{{ $item->id }}" rel="tooltip"
                                                    data-toggle="tooltip" data-placement="top" title="{{ __(" Eliminar
                                                    {$item->nombre}")
                                                    }}"
                                                    class="btn btn-danger btn-sm btn-round btnDelete">
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