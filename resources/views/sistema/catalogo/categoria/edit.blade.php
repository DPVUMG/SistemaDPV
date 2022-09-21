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
                        <li class="breadcrumb-item"><a href="{{ route('categoria.index') }}">Categorías</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('categoria.update', $categorium) }}" autocomplete="off"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card ">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">{{ __('Editar categoría') }}</h4>
                            <p class="card-category">{{ __('Modificar la categoría con nombre ') }} <strong>{{
                                    $categorium->nombre }}</strong></p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 text-center">
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail img-circle img-raised">
                                            <img src="{{ $categorium->getIconoCatAttribute() }}" class="img"
                                                alt="{{ $categorium->nombre }}">
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
                                                placeholder="{{ __('categoría') }}"
                                                value="{{ old('nombre',$categorium->nombre) }}" aria-required="true" />
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
    </div>
</div>
@endsection