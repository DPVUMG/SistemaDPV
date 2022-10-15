@extends('layouts.app')
@section('title', 'Nivel')

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
                        <li class="breadcrumb-item active" aria-current="page">Nivel</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            @if (is_null($nivel))
            <div class="col-md-6">
                @include('sistema.global.form_create_nivel')
            </div>
            @else
            <div class="col-md-6">
                <form method="post" action="{{ route('nivel.update', $nivel) }}" autocomplete="off"
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
                                    <div class="form-group{{ $errors->has('codigo') ? ' has-danger' : '' }}">
                                        <label for="codigo">Código</label>
                                        <input class="form-control{{ $errors->has('codigo') ? ' is-invalid' : '' }}"
                                            name="codigo" id="input-codigo" type="text"
                                            placeholder="{{ __('código del nivel') }}"
                                            value="{{ old('codigo', $nivel->codigo) }}" aria-required="true" />
                                        @if ($errors->has('codigo'))
                                        <span id="codigo-error" class="error text-danger" for="input-codigo">{{
                                            $errors->first('codigo') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                            name="nombre" id="input-nombre" type="text"
                                            placeholder="{{ __('nombre del nivel') }}"
                                            value="{{ old('nombre', $nivel->nombre) }}" aria-required="true" />
                                        @if ($errors->has('nombre'))
                                        <span id="nombre-error" class="error text-danger" for="input-nombre">{{
                                            $errors->first('nombre') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger" href="{{ route('nivel.index') }}"
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
                        <h4 class="card-title ">{{ __('Niveles') }}</h4>
                        <p class="card-category"> {{ __('En esta pantalla el sistema muestra todos los niveles
                            registrados.') }}</p>
                    </div>
                    <div class="card-body">
                        <table class="dataTable display" style="width:100%">
                            <thead>
                                <th class="text-center">Código</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">
                                    <img src="{{ asset('image/ico_opcion.png') }}" title="Opciones" height="20px"
                                        alt="Opciones">
                                </th>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ $item->codigo }}
                                    </td>
                                    <td class="text-left">
                                        {{ $item->nombre }}
                                    </td>
                                    <td class="text-center">
                                        <form id="formDelete{{ $item->id }}" method="post"
                                            action="{{ route('nivel.destroy', $item) }}">
                                            @csrf
                                            @method('delete')
                                            <a rel="tooltip" class="btn btn-warning btn-sm btn-round"
                                                href="{{ route('nivel.edit', $item) }}" data-toggle="tooltip"
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
</div>
@endsection