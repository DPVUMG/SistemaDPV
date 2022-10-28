@extends('layouts.app')
@section('title', 'Alumnos')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('escuela.index') }}">Escuela</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('escuela.edit', $escuela_alumno) }}">Escuela
                                Editar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Alumnos</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <form method="post" action="{{ route('escuela_alumno.update', $escuela_alumno) }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">{{ __('Nueva cantidad de alumnos') }}</h4>
                            <p class="card-category">{{ __("Registrar una nueva cantidad de alumnos a la escuela
                                {$escuela_alumno->establecimiento}") }}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-10">
                                            <div
                                                class="form-group{{ $errors->has('escuela_codigo_id') ? ' has-danger' : '' }}">
                                                <label class="control-label" for="escuela_codigo_id">Código</label>
                                                <select data-live-search="true" data-style="btn-info"
                                                    class="selectpicker form-control-plaintext form-control-sm {{ $errors->has('escuela_codigo_id') ? ' is-invalid' : '' }}"
                                                    name="escuela_codigo_id" id="input-escuela_codigo_id">
                                                </select>
                                                @if ($errors->has('escuela_codigo_id'))
                                                <span id="escuela_codigo_id-error" class="error text-danger"
                                                    for="input-escuela_codigo_id">{{
                                                    $errors->first('escuela_codigo_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <br>
                                            <a href="{{ route('escuela_codigo.show', $escuela_alumno) }}"
                                                title="Agregar uno nuevo" target="_blank" rel="noopener noreferrer">
                                                <img class="img" src="{{ asset('image/ico_agregar.png') }}" width="28px"
                                                    alt="Agregar">
                                            </a>
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <br>
                                            <a href="#" onclick="cargarListCodigosEscuelas({{ $escuela_alumno->id }})"
                                                title="Buscar supervisores">
                                                <img class="img" src="{{ asset('image/ico_buscar.png') }}" width="28px"
                                                    alt="Buscar">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('cantidad_alumno') ? ' has-danger' : '' }}">
                                        <label for="cantidad_alumno">Cantidad</label>
                                        <input
                                            class="form-control{{ $errors->has('cantidad_alumno') ? ' is-invalid' : '' }} solo-numero"
                                            name="cantidad_alumno" id="input-cantidad_alumno" type="text"
                                            placeholder="{{ __('cantidad de alumnos') }}"
                                            value="{{ old('cantidad_alumno') }}" aria-required="true" />
                                        @if ($errors->has('cantidad_alumno'))
                                        <span id="cantidad_alumno-error" class="error text-danger"
                                            for="input-cantidad_alumno">{{
                                            $errors->first('cantidad_alumno') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                                href="{{ route('escuela_alumno.show', $escuela_alumno) }}" data-toggle="tooltip"
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

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">{{ __('Alumnos') }}</h4>
                        <p class="card-category"> {{ __("En esta pantalla el sistema muestra todos los alumnos
                            registrados en la escuela {$escuela_alumno->establecimiento}.") }}</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="dataTable display" style="width:100%">
                                <thead>
                                    <th class="text-center">Código</th>
                                    <th class="text-center">Nivel</th>
                                    <th class="text-center">Alumnos</th>
                                    <th class="text-center">Escuela</th>
                                    <th class="text-center">Mes</th>
                                    <th class="text-center">Año</th>
                                    <th class="text-center">
                                        <img src="{{ asset('image/ico_opcion.png') }}" title="Opciones" height="20px"
                                            alt="Opciones">
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($escuela_alumno->alumnos as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->escuela_codigo->codigo }}</td>
                                        <td class="text-center">{{ $item->nivel->nombre }}</td>
                                        <td class="text-center">{{ $item->cantidad_alumno }}</td>
                                        <td class="text-center">{{ $escuela_alumno->establecimiento }}</td>
                                        <td class="text-center">{{ date('m', strtotime($item->created_at)) }}</td>
                                        <td class="text-center">{{ date('Y', strtotime($item->created_at)) }}</td>
                                        <td class="text-center">
                                            @if($item->activo)
                                            <form id="formStatus{{ $item->id }}" method="post"
                                                action="{{ route('escuela_alumno.destroy', $item) }}">
                                                @csrf
                                                @method('delete')
                                                <button id="btnStatus-{{ $item->id }}" rel="tooltip"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="{{ $item->activo ? " Desactivar
                                                    {$item->escuela_codigo->codigo}|{$item->cantidad_alumno}"
                                                    :
                                                    "Activar
                                                    {$item->escuela_codigo->codigo}|{$item->cantidad_alumno}"
                                                    }}"
                                                    class="{{ $item->activo ? 'btn btn-info btn-sm btn-round' : 'btn
                                                    btn-default btn-sm btn-round' }} btnStatus">
                                                    <i class="material-icons">toggle_on</i>
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
</div>
@endsection
@push('js')
<script type="text/javascript">
    $(document).ready(function () {
    cargarListCodigosEscuelas(@json($escuela_alumno->id))  
});
</script>
@endpush