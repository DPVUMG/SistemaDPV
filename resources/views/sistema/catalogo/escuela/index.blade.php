@extends('layouts.app')
@section('title', 'Catálogo de Escuela')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Catálogo de Escuela</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-success">
                        <h4 class="card-title">{{ __('Catálogo') }}</h4>
                        <p class="card-category">{{ __('Opciones que ayudarán a administrar las escuelas') }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card card-profile ml-auto mr-auto">
                                    <div class="card-body">
                                        <a href="{{ route('departamental.index') }}">
                                            <img class="img img-thumbnail" src="{{ asset('image/ico_menu.png') }}">
                                        </a>
                                        <h2 class="card-title">Departamental</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-profile ml-auto mr-auto">
                                    <div class="card-body">
                                        <a href="{{ route('distrito.index') }}">
                                            <img class="img img-thumbnail" src="{{ asset('image/ico_menu.png') }}">
                                        </a>
                                        <h2 class="card-title">Distrito</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-profile ml-auto mr-auto">
                                    <div class="card-body">
                                        <a href="{{ route('nivel.index') }}">
                                            <img class="img img-thumbnail" src="{{ asset('image/ico_menu.png') }}">
                                        </a>
                                        <h2 class="card-title">Nivel</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-profile ml-auto mr-auto">
                                    <div class="card-body">
                                        <a href="{{ route('supervisor.index') }}">
                                            <img class="img img-thumbnail" src="{{ asset('image/ico_menu.png') }}">
                                        </a>
                                        <h2 class="card-title">Supervisor</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection