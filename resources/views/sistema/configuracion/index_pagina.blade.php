@extends('layouts.app')
@section('title', 'Configuración Página WEB')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Configuración Página WEB</li>
                    </ol>
                </nav>
            </div>
        </div>
        @if (!is_null($web))
        <div class="row">
            <div class="col-md-12">
                <div class="card card-nav-tabs text-center">
                    <div class="card-header card-header-info">{{ __('Información de la Configuración Página WEB') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" action="{{ route('configuracion.update', $web) }}"
                                    autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="redireccionar" value="index_pagina" />
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="fileinput fileinput-new text-center">
                                                <div class="fileinput-new thumbnail img-raised">
                                                    @if($web->logotipo)
                                                    <div style="height: 230px; border: solid;" id="imagePreview"><img
                                                            width="100%" height="100%" src="{{ $web->logotipo }}" />
                                                    </div>
                                                    @else
                                                    <div style="height: 230px; border: solid;" id="imagePreview"></div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="btn btn-raised btn-round btn-rose btn-file">
                                                        <span class="fileinput-new">Seleccionar logotipo</span>
                                                        <span class="fileinput-exists">Cargar</span>
                                                        <input type="file" onchange="return fileValidation()"
                                                            name="logotipo" id="input-logotipo" />
                                                    </span>
                                                </div>
                                            </div>
                                            @if ($errors->has('logotipo'))
                                            <span id="logotipo-error" class="error text-danger" for="input-logotipo">{{
                                                $errors->first('logotipo') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-sm-12 col-md-8">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('nit') ? ' has-danger' : '' }}">
                                                        <label for="nit">nit de la empresa</label>
                                                        <input
                                                            class="form-control{{ $errors->has('nit') ? ' is-invalid' : '' }}"
                                                            name="nit" id="input-nit" type="text"
                                                            placeholder="{{ __('nit de la empresa') }}"
                                                            value="{{ old('nit',$web->nit) }}" aria-required="true" />
                                                        @if ($errors->has('nit'))
                                                        <span id="nit-error" class="error text-danger"
                                                            for="input-nit">{{ $errors->first('nit') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-9">
                                                    <div
                                                        class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                                                        <label for="nit">nombre de la empresa</label>
                                                        <input
                                                            class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                                            name="nombre" id="input-name" type="text"
                                                            placeholder="{{ __('nombre de la empresa') }}"
                                                            value="{{ old('nombre',$web->nombre) }}"
                                                            aria-required="true" />
                                                        @if ($errors->has('nombre'))
                                                        <span id="nombre-error" class="error text-danger"
                                                            for="input-nombre">{{ $errors->first('nombre') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    <div
                                                        class="form-group{{ $errors->has('slogan') ? ' has-danger' : '' }}">
                                                        <label for="slogan">slogan o iniciales de la empresa</label>
                                                        <input
                                                            class="form-control{{ $errors->has('slogan') ? ' is-invalid' : '' }}"
                                                            name="slogan" id="input-slogan" type="text"
                                                            placeholder="{{ __('slogan o iniciales de la empresa') }}"
                                                            value="{{ old('slogan',$web->slogan) }}"
                                                            aria-required="true" />
                                                        @if ($errors->has('slogan'))
                                                        <span id="slogan-error" class="error text-danger"
                                                            for="input-slogan">{{ $errors->first('slogan') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('ubicacion_x') ? ' has-danger' : '' }}">
                                                        <label for="ubicacion_x">longitud</label>
                                                        <input
                                                            class="form-control{{ $errors->has('ubicacion_x') ? ' is-invalid' : '' }}"
                                                            name="ubicacion_x" id="input-ubicacion_x" type="text"
                                                            placeholder="{{ __('longitud') }}"
                                                            value="{{ old('ubicacion_x',$web->ubicacion_x) }}"
                                                            aria-required="true" />
                                                        @if ($errors->has('ubicacion_x'))
                                                        <span id="ubicacion_x-error" class="error text-danger"
                                                            for="input-ubicacion_x">{{ $errors->first('ubicacion_x')
                                                            }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('ubicacion_y') ? ' has-danger' : '' }}">
                                                        <label for="ubicacion_x">latitud</label>
                                                        <input
                                                            class="form-control{{ $errors->has('ubicacion_y') ? ' is-invalid' : '' }}"
                                                            name="ubicacion_y" id="input-ubicacion_y" type="text"
                                                            placeholder="{{ __('latitud') }}"
                                                            value="{{ old('ubicacion_y',$web->ubicacion_y) }}"
                                                            aria-required="true" />
                                                        @if ($errors->has('ubicacion_y'))
                                                        <span id="ubicacion_y-error" class="error text-danger"
                                                            for="input-ubicacion_y">{{ $errors->first('ubicacion_y')
                                                            }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('facebook') ? ' has-danger' : '' }}">
                                                        <label for="facebook">URL de facebook</label>
                                                        <input
                                                            class="form-control{{ $errors->has('facebook') ? ' is-invalid' : '' }}"
                                                            name="facebook" id="input-facebook" type="text"
                                                            placeholder="{{ __('URL de facebook') }}"
                                                            value="{{ old('facebook',$web->facebook) }}"
                                                            aria-required="true" />
                                                        @if ($errors->has('facebook'))
                                                        <span id="facebook-error" class="error text-danger"
                                                            for="input-facebook">{{ $errors->first('facebook') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('twitter') ? ' has-danger' : '' }}">
                                                        <label for="twitter">URL de twitter</label>
                                                        <input
                                                            class="form-control{{ $errors->has('twitter') ? ' is-invalid' : '' }}"
                                                            name="twitter" id="input-twitter" type="text"
                                                            placeholder="{{ __('URL de twitter') }}"
                                                            value="{{ old('twitter',$web->twitter) }}"
                                                            aria-required="true" />
                                                        @if ($errors->has('twitter'))
                                                        <span id="twitter-error" class="error text-danger"
                                                            for="input-twitter">{{ $errors->first('twitter') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('instagram') ? ' has-danger' : '' }}">
                                                        <label for="instagram">URL de instagram</label>
                                                        <input
                                                            class="form-control{{ $errors->has('instagram') ? ' is-invalid' : '' }}"
                                                            name="instagram" id="input-instagram" type="text"
                                                            placeholder="{{ __('URL de instagram') }}"
                                                            value="{{ old('instagram',$web->instagram) }}"
                                                            aria-required="true" />
                                                        @if ($errors->has('instagram'))
                                                        <span id="instagram-error" class="error text-danger"
                                                            for="input-instagram">{{ $errors->first('instagram')
                                                            }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('url') ? ' has-danger' : '' }}">
                                                        <label for="url">URL de página</label>
                                                        <input
                                                            class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}"
                                                            name="url" id="input-url" type="text"
                                                            placeholder="{{ __('URL de page') }}"
                                                            value="{{ old('url',$web->url) }}" aria-required="true" />
                                                        @if ($errors->has('url'))
                                                        <span id="url-error" class="error text-danger"
                                                            for="input-url">{{ $errors->first('url') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group{{ $errors->has('vision') ? ' has-danger' : '' }}">
                                                <label for="vision">escribir en esta sección la visión de la
                                                    empresa</label>
                                                <textarea
                                                    class="form-control{{ $errors->has('vision') ? ' is-invalid' : '' }}"
                                                    name="vision" rows="10" cols="10" id="input-vision" type="text"
                                                    placeholder="{{ __('escribir en esta sección la visión de la empresa') }}"
                                                    aria-required="true">{{ old('vision',$web->vision) }}</textarea>
                                                @if ($errors->has('vision'))
                                                <span id="vision-error" class="error text-danger" for="input-vision">{{
                                                    $errors->first('vision') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group{{ $errors->has('mision') ? ' has-danger' : '' }}">
                                                <label for="mision">escribir en esta sección la misión de la
                                                    empresa</label>
                                                <textarea
                                                    class="form-control{{ $errors->has('mision') ? ' is-invalid' : '' }}"
                                                    name="mision" rows="10" cols="10" id="input-mision" type="text"
                                                    placeholder="{{ __('escribir en esta sección la misión de la empresa') }}"
                                                    aria-required="true">{{ old('mision',$web->mision) }}</textarea>
                                                @if ($errors->has('mision'))
                                                <span id="mision-error" class="error text-danger" for="input-mision">{{
                                                    $errors->first('mision') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                                href="{{ route('configuracion.index_pagina') }}" data-toggle="tooltip"
                                                data-placement="top" title="Cancelar edición">
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
                            <div class="col-sm-12 col-md-12"><br><br></div>
                            <div class="col-sm-12 col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="post" action="{{ route('configuracion.telefono_store', $web) }}"
                                            autocomplete="off" class="form-horizontal">
                                            @csrf
                                            @method('PUT')
                                            <div class="card ">
                                                <div class="card-header card-header-danger">
                                                    <h4 class="card-title">{{ __('Nuevo número de teléfono') }}</h4>
                                                    <p class="card-category">{{ __("Registrar un teléfono a la empresa
                                                        {$web->nombre}") }}</p>
                                                </div>
                                                <div class="card-body ">
                                                    <div class="row">
                                                        <input type="hidden" name="redireccionar"
                                                            value="index_pagina" />
                                                        <div class="col-sm-12 col-md-12">
                                                            <div
                                                                class="form-group{{ $errors->has('telefono') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}"
                                                                    name="telefono" id="input-telefono" type="text"
                                                                    placeholder="{{ __('número de teléfono') }}"
                                                                    value="{{ old('telefono') }}"
                                                                    aria-required="true" />
                                                                @if ($errors->has('telefono'))
                                                                <span id="telefono-error" class="error text-danger"
                                                                    for="input-telefono">{{ $errors->first('telefono')
                                                                    }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer ml-auto mr-auto">
                                                    <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                                        href="{{ route('configuracion.index_pagina') }}"
                                                        data-toggle="tooltip" data-placement="top" title="Cancelar">
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
                                                        {{ __('Teléfono') }}
                                                    </th>
                                                    <th class="text-center">
                                                        {{ __('Opciones') }}
                                                    </th>
                                                </thead>
                                                <tbody>
                                                    @foreach($web->telefonos as $item)
                                                    <tr>
                                                        <td class="text-left">
                                                            {{ $item->telefono }}
                                                        </td>
                                                        <td class="text-center">
                                                            <form method="post"
                                                                action="{{ route('configuracion.telefono_delete', $item) }}">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm btn-round"
                                                                    onclick="confirm('{{ __(" ¿Está seguro que desea
                                                                    eliminar el registro {$item->telefono} ?") }}') ?
                                                                    this.parentElement.submit() : ''">
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
                            <div class="col-sm-12 col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="post" action="{{ route('configuracion.direccion_store', $web) }}"
                                            autocomplete="off" class="form-horizontal">
                                            @csrf
                                            @method('PUT')
                                            <div class="card ">
                                                <div class="card-header card-header-warning">
                                                    <h4 class="card-title">{{ __('Nueva dirección') }}</h4>
                                                    <p class="card-category">{{ __("Registrar una dirección a la empresa
                                                        {$web->nombre}") }}</p>
                                                </div>
                                                <div class="card-body ">
                                                    <div class="row">
                                                        <input type="hidden" name="redireccionar"
                                                            value="index_pagina" />
                                                        <div class="col-sm-12 col-md-12">
                                                            <div
                                                                class="form-group{{ $errors->has('direccion') ? ' has-danger' : '' }}">
                                                                <input
                                                                    class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}"
                                                                    name="direccion" id="input-direccion" type="text"
                                                                    placeholder="{{ __('dirección') }}"
                                                                    value="{{ old('direccion') }}"
                                                                    aria-required="true" />
                                                                @if ($errors->has('direccion'))
                                                                <span id="direccion-error" class="error text-danger"
                                                                    for="input-direccion">{{ $errors->first('direccion')
                                                                    }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer ml-auto mr-auto">
                                                    <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                                        href="{{ route('configuracion.index_pagina') }}"
                                                        data-toggle="tooltip" data-placement="top" title="Cancelar">
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
                                                        {{ __('Dirección') }}
                                                    </th>
                                                    <th class="text-center">
                                                        {{ __('Opciones') }}
                                                    </th>
                                                </thead>
                                                <tbody>
                                                    @foreach($web->direcciones as $item)
                                                    <tr>
                                                        <td class="text-left">
                                                            {{ $item->direccion }}
                                                        </td>
                                                        <td class="text-center">
                                                            <form method="post"
                                                                action="{{ route('configuracion.direccion_delete', $item) }}">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm btn-round"
                                                                    onclick="confirm('{{ __(" ¿Está seguro que desea
                                                                    eliminar el registro {$item->direccion} ?") }}') ?
                                                                    this.parentElement.submit() : ''">
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
                    <div class="card-footer text-muted">
                        {{ $web->getFormatoFechaAttribute() }}
                    </div>
                </div>
            </div>

        </div>
        @endif
    </div>
</div>
@endsection