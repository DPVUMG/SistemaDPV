@extends('layouts.app')
@section('title', 'Editar Usuario')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('usuario.index') }}">Usuarios del Sistema</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar Usuario</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form id="formEscuela" method="post" action="{{ route('usuario.update', $usuario) }}" autocomplete="off"
                    class="form-horizontal " enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card"
                        style="background-image: url('{{ asset('image/escuela/fondo_usuario_sistema.jpg') }}'); background-size: cover;">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">Editar usuario {{ $usuario->usuario }}</h4>
                            <p class="category">Formulario para editar el usuario seleccionado</p>
                        </div>
                        <div class="card-body">
                            <div class="row jumbotron">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <p>NOTA: Todos los campos que cuenta
                                            con el simbolo <b class="text-danger">*</b> son obligatorios.</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    @include('sistema.global.form_create_usuario', [
                                    'municipios' => $municipios,
                                    'escuelas' => null,
                                    'escuela_usuario' => $usuario
                                    ])
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a rel="tooltip" class="btn btn-danger" href="{{ route('usuario.edit', $usuario) }}"
                                data-toggle="tooltip" data-placement="top" title="Cancelar">
                                <img class="img" src="{{ asset('image/ico_borrador.png') }}" width="20px">
                                Cancelar
                            </a>
                            <button rel="tooltip" type="submit" class="btn btn-success" data-toggle="tooltip"
                                data-placement="top" title="Guardar informaci??n">
                                <img class="img" src="{{ asset('image/ico_guardar.png') }}" width="20px">
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
