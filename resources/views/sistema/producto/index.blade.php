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
                        <li class="breadcrumb-item active" aria-current="page">Productos</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="accordion" role="tablist">
                    <div class="card card-collapse">
                        <div class="card-header" role="tab" id="headingOne">
                            <h5 class="mb-0 alert alert-info">
                                <a data-toggle="collapse" href="#collapseOne" aria-expanded="false"
                                    aria-controls="collapseOne" style="color: black; font-weight: bold;">
                                    Formulario para agregar un nuevo producto
                                    <i class="material-icons">keyboard_arrow_down</i>
                                </a>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne"
                            data-parent="#accordion">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="post" action="{{ route('producto.store') }}" autocomplete="off"
                                        class="form-horizontal" enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        <div class="card">
                                            <div class="card-header card-header-success">
                                                <h4 class="card-title">{{ __('Nuevo producto') }}</h4>
                                                <p class="card-category">{{ __('Registrar una nuevo producto en el
                                                    sistema')
                                                    }}</p>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-7">
                                                        <div
                                                            class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                                                            <label for="nombre">Nombre</label>
                                                            <input
                                                                class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                                                name="nombre" id="input-nombre" type="text"
                                                                placeholder="{{ __('producto') }}"
                                                                value="{{ old('nombre') }}" aria-required="true" />
                                                            @if ($errors->has('nombre'))
                                                            <span id="nombre-error" class="error text-danger"
                                                                for="input-nombre">{{
                                                                $errors->first('nombre') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-5">
                                                        <div
                                                            class="form-group{{ $errors->has('marca_id') ? ' has-danger' : '' }}">
                                                            <label for="marca_id">Marca</label>
                                                            <select data-live-search="true" data-style="btn-default"
                                                                class="selectpicker form-control{{ $errors->has('marca_id') ? ' is-invalid' : '' }}"
                                                                name="marca_id" id="input-marca_id">
                                                                <option value="">Seleccionar una marca</option>
                                                                @foreach ($marcas as $item)
                                                                <option value="{{ $item->id }}" {{ ($item->id ==
                                                                    old('marca_id')) ?
                                                                    'selected' : '' }}>{{ $item->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('marca_id'))
                                                            <span id="marca_id-error" class="error text-danger"
                                                                for="input-marca_id">{{
                                                                $errors->first('marca_id') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <div
                                                            class="form-group{{ $errors->has('producto_subcategoria') ? ' has-danger' : '' }}">
                                                            <label for="producto_subcategoria">Categorías</label>
                                                            <select multiple data-live-search="true"
                                                                data-style="btn-primary"
                                                                class="selectpicker form-control{{ $errors->has('producto_subcategoria') ? ' is-invalid' : '' }}"
                                                                name="producto_subcategoria[]"
                                                                id="input-producto_subcategoria">
                                                                <option value="">Seleccionar una presentacion</option>
                                                                @foreach ($subcategorias as $item)
                                                                <option value="{{ $item->id }}" {{ ($item->id ==
                                                                    old('producto_subcategoria')) ?
                                                                    'selected' : '' }}>{{ "{$item->categoria->nombre} -
                                                                    {$item->nombre}" }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('producto_subcategoria'))
                                                            <span id="producto_subcategoria-error"
                                                                class="error text-danger"
                                                                for="input-producto_subcategoria">{{
                                                                $errors->first('producto_subcategoria')
                                                                }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12">
                                                        <div
                                                            class="form-group{{ $errors->has('descripcion') ? ' has-danger' : '' }}">
                                                            <textarea
                                                                class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}"
                                                                name="descripcion" id="input-descripcion"
                                                                placeholder="{{ __('descripción') }}"
                                                                aria-required="true" />{{
                                                            old('descripcion') }}</textarea>
                                                            @if ($errors->has('descripcion'))
                                                            <span id="descripcion-error" class="error text-danger"
                                                                for="input-descripcion">{{
                                                                $errors->first('descripcion') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-5">
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
                                                                    'selected' : '' }}>{{ "{$item->variante->nombre} -
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
                                                    <div class="col-sm-12 col-md-4">
                                                        <br>
                                                        <div class="checkbox-radios">
                                                            <div
                                                                class="form-check {{ $errors->has('temporal') ? ' has-danger' : '' }}">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="temporal" id="input-temporal"
                                                                        value="{{ old('temporal') }}"> Producto temporal
                                                                    <span class="form-check-sign">
                                                                        <span class="check"></span>
                                                                    </span>
                                                                </label>
                                                                @if ($errors->has('temporal'))
                                                                <span id="temporal-error" class="error text-danger"
                                                                    for="input-temporal">{{
                                                                    $errors->first('temporal') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 text-center">
                                                        <hr>
                                                        <div class="fileinput fileinput-new text-center"
                                                            data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail img-raised"
                                                                style="height: 230px; border: solid;">
                                                            </div>
                                                            <div
                                                                class="fileinput-preview fileinput-exists thumbnail img-raised">
                                                                <div id="imagePreview"></div>
                                                            </div>
                                                            <div>
                                                                <span
                                                                    class="btn btn-raised btn-round btn-rose btn-file">
                                                                    <span class="fileinput-new">Seleccionar
                                                                        foto</span><span
                                                                        class="fileinput-exists">Seleccionar
                                                                        foto</span>
                                                                    <input type="file"
                                                                        onchange="return fileValidation()" name="foto"
                                                                        id="input-logotipo" />
                                                                </span>
                                                                <a href="#"
                                                                    class="btn btn-danger btn-round fileinput-exists"
                                                                    data-dismiss="fileinput">
                                                                    <i class="fa fa-times"></i> Limpiar</a>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('foto'))
                                                        <br>
                                                        <span id="foto-error" class="error text-danger"
                                                            for="input-foto">{{
                                                            $errors->first('foto') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer ml-auto mr-auto">
                                                <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                                    href="{{ route('producto.index') }}" data-toggle="tooltip"
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
                            </div>
                        </div>
                    </div>
                </div>
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
                        <form method="get" action="{{ route('producto.index') }}" autocomplete="off"
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
                                        {{ __('Información') }}
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td class="text-center">
                                            <div class="card card-profile ml-auto mr-auto" style="max-width: 360px">
                                                <div class="card-header card-header-image">
                                                    <a href="#">
                                                        <img class="img" src="{{ $item->getPictureAttribute() }}">
                                                    </a>
                                                </div>

                                                <div class="card-body ">
                                                    <h4 class="card-title">{{ $item->nombre }}</h4>
                                                    <h6 class="card-category text-gray">{{ $item->codigo }}</h6>
                                                    <h5 class="card-category text-gray">{{ $item->marca->nombre }}</h5>
                                                    <h5 class="card-category text-gray">Temporal: {{ $item->temporada ?
                                                        'SI' : 'NO' }}</h5>
                                                    {!! $item->descripcion !!}
                                                </div>
                                                <div class="card-footer justify-content-center">
                                                    <a rel="tooltip"
                                                        class="{{ $item->activo ? 'btn btn-just-icon btn-danger btn-round' : 'btn btn-just-icon btn-success btn-round' }}"
                                                        href="{{ route('producto.show', $item) }}" data-toggle="tooltip"
                                                        data-placement="top" title="{{ $item->activo ? " Desactivar
                                                        código {$item->codigo}" : " Activar
                                                        código {$item->codigo}" }}">
                                                        <i class="{{ $item->activo ? 'fa fa-thumbs-o-down' : 'fa fa-thumbs-o-up'}}"
                                                            aria-hidden="true"></i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                    <a rel="tooltip" class="btn btn-just-icon btn-warning btn-round"
                                                        href="{{ route('producto.edit', $item) }}" data-toggle="tooltip"
                                                        data-placement="top" title="Editar información">
                                                        <i class="material-icons">edit</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                    <a rel="tooltip" class="btn btn-just-icon btn-primary btn-round"
                                                        href="{{ route('producto_foto.edit', $item) }}"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Ver información del producto">
                                                        <i class="material-icons">perm_media</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </div>
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