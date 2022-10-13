@extends('layouts.app')
@section('title', 'Supervisor')

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
                        <li class="breadcrumb-item active" aria-current="page">Supervisor</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            @if (is_null($supervisor))
            <div class="col-md-5">
                <form method="post" action="{{ route('supervisor.store') }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('post')
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">{{ __('Nuevo supervisor') }}</h4>
                            <p class="card-category">{{ __('Registrar un nuevo supervisor en el sistema') }}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('distrito_id') ? ' has-danger' : '' }}">
                                        <label for="distrito_id">Distrito</label>
                                        <input
                                            class="form-control{{ $errors->has('distrito_id') ? ' is-invalid' : '' }} distritoInput"
                                            name="distrito_id" id="input-distrito_id" type="text"
                                            placeholder="{{ __('distrito del supervisor') }}"
                                            value="{{ old('distrito_id') }}" aria-required="true" />
                                        @if ($errors->has('distrito_id'))
                                        <span id="distrito_id-error" class="error text-danger"
                                            for="input-distrito_id">{{
                                            $errors->first('distrito_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                            name="nombre" id="input-nombre" type="text"
                                            placeholder="{{ __('nombre del supervisor') }}" value="{{ old('nombre') }}"
                                            aria-required="true" />
                                        @if ($errors->has('nombre'))
                                        <span id="nombre-error" class="error text-danger" for="input-nombre">{{
                                            $errors->first('nombre') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group{{ $errors->has('telefono') ? ' has-danger' : '' }}">
                                        <label for="telefono">Teléfono</label>
                                        <input class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}"
                                            name="telefono" id="input-telefono" type="text"
                                            placeholder="{{ __('teléfono del supervisor') }}"
                                            value="{{ old('telefono') }}" aria-required="true" />
                                        @if ($errors->has('telefono'))
                                        <span id="telefono-error" class="error text-danger" for="input-telefono">{{
                                            $errors->first('telefono') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                href="{{ route('supervisor.index') }}" data-toggle="tooltip" data-placement="top"
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
            <div class="col-md-5">
                <form method="post" action="{{ route('supervisor.update', $supervisor) }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">{{ __('Editar supervisor') }}</h4>
                            <p class="card-category">{{ __('Editar un supervisor en el sistema') }}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('distrito_id') ? ' has-danger' : '' }}">
                                        <label for="distrito_id">Distrito</label>
                                        <input
                                            class="form-control{{ $errors->has('distrito_id') ? ' is-invalid' : '' }} distritoInput"
                                            name="distrito_id" id="input-distrito_id" type="text"
                                            placeholder="{{ __('distrito del supervisor') }}"
                                            value="{{ old('distrito_id', $supervisor->distrito->codigo) }}"
                                            aria-required="true" />
                                        @if ($errors->has('distrito_id'))
                                        <span id="distrito_id-error" class="error text-danger"
                                            for="input-distrito_id">{{
                                            $errors->first('distrito_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                            name="nombre" id="input-nombre" type="text"
                                            placeholder="{{ __('nombre del supervisor') }}"
                                            value="{{ old('nombre', $supervisor->nombre) }}" aria-required="true" />
                                        @if ($errors->has('nombre'))
                                        <span id="nombre-error" class="error text-danger" for="input-nombre">{{
                                            $errors->first('nombre') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group{{ $errors->has('telefono') ? ' has-danger' : '' }}">
                                        <label for="telefono">Teléfono</label>
                                        <input class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}"
                                            name="telefono" id="input-telefono" type="text"
                                            placeholder="{{ __('teléfono del supervisor') }}"
                                            value="{{ old('telefono', $supervisor->telefono) }}" aria-required="true" />
                                        @if ($errors->has('telefono'))
                                        <span id="telefono-error" class="error text-danger" for="input-telefono">{{
                                            $errors->first('telefono') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                href="{{ route('supervisor.index') }}" data-toggle="tooltip" data-placement="top"
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

            <div class="col-md-7">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">{{ __('Supervisores') }}</h4>
                        <p class="card-category"> {{ __('En esta pantalla el sistema muestra todos los supervisores
                            registrados.') }}</p>
                    </div>
                    <div class="card-body">
                        <table class="dataTable display" style="width:100%">
                            <thead>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Teléfono</th>
                                <th class="text-center">Distrito</th>
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
                                        {{ $item->telefono }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->distrito->codigo }}
                                    </td>
                                    <td class="text-center">
                                        <form id="formStatus{{ $item->id }}" method="get" action="{{
                                            route('supervisor.show', $item) }}">
                                            @csrf
                                            @method('get')
                                            <button rel="tooltip" data-toggle="tooltip" data-placement="top"
                                                title="{{ $item->activo ? " Desactivar {$item->nombre}" : "Activar
                                                {$item->nombre}"
                                                }}"
                                                class="{{ $item->activo ? 'btn btn-info btn-sm btn-round' : 'btn
                                                btn-default btn-sm btn-round' }} btnStatus"
                                                id="btnStatus-{{ $item->id }}">
                                                <i class="material-icons">toggle_on</i>
                                                <div class="ripple-container"></div>
                                            </button>
                                        </form>
                                        @if ($item->activo)
                                        <form id="formDelete{{ $item->id }}" method="post"
                                            action="{{ route('supervisor.destroy', $item) }}">
                                            @csrf
                                            @method('delete')
                                            <a rel="tooltip" class="btn btn-warning btn-sm btn-round"
                                                href="{{ route('supervisor.edit', $item) }}" data-toggle="tooltip"
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
                                        @endif
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