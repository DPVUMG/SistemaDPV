@extends('layouts.app')
@section('title', 'Escuela')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('escuela.index') }}">Escuela</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Escuela Editar</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('sistema.global.form_edit_escuela', ['escuela' => $escuela])
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="card card-stats">
                    <div class=" card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <img src="{{ asset('image/ico_supervisor.png') }}" class="my-auto" height="40px"
                                alt="Supervisores">
                        </div>
                        <p class="card-category">Supervisores</p>
                        <h3 class="card-title">{{ $escuela->supervisores->count() }}</h3>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('escuela_supervisor.show', $escuela) }}"
                            class="btn btn-block btn-lg btn-warning">Editar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card card-stats">
                    <div class=" card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <img src="{{ asset('image/ico_codigos.png') }}" class="my-auto" height="40px" alt="Códigos">
                        </div>
                        <p class="card-category">Códigos</p>
                        <h3 class="card-title">{{ $escuela->codigos->count() }}</h3>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('escuela_codigo.show', $escuela) }}"
                            class="btn btn-block btn-lg btn-warning">Editar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card card-stats">
                    <div class=" card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <img src="{{ asset('image/ico_alumno.png') }}" class="my-auto" height="40px" alt="Alumnos">
                        </div>
                        <p class="card-category">Alumnos</p>
                        <h3 class="card-title">{{ $escuela->alumnos->count() }}</h3>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('escuela_alumno.show', $escuela) }}"
                            class="btn btn-block btn-lg btn-warning">Editar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card card-stats">
                    <div class=" card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <img src="{{ asset('image/ico_director.png') }}" class="my-auto" height="40px"
                                alt="Directores">
                        </div>
                        <p class="card-category">Directores</p>
                        <h3 class="card-title">{{ $escuela->directores->count() }}</h3>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('director.show', $escuela) }}"
                            class="btn btn-block btn-lg btn-warning">Editar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card card-stats">
                    <div class=" card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <img src="{{ asset('image/ico_usuarios.png') }}" class="my-auto" height="40px"
                                alt="Usuarios">
                        </div>
                        <p class="card-category">Usuarios</p>
                        <h3 class="card-title">{{ $escuela->usuarios->count() }}</h3>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('escuela_usuario.show', $escuela) }}"
                            class="btn btn-block btn-lg btn-default">Administrar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card card-stats">
                    <div class=" card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <img src="{{ asset('image/ico_descuento.png') }}" class="my-auto" height="40px"
                                alt="Descuentos">
                        </div>
                        <p class="card-category">Descuentos</p>
                        <h3 class="card-title">{{ $escuela->descuentos->count() }}</h3>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('escuela_descuento.show', $escuela) }}"
                            class="btn btn-block btn-lg btn-warning">Editar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection