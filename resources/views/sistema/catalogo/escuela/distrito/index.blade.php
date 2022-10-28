@extends('layouts.app')
@section('title', 'Distrito')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('catalogo_escuela.index') }}">Catálogo de
                                Escuela</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Distrito</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            @if (is_null($distrito))
            <div class="col-md-6">
                <form method="post" action="{{ route('distrito.store') }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('post')
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">{{ __('Nuevo distrito') }}</h4>
                            <p class="card-category">{{ __('Registrar un nuevo distrito en el sistema') }}</p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('codigo') ? ' has-danger' : '' }}">
                                        <label for="codigo">Código</label>
                                        <input class="form-control{{ $errors->has('codigo') ? ' is-invalid' : '' }}"
                                            name="codigo" id="input-codigo" type="text"
                                            placeholder="{{ __('código del distrito') }}" value="{{ old('codigo') }}"
                                            aria-required="true" />
                                        @if ($errors->has('codigo'))
                                        <span id="codigo-error" class="error text-danger" for="input-codigo">{{
                                            $errors->first('codigo') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger" href="{{ route('distrito.index') }}"
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
            @else
            <div class="col-md-6">
                <form method="post" action="{{ route('distrito.update', $distrito) }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">{{ __('Editar distrito') }}</h4>
                            <p class="card-category">{{ __('Editar un distrito en el sistema') }}</p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('codigo') ? ' has-danger' : '' }}">
                                        <label for="codigo">Código</label>
                                        <input class="form-control{{ $errors->has('codigo') ? ' is-invalid' : '' }}"
                                            name="codigo" id="input-codigo" type="text"
                                            placeholder="{{ __('código del distrito') }}"
                                            value="{{ old('codigo', $distrito->codigo) }}" aria-required="true" />
                                        @if ($errors->has('codigo'))
                                        <span id="codigo-error" class="error text-danger" for="input-codigo">{{
                                            $errors->first('codigo') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger" href="{{ route('distrito.index') }}"
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
            @endif

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">{{ __('Distritos') }}</h4>
                        <p class="card-category"> {{ __('En esta pantalla el sistema muestra todos los distritos
                            registrados.') }}</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="dataTable display" style="width:100%">
                                <thead>
                                    <th class="text-center">Código</th>
                                    <th class="text-center">
                                        <img src="{{ asset('image/ico_opcion.png') }}" title="Opciones" height="20px"
                                            alt="Opciones">
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td class="text-display">
                                            {{ $item->codigo }}
                                        </td>
                                        <td class="text-center">
                                            <form id="formDelete{{ $item->id }}" method="post"
                                                action="{{ route('distrito.destroy', $item) }}">
                                                @csrf
                                                @method('delete')
                                                <a rel="tooltip" class="btn btn-warning btn-sm btn-round"
                                                    href="{{ route('distrito.edit', $item) }}" data-toggle="tooltip"
                                                    data-placement="top" title="Editar información">
                                                    <i class="material-icons">edit</i>
                                                    <div class="ripple-container"></div>
                                                </a>
                                                <button id="btnDelete-{{ $item->id }}" rel="tooltip"
                                                    data-toggle="tooltip" data-placement="top" title="{{ __(" Eliminar
                                                    {$item->codigo}") }}"
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection