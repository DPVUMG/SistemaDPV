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
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Productos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('product.update', $product) }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card ">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">{{ __('Editar producto') }}</h4>
                            <p class="card-category">{{ __('Modificar el producto con nombre ') }} <strong>{{ $product->title }}</strong></p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12 col-md-8">
                                    <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                                    <select data-live-search="true" data-style="btn-default" class="selectpicker form-control{{ $errors->has('sub_category_id') ? ' is-invalid' : '' }}" name="sub_category_id" id="input-sub_category_id">
                                        <option value="">Seleccionar una categoría</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}"
                                            {{ ($item->id == old('sub_category_id',$product->sub_category_id)) ? 'selected' : '' }}>{{ $item->getCategoryAttribute() }}</option>
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
                                            {{ ($item->id == old('brand_id',$product->brand_id)) ? 'selected' : '' }}>{{ $item->name }}</option>
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
                                    <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="input-title" type="text" placeholder="{{ __('nombre del producto') }}" value="{{ old('title',$product->title) }}" aria-required="true"/>
                                    @if ($errors->has('title'))
                                        <span id="title-error" class="error text-danger" for="input-title">{{ $errors->first('title') }}</span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                    <label for="price">Precio</label>
                                    <input class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" id="input-price" type="text" min="0" placeholder="{{ __('precio Q.') }}" value="{{ old('price',$product->price) }}" aria-required="true"/>
                                    @if ($errors->has('price'))
                                        <span id="price-error" class="error text-danger" for="input-price">{{ $errors->first('price') }}</span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                                    <label for="discount">Descuento</label>
                                    <input class="form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" name="discount" id="input-discount" type="text" min="0" placeholder="{{ __('descuento %') }}" value="{{ old('discount',$product->discount) }}" aria-required="true"/>
                                    @if ($errors->has('discount'))
                                        <span id="discount-error" class="error text-danger" for="input-discount">{{ $errors->first('discount') }}</span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div class="form-group{{ $errors->has('stock') ? ' has-danger' : '' }}">
                                    <label for="stock">Inventario</label>
                                    <input class="form-control{{ $errors->has('stock') ? ' is-invalid' : '' }}" name="stock" id="input-stock" type="text" min="0" placeholder="{{ __('cantidad en inventario') }}" value="{{ old('stock',$product->stock) }}" aria-required="true"/>
                                    @if ($errors->has('stock'))
                                        <span id="stock-error" class="error text-danger" for="input-stock">{{ $errors->first('stock') }}</span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                    name="description" rows="1" cols="2" id="input-description" type="text" placeholder="{{ __('escribir en esta sección la descripción del producto') }}"
                                    aria-required="true">{{ old('description',$product->description) }}</textarea>
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
    </div>
  </div>
@endsection
