@extends('layouts.app')
@section('title', 'Categorías')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Categorías</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('categoria.store') }}" autocomplete="off" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="card ">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">{{ __('Nueva categoría') }}</h4>
                            <p class="card-category">{{ __('Registrar una nueva categoría en el sistema') }}</p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 text-center">
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail img-raised"
                                            style="height: 230px; border: solid;">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail img-raised">
                                            <div id="imagePreview"></div>
                                        </div>
                                        <div>
                                            <span class="btn btn-raised btn-round btn-rose btn-file">
                                                <span class="fileinput-new">Seleccionar icono</span><span
                                                    class="fileinput-exists">Seleccionar icono</span>
                                                <input type="file" onchange="return fileValidation()" name="icono"
                                                    id="input-logotipo" />
                                            </span>
                                            <a href="#" class="btn btn-danger btn-round fileinput-exists"
                                                data-dismiss="fileinput">
                                                <i class="fa fa-times"></i> Limpiar</a>
                                        </div>
                                    </div>
                                    @if ($errors->has('icono'))
                                    <br>
                                    <span id="icono-error" class="error text-danger" for="input-icono">{{
                                        $errors->first('icono') }}</span>
                                    @endif
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                            name="nombre" id="input-nombre" type="text"
                                            placeholder="{{ __('categoría') }}" value="{{ old('nombre') }}"
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
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                href="{{ route('categoria.index') }}" data-toggle="tooltip" data-placement="top"
                                title="Cancelar">
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
                        <h4 class="card-title ">{{ __('Categorías') }}</h4>
                        <p class="card-category"> {{ __('En esta pantalla el sistema muestra todas las Categorías
                            registradas.') }}</p>
                    </div>
                    <div class="card-body">
                        <form method="get" action="{{ route('categoria.index') }}" autocomplete="off"
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
                            <table class="table table-striped">
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
                                        <td class="text-center">
                                            <div class="card card-pricing bg-info">
                                                <div class="card-body ">
                                                    <div class="card-icon">
                                                        <img src="{{ $item->getIconoCatAttribute() }}" height="230px"
                                                            class="rounded" alt="{{ $item->nombre }}">
                                                    </div>
                                                    <h3 class="card-title">{{ $item->nombre }}</h3>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <form method="post" action="{{ route('categoria.destroy', $item) }}">
                                                @csrf
                                                @method('delete')
                                                <a rel="tooltip" class="btn btn-warning btn-sm btn-round"
                                                    href="{{ route('categoria.edit', $item) }}" data-toggle="tooltip"
                                                    data-placement="top" title="Editar información">
                                                    <i class="material-icons">edit</i>
                                                    <div class="ripple-container"></div>
                                                </a>
                                                <button rel="tooltip" data-toggle="tooltip" data-placement="top"
                                                    title="{{ __(" Eliminar {$item->nombre}") }}" type="submit"
                                                    class="btn btn-danger btn-sm btn-round">
                                                    <i class="material-icons">close</i>
                                                    <div class="ripple-container"></div>
                                                </button>
                                                <a rel="tooltip" class="btn btn-info btn-sm btn-round"
                                                    href="{{ route('categoria.show', $item) }}" data-toggle="tooltip"
                                                    data-placement="top" title="Ver sub categorías">
                                                    <i class="material-icons">dynamic_feed</i>
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