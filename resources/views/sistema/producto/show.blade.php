@extends('layouts.app')
@section('title', 'Productos')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('producto.index') }}">Productos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Información del producto
                            {{ $producto->nombre }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-nav-tabs">
                    <div class="card-header card-header-{{ $producto->activo ? 'success' : 'danger' }}">
                        <h2>{{ $producto->nombre }}</h2>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            {!! $producto->descripcion !!}
                        </blockquote>
                        <div class="card-stats">
                            <div class="author">
                                <a href="#">
                                    <img src="{{ $producto->getPictureAttribute() }}" alt="{{ $producto->nombre }}"
                                        class="avatar img-raised">
                                    <span>Fecha de ingreso {{
                                        date('d/m/Y h:i:s', strtotime($producto->created_at)) }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-block btn-info">{{ $producto->marca->nombre }}</button>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <form method="post" action="{{ route('producto_foto.update', $producto) }}" autocomplete="off"
                            class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card ">
                                <div class="card-header card-header-success">
                                    <h4 class="card-title">{{ __('Nueva imagen') }}</h4>
                                    <p class="card-category">
                                        {{ __("Agregar una nueva imagen al producto
                                        {$producto->nombre}") }}
                                    </p>
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
                                                        <span class="fileinput-new">Seleccionar foto</span><span
                                                            class="fileinput-exists">Seleccionar
                                                            foto</span>
                                                        <input type="file" onchange="return fileValidation()"
                                                            name="foto" id="input-logotipo" />
                                                    </span>
                                                    <a href="#" class="btn btn-danger btn-round fileinput-exists"
                                                        data-dismiss="fileinput">
                                                        <i class="fa fa-times"></i> Limpiar</a>
                                                </div>
                                            </div>
                                            @if ($errors->has('foto'))
                                            <br>
                                            <span id="foto-error" class="error text-danger" for="input-foto">{{
                                                $errors->first('foto') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ml-auto mr-auto">
                                    <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                        href="{{ route('producto_foto.edit', $producto) }}" data-toggle="tooltip"
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
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12 ml-auto mr-auto">
                                <div class="card card-pricing bg-info">
                                    <div class="card-body ">
                                        <div class="card-icon"><i class="material-icons">account_balance_wallet</i>
                                            Precio del producto.
                                        </div>
                                        @foreach ($producto->producto_variante as $item)
                                        <h3 class="card-title">Q {{ number_format($item->precio, 2, ',', ' ') }} | {{
                                            $item->variante->nombre }} - {{ $item->presentacion->nombre }}</h3>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($items as $item)
            <div class="col-md-3">
                <div class="card-header-image" style="height: 250px;">
                    <img class="img" src="{{ $item->getPictureAttribute() }}" width="100%" height="100%" rel="nofollow">
                </div>
                <form method="post" action="{{ route('producto_foto.destroy', $item) }}">
                    @csrf
                    @method('delete')
                    <a rel="tooltip" class="btn btn-info btn-sm btn-round"
                        href="{{ route('producto_foto.show', $item) }}" data-toggle="tooltip" data-placement="top"
                        title="Actualizar fotografía principal">
                        <i class="material-icons">check</i>
                        <div class="ripple-container"></div>
                    </a>

                    <button rel="tooltip" data-toggle="tooltip" data-placement="top" title="Eliminar fotografía"
                        type="submit" class="btn btn-danger btn-sm btn-round">
                        <i class="material-icons">close</i>
                        <div class="ripple-container"></div>
                    </button>
                </form>
            </div>
            @endforeach
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-category card-category-social">
                            <nav aria-label="...">
                                <ul class="pagination justify-content-end">
                                    {{ $items->links() }}
                                </ul>
                            </nav>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection