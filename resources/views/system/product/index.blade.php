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
                <form method="post" action="{{ route('product.store') }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('post')
                    <div class="card ">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">{{ __('Nueva producto') }}</h4>
                            <p class="card-product">{{ __('Registrar una nueva producto en el sistema') }}</p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12 col-md-8">
                                    <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                                    <select data-live-search="true" data-style="btn-default" class="selectpicker form-control{{ $errors->has('sub_category_id') ? ' is-invalid' : '' }}" name="sub_category_id" id="input-sub_category_id">
                                        <option value="">Seleccionar una categoría</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}"
                                            {{ ($item->id == old('sub_category_id')) ? 'selected' : '' }}>{{ $item->getCategoryAttribute() }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('sub_category_id'))
                                        <span id="sub_category_id-error" class="error text-danger" for="input-sub_category_id">{{ $errors->first('sub_category_id') }}</span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group{{ $errors->has('brand_id') ? ' has-danger' : '' }}">
                                    <select data-live-search="true" data-style="btn-default" class="selectpicker form-control{{ $errors->has('brand_id') ? ' is-invalid' : '' }}" name="brand_id" id="input-brand_id">
                                        <option value="">Seleccionar una marca</option>
                                        @foreach ($brands as $item)
                                            <option value="{{ $item->id }}"
                                            {{ ($item->id == old('brand_id')) ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('brand_id'))
                                        <span id="brand_id-error" class="error text-danger" for="input-brand_id">{{ $errors->first('brand_id') }}</span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12"><br></div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                    <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="input-title" type="text" placeholder="{{ __('nombre del producto') }}" value="{{ old('title') }}" aria-required="true"/>
                                    @if ($errors->has('title'))
                                        <span id="title-error" class="error text-danger" for="input-title">{{ $errors->first('title') }}</span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                    <label for="price">Precio</label>
                                    <input class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" id="input-price" type="text" min="0" placeholder="{{ __('precio Q.') }}" value="{{ old('price','0.00') }}" aria-required="true"/>
                                    @if ($errors->has('price'))
                                        <span id="price-error" class="error text-danger" for="input-price">{{ $errors->first('price') }}</span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                                    <label for="discount">Descuento</label>
                                    <input class="form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" name="discount" id="input-discount" type="text" min="0" placeholder="{{ __('descuento %') }}" value="{{ old('discount','0') }}" aria-required="true"/>
                                    @if ($errors->has('discount'))
                                        <span id="discount-error" class="error text-danger" for="input-discount">{{ $errors->first('discount') }}</span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div class="form-group{{ $errors->has('stock') ? ' has-danger' : '' }}">
                                    <label for="stock">Inventario</label>
                                    <input class="form-control{{ $errors->has('stock') ? ' is-invalid' : '' }}" name="stock" id="input-stock" type="text" min="0" placeholder="{{ __('cantidad en inventario') }}" value="{{ old('stock','0') }}" aria-required="true"/>
                                    @if ($errors->has('stock'))
                                        <span id="stock-error" class="error text-danger" for="input-stock">{{ $errors->first('stock') }}</span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                    name="description" rows="1" cols="2" id="input-description" type="text" placeholder="{{ __('escribir en esta sección la descripción del producto') }}"
                                    aria-required="true">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <span id="description-error" class="error text-danger" for="input-description">{{ $errors->first('description') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger" href="{{ route('product.index') }}" data-toggle="tooltip" data-placement="top" title="Cancelar">
                                <i class="material-icons">block</i> Cancelar
                                <div class="ripple-container"></div>
                            </a>
                            <button rel="tooltip"  type="submit" class="btn btn-flat btn-md btn-success" data-toggle="tooltip" data-placement="top" title="Guardar información">
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
                        <h4 class="card-title ">{{ __('Productos') }}</h4>
                        <p class="card-product"> {{ __('En esta pantalla el sistema muestra todas las Productos registrados.') }}</p>
                    </div>
                    <div class="card-body">
                        <form method="get" action="{{ route('product.index') }}" autocomplete="off" class="form-horizontal">
                            @csrf
                            @method('get')
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search">
                                <div class="input-group-append">
                                    <button rel="tooltip" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Buscar información" type="submit">Buscar</button>
                                </div>
                            </div>
                        </form>
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
                                        {{ __('Marca') }}
                                    </th>
                                    <th class="text-center">
                                        {{ __('Producto') }}
                                    </th>
                                    <th class="text-center">
                                        {{ __('Categoría') }}
                                    </th>
                                    <th class="text-center">
                                        {{ __('Precio') }}
                                    </th>
                                    <th class="text-center">
                                        {{ __('Stock') }}
                                    </th>
                                    <th class="text-center">
                                        {{ __('Oferta') }}
                                    </th>
                                    <th class="text-center">
                                        {{ __('Opciones') }}
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td class="text-left">
                                                {{ $item->getBrandAttribute() }}
                                            </td>
                                            <td class="text-left">
                                                {{ "{$item->title} ({$item->getStringNewProductAttribute()})" }}
                                            </td>
                                            <td class="text-left">
                                                {{ $item->getCategoryAttribute() }}
                                            </td>
                                            <td class="text-right">
                                                {{ $item->getStringPriceAttribute() }}
                                            </td>
                                            <td class="text-right">
                                                {{ $item->stock }}
                                            </td>
                                            <td class="text-center">
                                                @if ($item->offer)
                                                    <a rel="tooltip" class="btn btn-success btn-sm btn-round" href="{{ route('product.offer', $item) }}" data-toggle="tooltip" data-placement="top" title="Producto ofertado">
                                                        <i class="material-icons">check_circle_outline</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                @else
                                                    <a rel="tooltip" class="btn btn-danger btn-sm btn-round" href="{{ route('product.offer', $item) }}" data-toggle="tooltip" data-placement="top" title="Producto no ofertado">
                                                        <i class="material-icons">highlight_off</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <form method="post" action="{{ route('product.delete', $item) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <a rel="tooltip" class="btn btn-warning btn-sm btn-round" href="{{ route('product.edit', $item) }}" data-toggle="tooltip" data-placement="top" title="Editar información">
                                                        <i class="material-icons">edit</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                    @if ($item->current)
                                                        <button rel="tooltip" data-toggle="tooltip" data-placement="top" title="Eliminar producto" type="button" class="btn btn-danger btn-sm btn-round" onclick="confirm('{{ __("¿Está seguro que desea eliminar el registro {$item->title} ?") }}') ? this.parentElement.submit() : ''">
                                                            <i class="material-icons">add_shopping_cart</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                    @else
                                                        <button rel="tooltip" data-toggle="tooltip" data-placement="top" title="Activar producto" type="button" class="btn btn-info btn-sm btn-round" onclick="confirm('{{ __("¿Está seguro que desea activar el registro {$item->title} ?") }}') ? this.parentElement.submit() : ''">
                                                            <i class="material-icons">add_shopping_cart</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                    @endif
                                                    <a rel="tooltip" class="btn btn-primary btn-sm btn-round" href="{{ route('product.show', $item) }}" data-toggle="tooltip" data-placement="top" title="Ver información del producto">
                                                        <i class="material-icons">perm_media</i>
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
