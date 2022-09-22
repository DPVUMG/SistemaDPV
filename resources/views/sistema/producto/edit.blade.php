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
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('producto.update', $producto) }}" autocomplete="off"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card ">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">{{ __('Editar producto') }}</h4>
                            <p class="card-category">{{ __('Modificar el producto con nombre ') }} <strong>{{
                                    $producto->nombre }}</strong></p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-7">
                                    <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                            name="nombre" id="input-nombre" type="text"
                                            placeholder="{{ __('producto') }}"
                                            value="{{ old('nombre', $producto->nombre) }}" aria-required="true" />
                                        @if ($errors->has('nombre'))
                                        <span id="nombre-error" class="error text-danger" for="input-nombre">{{
                                            $errors->first('nombre') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-5">
                                    <div class="form-group{{ $errors->has('marca_id') ? ' has-danger' : '' }}">
                                        <label for="marca_id">Marca</label>
                                        <select data-live-search="true" data-style="btn-default"
                                            class="selectpicker form-control{{ $errors->has('marca_id') ? ' is-invalid' : '' }}"
                                            name="marca_id" id="input-marca_id">
                                            <option value="">Seleccionar una marca</option>
                                            @foreach ($marcas as $item)
                                            <option value="{{ $item->id }}" {{ ($item->id == old('marca_id',
                                                $producto->marca_id)) ?
                                                'selected' : '' }}>{{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('marca_id'))
                                        <span id="marca_id-error" class="error text-danger" for="input-marca_id">{{
                                            $errors->first('marca_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    {{ $producto->producto_subcategoria->get('id') }}
                                    <div class="form-group{{ $errors->has('producto_subcategoria') ? ' has-danger' : ''
                                        }}">
                                        <label for="producto_subcategoria">Categorías</label>
                                        <select multiple data-live-search="true" data-style="btn-primary"
                                            class="selectpicker form-control{{ $errors->has('producto_subcategoria') ? ' is-invalid' : '' }}"
                                            name="producto_subcategoria[]" id="input-producto_subcategoria">
                                            <option value="">Seleccionar una presentacion</option>
                                            @foreach ($subcategorias as $item)}
                                            <option value="{{ $item->id }}" {{ in_array($item->id,
                                                $producto->producto_subcategoria->pluck('sub_categoria_id')->toArray())
                                                ?
                                                'selected' : '' }}>{{ "{$item->categoria->nombre} - {$item->nombre}" }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('producto_subcategoria'))
                                        <span id="producto_subcategoria-error" class="error text-danger"
                                            for="input-producto_subcategoria">{{
                                            $errors->first('producto_subcategoria')
                                            }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('descripcion') ? ' has-danger' : '' }}">
                                        <textarea
                                            class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}"
                                            name="descripcion" id="input-descripcion"
                                            placeholder="{{ __('descripción') }}" aria-required="true" />{{
                                        old('descripcion', $producto->descripcion)
                                        }}</textarea>
                                        @if ($errors->has('descripcion'))
                                        <span id="descripcion-error" class="error text-danger"
                                            for="input-descripcion">{{
                                            $errors->first('descripcion') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                    href="{{ route('producto.index') }}" data-toggle="tooltip" data-placement="top"
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-4 text-center">
                            <hr>
                            <div class="thumbnail img-raised"><img src="{{ $producto->getPictureAttribute() }}"
                                    class="img" alt="{{ $producto->nombre }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-8">
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="post" action="{{ route('producto_variante.update', $producto->id) }}"
                                        autocomplete="off" class="form-horizontal">
                                        @csrf
                                        @method('PUT')
                                        <div class="card ">
                                            <div class="card-header card-header-info">
                                                <h4 class="card-title">{{ __('Nuevo precio') }}</h4>
                                                <p class="card-category">{{ __("Registrar precio para el
                                                    producto
                                                    {$producto->nombre}") }}</p>
                                            </div>
                                            <div class="card-body ">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-9">
                                                        <div
                                                            class="form-group{{ $errors->has('variante_presentacion_id') ? ' has-danger' : '' }}">
                                                            <label for="variante_presentacion_id">Varaciones y
                                                                Presentaciones</label>
                                                            <select data-live-search="true" data-style="btn-default"
                                                                class="selectpicker form-control{{ $errors->has('variante_presentacion_id') ? ' is-invalid' : '' }}"
                                                                name="variante_presentacion_id"
                                                                id="input-variante_presentacion_id">
                                                                <option value="">Seleccionar una variación y
                                                                    presentación</option>
                                                                @foreach ($variantes_presentaciones as $item)
                                                                <option value="{{ $item->id }}" {{ ($item->id ==
                                                                    old('variante_presentacion_id')) ?
                                                                    'selected' : '' }}>{{
                                                                    "{$item->variante->nombre} -
                                                                    {$item->presentacion->nombre}" }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('variante_presentacion_id'))
                                                            <span id="variante_presentacion_id-error"
                                                                class="error text-danger"
                                                                for="input-variante_presentacion_id">{{
                                                                $errors->first('variante_presentacion_id')
                                                                }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <div
                                                            class="form-group{{ $errors->has('precio') ? ' has-danger' : '' }}">
                                                            <label for="precio">Precio</label>
                                                            <input
                                                                class="form-control{{ $errors->has('precio') ? ' is-invalid' : '' }}"
                                                                name="precio" id="input-precio" type="text" min="0"
                                                                placeholder="{{ __('precio Q.') }}"
                                                                value="{{ old('precio','0.00') }}"
                                                                aria-required="true" />
                                                            @if ($errors->has('precio'))
                                                            <span id="precio-error" class="error text-danger"
                                                                for="input-precio">{{
                                                                $errors->first('precio') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer ml-auto mr-auto">
                                                <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                                    href="{{ route('producto.edit', $producto) }}" data-toggle="tooltip"
                                                    data-placement="top" title="Cancelar">
                                                    <i class="material-icons">block</i> Cancelar
                                                    <div class="ripple-container"></div>
                                                </a>
                                                <button rel="tooltip" type="submit"
                                                    class="btn btn-flat btn-md btn-success" data-toggle="tooltip"
                                                    data-placement="top" title="Guardar información">
                                                    <i class="material-icons">add_box</i> Guardar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead class="thead-dark">
                                                <th class="text-center">
                                                    {{ __('Variante') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Presentación') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Precio') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('Opciones') }}
                                                </th>
                                            </thead>
                                            <tbody>
                                                @foreach($producto->producto_variante as $item)
                                                <tr>
                                                    <td class="text-left">
                                                        {{ $item->variante->nombre }}
                                                    </td>
                                                    <td class="text-left">
                                                        {{ $item->presentacion->nombre }}
                                                    </td>
                                                    <td class="text-right">
                                                        Q {{ number_format($item->precio, 2, ',', ' ') }}
                                                    </td>
                                                    <td class="text-center">
                                                        <form method="post"
                                                            action="{{ route('producto_variante.destroy', $item) }}">
                                                            @csrf
                                                            @method('delete')
                                                            <a rel="tooltip"
                                                                class="{{ $item->activo ? 'btn btn-just-icon btn-danger btn-round' : 'btn btn-just-icon btn-success btn-round' }}"
                                                                href="{{ route('producto_variante.show', $item) }}"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="{{ $item->activo ? " Desactivar código
                                                                {$item->codigo}" : " Activar
                                                                código {$item->codigo}" }}">
                                                                <i class="{{ $item->activo ? 'fa fa-thumbs-o-down' : 'fa fa-thumbs-o-up'}}"
                                                                    aria-hidden="true"></i>
                                                                <div class="ripple-container"></div>
                                                            </a>
                                                            <button rel="tooltip" data-toggle="tooltip"
                                                                data-placement="top" title="{{ __(" Eliminar
                                                                {$item->variante->nombre} -
                                                                {$item->presentacion->nombre}") }}"
                                                                type="submit"
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace( 'input-descripcion' );
</script>
@endsection