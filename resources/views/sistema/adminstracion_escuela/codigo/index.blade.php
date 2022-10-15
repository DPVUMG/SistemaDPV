@extends('layouts.app')
@section('title', 'Códigos')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('escuela.index') }}">Escuela</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('escuela.edit', $escuela_codigo) }}">Escuela
                                Editar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Códigos</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <form method="post" action="{{ route('escuela_codigo.update', $escuela_codigo) }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">{{ __('Nuevo código de escuela') }}</h4>
                            <p class="card-category">{{ __("Registrar un nuevo código a la escuela
                                {$escuela_codigo->establecimiento}") }}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-10">
                                            <div class="form-group{{ $errors->has('nivel_id') ? ' has-danger' : '' }}">
                                                <label class="control-label" for="nivel_id">Nivel</label>
                                                <select data-live-search="true" data-style="btn-info"
                                                    class="selectpicker form-control-plaintext form-control-sm {{ $errors->has('nivel_id') ? ' is-invalid' : '' }}"
                                                    name="nivel_id" id="input-nivel_id">
                                                </select>
                                                @if ($errors->has('nivel_id'))
                                                <span id="nivel_id-error" class="error text-danger"
                                                    for="input-nivel_id">{{
                                                    $errors->first('nivel_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <br>
                                            <a href="{{ route('nivel.index') }}" title="Agregar uno nuevo"
                                                target="_blank" rel="noopener noreferrer">
                                                <img class="img" src="{{ asset('image/ico_agregar.png') }}" width="28px"
                                                    alt="Agregar">
                                            </a>
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <br>
                                            <a href="#" onclick="cargarListNiveles()" title="Buscar supervisores">
                                                <img class="img" src="{{ asset('image/ico_buscar.png') }}" width="28px"
                                                    alt="Buscar">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('codigo') ? ' has-danger' : '' }}">
                                        <label for="codigo">Código</label>
                                        <input class="form-control{{ $errors->has('codigo') ? ' is-invalid' : '' }}"
                                            name="codigo" id="input-codigo" type="text"
                                            placeholder="{{ __('cantidad de alumnos') }}" value="{{ old('codigo') }}"
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
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                href="{{ route('escuela_codigo.show', $escuela_codigo) }}" data-toggle="tooltip"
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
                        <h4 class="card-title ">{{ __('Códigos') }}</h4>
                        <p class="card-category"> {{ __("En esta pantalla el sistema muestra todos los códigos
                            registrados en la escuela {$escuela_codigo->establecimiento}.") }}</p>
                    </div>
                    <div class="card-body">
                        <table class="dataTable display" style="width:100%">
                            <thead>
                                <th class="text-center">Código</th>
                                <th class="text-center">Nivel</th>
                                <th class="text-center">Escuela</th>
                                <th class="text-center">
                                    <img src="{{ asset('image/ico_opcion.png') }}" title="Opciones" height="20px"
                                        alt="Opciones">
                                </th>
                            </thead>
                            <tbody>
                                @foreach($escuela_codigo->codigos as $item)
                                <tr>
                                    <td class="text-center">{{ $item->codigo }}</td>
                                    <td class="text-center">{{ $item->nivel->nombre }}</td>
                                    <td class="text-center">{{ $escuela_codigo->establecimiento }}</td>
                                    <td class="text-center">
                                        <form id="formStatus{{ $item->id }}" method="post"
                                            action="{{ route('escuela_codigo.destroy', $item) }}">
                                            @csrf
                                            @method('delete')
                                            <button id="btnStatus-{{ $item->id }}" rel="tooltip" data-toggle="tooltip"
                                                data-placement="top" title="{{ $item->activo ? " Desactivar
                                                {$item->codigo}" :
                                                "Activar
                                                {$item->codigo}"
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
@endsection