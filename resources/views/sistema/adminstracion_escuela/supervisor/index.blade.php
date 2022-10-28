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
                        <li class="breadcrumb-item"><a href="{{ route('escuela.index') }}">Escuela</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('escuela.edit', $escuela_supervisor) }}">Escuela
                                Editar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Supervisor</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="{{ route('escuela_supervisor.update', $escuela_supervisor) }}"
                    autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">{{ __('Nuevo supervisor') }}</h4>
                            <p class="card-category">{{ __("Registrar un nuevo supervisor a la escuela
                                {$escuela_supervisor->establecimiento}") }}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-10">
                                            <div
                                                class="form-group{{ $errors->has('supervisor_id') ? ' has-danger' : '' }}">
                                                <label class="control-label" for="supervisor_id">Supervisor</label>
                                                <select data-live-search="true" data-style="btn-info"
                                                    class="selectpicker form-control-plaintext form-control-sm {{ $errors->has('supervisor_id') ? ' is-invalid' : '' }}"
                                                    name="supervisor_id" id="input-supervisor_id">
                                                </select>
                                                @if ($errors->has('supervisor_id'))
                                                <span id="supervisor_id-error" class="error text-danger"
                                                    for="input-supervisor_id">{{
                                                    $errors->first('supervisor_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <br>
                                            <a href="{{ route('supervisor.index') }}" title="Agregar uno nuevo"
                                                target="_blank" rel="noopener noreferrer">
                                                <img class="img" src="{{ asset('image/ico_agregar.png') }}" width="28px"
                                                    alt="Agregar">
                                            </a>
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <br>
                                            <a href="#" onclick="cargarListSupervisores()" title="Buscar supervisores">
                                                <img class="img" src="{{ asset('image/ico_buscar.png') }}" width="28px"
                                                    alt="Buscar">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                href="{{ route('escuela_supervisor.show', $escuela_supervisor) }}" data-toggle="tooltip"
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

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">{{ __('Supervisores') }}</h4>
                        <p class="card-category"> {{ __("En esta pantalla el sistema muestra todos los supervisores
                            registrados en la escuela {$escuela_supervisor->establecimiento}.") }}</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="dataTable display" style="width:100%">
                                <thead>
                                    <th class="text-center">Distrito</th>
                                    <th class="text-center">Supervisor</th>
                                    <th class="text-center">Escuela</th>
                                    <th class="text-center">
                                        <img src="{{ asset('image/ico_opcion.png') }}" title="Opciones" height="20px"
                                            alt="Opciones">
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($escuela_supervisor->supervisores as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->distrito->codigo }}</td>
                                        <td class="text-center">{{ $item->supervisor->nombre }}</td>
                                        <td class="text-center">{{ $escuela_supervisor->establecimiento }}</td>
                                        <td class="text-center">
                                            <form id="formDelete{{ $item->id }}" method="post"
                                                action="{{ route('escuela_supervisor.destroy', $item) }}">
                                                @csrf
                                                @method('delete')
                                                <button id="btnDelete-{{ $item->id }}" rel="tooltip"
                                                    data-toggle="tooltip" data-placement="top" title="{{ __(" Eliminar
                                                    {$item->supervisor->nombre}") }}"
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