@extends('layouts.app')
@section('title', 'Departamental')

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
                        <li class="breadcrumb-item active" aria-current="page">Departamental</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            @if (is_null($departamental))
            <div class="col-md-6">
                <form method="post" action="{{ route('departamental.store') }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('post')
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">{{ __('Nueva departamental') }}</h4>
                            <p class="card-category">{{ __('Registrar una nueva departamental en el sistema') }}</p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                            name="nombre" id="input-nombre" type="text"
                                            placeholder="{{ __('departamental') }}" value="{{ old('nombre') }}"
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
                                href="{{ route('departamental.index') }}" data-toggle="tooltip" data-placement="top"
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
            @else
            <div class="col-md-6">
                <form method="post" action="{{ route('departamental.update', $departamental) }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">{{ __('Editar departamental') }}</h4>
                            <p class="card-category">{{ __('Editar una departamental en el sistema') }}</p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                            name="nombre" id="input-nombre" type="text"
                                            placeholder="{{ __('departamental') }}"
                                            value="{{ old('nombre', $departamental->nombre) }}" aria-required="true" />
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
                                href="{{ route('departamental.index') }}" data-toggle="tooltip" data-placement="top"
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
            @endif

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">{{ __('Departamentales') }}</h4>
                        <p class="card-category"> {{ __('En esta pantalla el sistema muestra todas las departamentales
                            registradas.') }}</p>
                    </div>
                    <div class="card-body">
                        <table class="dataTable display" style="width:100%">
                            <thead>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">
                                    <img src="{{ asset('image/ico_opcion.png') }}" title="Opciones" height="20px"
                                        alt="Opciones">
                                </th>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td class="text-left">
                                        {{ $item->nombre }}
                                    </td>
                                    <td class="text-center">
                                        <form id="formDelete{{ $item->id }}" method="post"
                                            action="{{ route('departamental.destroy', $item) }}">
                                            @csrf
                                            @method('delete')
                                            <a rel="tooltip" class="btn btn-warning btn-sm btn-round"
                                                href="{{ route('departamental.edit', $item) }}" data-toggle="tooltip"
                                                data-placement="top" title="Editar información">
                                                <i class="material-icons">edit</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                            <button id="btnDelete-{{ $item->id }}" rel="tooltip" data-toggle="tooltip"
                                                data-placement="top" title="{{ __(" Eliminar {$item->nombre}") }}"
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
@endsection