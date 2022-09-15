@extends('layouts.app')
@section('title', 'Sistema WEB')

@section('content')
  <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sistema WEB</li>
                    </ol>
                </nav>
            </div>
        </div>
        @if (is_null($web))
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-nav-tabs text-center">
                        <div class="card-header card-header-success">{{ __('Información del Sistema WEB') }}</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="post" action="{{ route('company.store') }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        <div class="row">
                                            <input type="hidden" name="redireccionar" value="index_sistema"/>
                                            <div class="col-sm-12 col-md-4">
                                                <div class="fileinput fileinput-new text-center">
                                                    <div class="fileinput-new thumbnail img-raised">
                                                        <div style="height: 230px; border: solid;" id="imagePreview"></div>
                                                    </div>
                                                    <div>
                                                        <span class="btn btn-raised btn-round btn-rose btn-file">
                                                            <span class="fileinput-new">Seleccionar logotipo</span>
                                                            <span class="fileinput-exists">Cargar</span>
                                                            <input type="file"  onchange="return fileValidation()" name="logotipo" id="input-logotipo" />
                                                        </span>
                                                    </div>
                                                </div>
                                                @if ($errors->has('logotipo'))
                                                    <span id="logotipo-error" class="error text-danger" for="input-logotipo">{{ $errors->first('logotipo') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-sm-12 col-md-8">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group{{ $errors->has('nit') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('nit') ? ' is-invalid' : '' }}"
                                                        name="nit" id="input-nit" type="text" placeholder="{{ __('nit de la empresa') }}"
                                                        value="{{ old('nit') }}" aria-required="true"/>
                                                        @if ($errors->has('nit'))
                                                            <span id="nit-error" class="error text-danger" for="input-nit">{{ $errors->first('nit') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-9">
                                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                        name="name" id="input-name" type="text" placeholder="{{ __('nombre de la empresa') }}"
                                                        value="{{ old('name') }}" aria-required="true"/>
                                                        @if ($errors->has('name'))
                                                            <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <div class="form-group{{ $errors->has('slogan') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('slogan') ? ' is-invalid' : '' }}"
                                                        name="slogan" id="input-slogan" type="text" placeholder="{{ __('slogan o iniciales de la empresa') }}"
                                                        value="{{ old('slogan') }}" aria-required="true"/>
                                                        @if ($errors->has('slogan'))
                                                            <span id="slogan-error" class="error text-danger" for="input-slogan">{{ $errors->first('slogan') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group{{ $errors->has('ubication_x') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('ubication_x') ? ' is-invalid' : '' }}"
                                                        name="ubication_x" id="input-ubication_x" type="text" placeholder="{{ __('longitud') }}"
                                                        value="{{ old('ubication_x') }}" aria-required="true"/>
                                                        @if ($errors->has('ubication_x'))
                                                            <span id="ubication_x-error" class="error text-danger" for="input-ubication_x">{{ $errors->first('ubication_x') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group{{ $errors->has('ubication_y') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('ubication_y') ? ' is-invalid' : '' }}"
                                                        name="ubication_y" id="input-ubication_y" type="text" placeholder="{{ __('latitud') }}"
                                                        value="{{ old('ubication_y') }}" aria-required="true"/>
                                                        @if ($errors->has('ubication_y'))
                                                            <span id="ubication_y-error" class="error text-danger" for="input-ubication_y">{{ $errors->first('ubication_y') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group{{ $errors->has('facebook') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('facebook') ? ' is-invalid' : '' }}"
                                                        name="facebook" id="input-facebook" type="text" placeholder="{{ __('URL de facebook') }}"
                                                        value="{{ old('facebook') }}" aria-required="true"/>
                                                        @if ($errors->has('facebook'))
                                                            <span id="facebook-error" class="error text-danger" for="input-facebook">{{ $errors->first('facebook') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group{{ $errors->has('twitter') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('twitter') ? ' is-invalid' : '' }}"
                                                        name="twitter" id="input-twitter" type="text" placeholder="{{ __('URL de twitter') }}"
                                                        value="{{ old('twitter') }}" aria-required="true"/>
                                                        @if ($errors->has('twitter'))
                                                            <span id="twitter-error" class="error text-danger" for="input-twitter">{{ $errors->first('twitter') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group{{ $errors->has('instagram') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('instagram') ? ' is-invalid' : '' }}"
                                                        name="instagram" id="input-instagram" type="text" placeholder="{{ __('URL de instagram') }}"
                                                        value="{{ old('instagram') }}" aria-required="true"/>
                                                        @if ($errors->has('instagram'))
                                                            <span id="instagram-error" class="error text-danger" for="input-instagram">{{ $errors->first('instagram') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group{{ $errors->has('page') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('page') ? ' is-invalid' : '' }}"
                                                        name="page" id="input-page" type="text" placeholder="{{ __('URL de page') }}"
                                                        value="{{ old('page') }}" aria-required="true"/>
                                                        @if ($errors->has('page'))
                                                            <span id="page-error" class="error text-danger" for="input-page">{{ $errors->first('page') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group{{ $errors->has('vision') ? ' has-danger' : '' }}">
                                                <textarea class="form-control{{ $errors->has('vision') ? ' is-invalid' : '' }}"
                                                name="vision" rows="10" cols="10" id="input-vision" type="text" placeholder="{{ __('escribir en esta sección la visión de la empresa') }}"
                                                aria-required="true">{{ old('vision') }}</textarea>
                                                @if ($errors->has('vision'))
                                                    <span id="vision-error" class="error text-danger" for="input-vision">{{ $errors->first('vision') }}</span>
                                                @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group{{ $errors->has('mision') ? ' has-danger' : '' }}">
                                                <textarea class="form-control{{ $errors->has('mision') ? ' is-invalid' : '' }}"
                                                name="mision" rows="10" cols="10" id="input-mision" type="text" placeholder="{{ __('escribir en esta sección la misión de la empresa') }}"
                                                aria-required="true">{{ old('mision') }}</textarea>
                                                @if ($errors->has('mision'))
                                                    <span id="mision-error" class="error text-danger" for="input-mision">{{ $errors->first('mision') }}</span>
                                                @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <a rel="tooltip" class="btn btn-flat btn-md btn-danger" href="{{ route('company.index_sistema') }}" data-toggle="tooltip" data-placement="top" title="Cancelar">
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
                </div>

            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-nav-tabs text-center">
                        <div class="card-header card-header-success">{{ __('Información del Sistema WEB') }}</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="post" action="{{ route('company.update', $web) }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <input type="hidden" name="redireccionar" value="index_sistema"/>
                                            <div class="col-sm-12 col-md-4">
                                                <div class="fileinput fileinput-new text-center">
                                                    <div class="fileinput-new thumbnail img-raised">
                                                        @if($web->logotipo)
                                                            <div style="height: 230px; border: solid;" id="imagePreview"><img width="100%" height="100%" src="{{ $web->logotipo }}"/></div>
                                                        @else
                                                            <div style="height: 230px; border: solid;" id="imagePreview"></div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <span class="btn btn-raised btn-round btn-rose btn-file">
                                                            <span class="fileinput-new">Seleccionar logotipo</span>
                                                            <span class="fileinput-exists">Cargar</span>
                                                            <input type="file"  onchange="return fileValidation()" name="logotipo" id="input-logotipo" />
                                                        </span>
                                                    </div>
                                                </div>
                                                @if ($errors->has('logotipo'))
                                                    <span id="logotipo-error" class="error text-danger" for="input-logotipo">{{ $errors->first('logotipo') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-sm-12 col-md-8">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group{{ $errors->has('nit') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('nit') ? ' is-invalid' : '' }}"
                                                        name="nit" id="input-nit" type="text" placeholder="{{ __('nit de la empresa') }}"
                                                        value="{{ old('nit',$web->name) }}" aria-required="true"/>
                                                        @if ($errors->has('nit'))
                                                            <span id="nit-error" class="error text-danger" for="input-nit">{{ $errors->first('nit') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-9">
                                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                        name="name" id="input-name" type="text" placeholder="{{ __('nombre de la empresa') }}"
                                                        value="{{ old('name',$web->name) }}" aria-required="true"/>
                                                        @if ($errors->has('name'))
                                                            <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-3">
                                                        <div class="form-group{{ $errors->has('slogan') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('slogan') ? ' is-invalid' : '' }}"
                                                        name="slogan" id="input-slogan" type="text" placeholder="{{ __('slogan o iniciales de la empresa') }}"
                                                        value="{{ old('slogan',$web->slogan) }}" aria-required="true"/>
                                                        @if ($errors->has('slogan'))
                                                            <span id="slogan-error" class="error text-danger" for="input-slogan">{{ $errors->first('slogan') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group{{ $errors->has('ubication_x') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('ubication_x') ? ' is-invalid' : '' }}"
                                                        name="ubication_x" id="input-ubication_x" type="text" placeholder="{{ __('longitud') }}"
                                                        value="{{ old('ubication_x',$web->ubication_x) }}" aria-required="true"/>
                                                        @if ($errors->has('ubication_x'))
                                                            <span id="ubication_x-error" class="error text-danger" for="input-ubication_x">{{ $errors->first('ubication_x') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group{{ $errors->has('ubication_y') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('ubication_y') ? ' is-invalid' : '' }}"
                                                        name="ubication_y" id="input-ubication_y" type="text" placeholder="{{ __('latitud') }}"
                                                        value="{{ old('ubication_y',$web->ubication_y) }}" aria-required="true"/>
                                                        @if ($errors->has('ubication_y'))
                                                            <span id="ubication_y-error" class="error text-danger" for="input-ubication_y">{{ $errors->first('ubication_y') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group{{ $errors->has('facebook') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('facebook') ? ' is-invalid' : '' }}"
                                                        name="facebook" id="input-facebook" type="text" placeholder="{{ __('URL de facebook') }}"
                                                        value="{{ old('facebook',$web->facebook) }}" aria-required="true"/>
                                                        @if ($errors->has('facebook'))
                                                            <span id="facebook-error" class="error text-danger" for="input-facebook">{{ $errors->first('facebook') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group{{ $errors->has('twitter') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('twitter') ? ' is-invalid' : '' }}"
                                                        name="twitter" id="input-twitter" type="text" placeholder="{{ __('URL de twitter') }}"
                                                        value="{{ old('twitter',$web->twitter) }}" aria-required="true"/>
                                                        @if ($errors->has('twitter'))
                                                            <span id="twitter-error" class="error text-danger" for="input-twitter">{{ $errors->first('twitter') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group{{ $errors->has('instagram') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('instagram') ? ' is-invalid' : '' }}"
                                                        name="instagram" id="input-instagram" type="text" placeholder="{{ __('URL de instagram') }}"
                                                        value="{{ old('instagram',$web->instagram) }}" aria-required="true"/>
                                                        @if ($errors->has('instagram'))
                                                            <span id="instagram-error" class="error text-danger" for="input-instagram">{{ $errors->first('instagram') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="form-group{{ $errors->has('page') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('page') ? ' is-invalid' : '' }}"
                                                        name="page" id="input-page" type="text" placeholder="{{ __('URL de page') }}"
                                                        value="{{ old('page',$web->page) }}" aria-required="true"/>
                                                        @if ($errors->has('page'))
                                                            <span id="page-error" class="error text-danger" for="input-page">{{ $errors->first('page') }}</span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group{{ $errors->has('vision') ? ' has-danger' : '' }}">
                                                <textarea class="form-control{{ $errors->has('vision') ? ' is-invalid' : '' }}"
                                                name="vision" rows="10" cols="10" id="input-vision" type="text" placeholder="{{ __('escribir en esta sección la visión de la empresa') }}"
                                                aria-required="true">{{ old('vision',$web->vision) }}</textarea>
                                                @if ($errors->has('vision'))
                                                    <span id="vision-error" class="error text-danger" for="input-vision">{{ $errors->first('vision') }}</span>
                                                @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group{{ $errors->has('mision') ? ' has-danger' : '' }}">
                                                <textarea class="form-control{{ $errors->has('mision') ? ' is-invalid' : '' }}"
                                                name="mision" rows="10" cols="10" id="input-mision" type="text" placeholder="{{ __('escribir en esta sección la misión de la empresa') }}"
                                                aria-required="true">{{ old('mision',$web->mision) }}</textarea>
                                                @if ($errors->has('mision'))
                                                    <span id="mision-error" class="error text-danger" for="input-mision">{{ $errors->first('mision') }}</span>
                                                @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <a rel="tooltip" class="btn btn-flat btn-md btn-danger" href="{{ route('company.index_sistema') }}" data-toggle="tooltip" data-placement="top" title="Cancelar">
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
                                <div class="col-sm-12 col-md-12"><br><br></div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method="post" action="{{ route('company.phone_store', $web) }}" autocomplete="off" class="form-horizontal">
                                                @csrf
                                                @method('PUT')
                                                <div class="card ">
                                                    <div class="card-header card-header-danger">
                                                        <h4 class="card-title">{{ __('Nuevo número de teléfono') }}</h4>
                                                        <p class="card-category">{{ __("Registrar un teléfono a la empresa {$web->name}") }}</p>
                                                    </div>
                                                    <div class="card-body ">
                                                        <div class="row">
                                                            <input type="hidden" name="redireccionar" value="index_sistema"/>
                                                            <div class="col-sm-12 col-md-12">
                                                                <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                                                <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                                                    name="phone" id="input-phone" type="text" placeholder="{{ __('número de teléfono') }}" value="{{ old('phone') }}" aria-required="true"/>
                                                                @if ($errors->has('phone'))
                                                                    <span id="phone-error" class="error text-danger" for="input-phone">{{ $errors->first('phone') }}</span>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer ml-auto mr-auto">
                                                        <a rel="tooltip" class="btn btn-flat btn-md btn-danger" href="{{ route('company.index_sistema') }}" data-toggle="tooltip" data-placement="top" title="Cancelar">
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
                                                        @foreach($web->phones as $item)
                                                            <tr>
                                                                <td class="text-left">
                                                                    {{ $item->phone }}
                                                                </td>
                                                                <td class="text-center">
                                                                    <form method="post" action="{{ route('company.phone_delete', $item) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button type="button" class="btn btn-danger btn-sm btn-round" onclick="confirm('{{ __("¿Está seguro que desea eliminar el registro {$item->phone} ?") }}') ? this.parentElement.submit() : ''">
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
                                            <form method="post" action="{{ route('company.direction_store', $web) }}" autocomplete="off" class="form-horizontal">
                                                @csrf
                                                @method('PUT')
                                                <div class="card ">
                                                    <div class="card-header card-header-warning">
                                                        <h4 class="card-title">{{ __('Nueva dirección') }}</h4>
                                                        <p class="card-category">{{ __("Registrar una dirección a la empresa {$web->name}") }}</p>
                                                    </div>
                                                    <div class="card-body ">
                                                        <div class="row">
                                                            <input type="hidden" name="redireccionar" value="index_sistema"/>
                                                            <div class="col-sm-12 col-md-12">
                                                                <div class="form-group{{ $errors->has('direction') ? ' has-danger' : '' }}">
                                                                <input class="form-control{{ $errors->has('direction') ? ' is-invalid' : '' }}"
                                                                    name="direction" id="input-direction" type="text" placeholder="{{ __('dirección') }}" value="{{ old('direction') }}" aria-required="true"/>
                                                                @if ($errors->has('direction'))
                                                                    <span id="direction-error" class="error text-danger" for="input-direction">{{ $errors->first('direction') }}</span>
                                                                @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer ml-auto mr-auto">
                                                        <a rel="tooltip" class="btn btn-flat btn-md btn-danger" href="{{ route('company.index_sistema') }}" data-toggle="tooltip" data-placement="top" title="Cancelar">
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
                                                        @foreach($web->addresses as $item)
                                                            <tr>
                                                                <td class="text-left">
                                                                    {{ $item->direction }}
                                                                </td>
                                                                <td class="text-center">
                                                                    <form method="post" action="{{ route('company.direction_delete', $item) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button type="button" class="btn btn-danger btn-sm btn-round" onclick="confirm('{{ __("¿Está seguro que desea eliminar el registro {$item->phone} ?") }}') ? this.parentElement.submit() : ''">
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

  <script>
    function fileValidation(){
        var fileInput = document.getElementById('input-logotipo');
        var filePath = fileInput.value;
        var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
        if(!allowedExtensions.exec(filePath))
        {
            Swal.fire({
              type: 'error',
              title: 'Oops...',
              text: 'Solo se permiten imagenes en formato .jpeg/.jpg/.png',
            })
            fileInput.value = '';
            return false;
        }else{
            //Image preview
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').innerHTML = '<img width="100%" height="100%" src="'+e.target.result+'"/>';
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    }
  </script>
@endsection
