@extends('layouts.app')
@section('title', 'Director')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('escuela.index') }}">Escuela</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('escuela.edit', $director) }}">Escuela
                                Editar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Director</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <form method="post" action="{{ route('director.update', $director) }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">{{ __('Nuevo director de escuela') }}</h4>
                            <p class="card-category">{{ __("Registrar un nuevo director a la escuela
                                {$director->establecimiento}") }}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('director') ? ' has-danger' : '' }}">
                                        <label for="director">Nombre</label>
                                        <input
                                            class="form-control{{ $errors->has('director') ? ' is-invalid' : '' }} directorInput"
                                            name="director" id="input-director-director" type="text"
                                            placeholder="{{ __('nombre del director') }}" value="{{ old('director') }}"
                                            aria-required="true" />
                                        @if ($errors->has('director'))
                                        <span id="director-error" class="error text-danger" for="input-director">{{
                                            $errors->first('director') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group{{ $errors->has('director_telefono') ? ' has-danger' : '' }}">
                                        <label for="director_telefono">Teléfono</label>
                                        <input
                                            class="form-control{{ $errors->has('director_telefono') ? ' is-invalid' : '' }}"
                                            name="director_telefono" id="input-director_telefono" type="text"
                                            placeholder="{{ __('teléfono del director') }}"
                                            value="{{ old('director_telefono') }}" aria-required="true" />
                                        @if ($errors->has('director_telefono'))
                                        <span id="director_telefono-error" class="error text-danger"
                                            for="input-director_telefono">{{
                                            $errors->first('director_telefono') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                href="{{ route('director.show', $director) }}" data-toggle="tooltip"
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

            <div class="col-md-7">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">{{ __('Directores') }}</h4>
                        <p class="card-category"> {{ __("En esta pantalla el sistema muestra todos los directores
                            registrados en la escuela {$director->establecimiento}.") }}</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="dataTable display" style="width:100%">
                                <thead>
                                    <th class="text-center">Director</th>
                                    <th class="text-center">Teléfono</th>
                                    <th class="text-center">Escuela</th>
                                    <th class="text-center">
                                        <img src="{{ asset('image/ico_opcion.png') }}" title="Opciones" height="20px"
                                            alt="Opciones">
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($director->directores as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->nombre }}</td>
                                        <td class="text-center">{{ $item->telefono }}</td>
                                        <td class="text-center">{{ $director->establecimiento }}</td>
                                        <td class="text-center">
                                            <form id="formStatus{{ $item->id }}" method="post"
                                                action="{{ route('director.destroy', $item) }}">
                                                @csrf
                                                @method('delete')
                                                <button id="btnStatus-{{ $item->id }}" rel="tooltip"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="{{ $item->activo ? " Desactivar {$item->nombre}" :
                                                    "Activar
                                                    {$item->nombre}"
                                                    }}"
                                                    class="{{ $item->activo ? 'btn btn-info btn-sm btn-round' : 'btn
                                                    btn-default btn-sm btn-round' }} btnStatus">
                                                    <i class="material-icons">toggle_on</i>
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