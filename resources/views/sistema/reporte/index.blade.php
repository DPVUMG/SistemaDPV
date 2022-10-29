@extends('layouts.app')
@section('title', 'Reportes')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reportes</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card card-profile ml-auto mr-auto">
                                    <div class="card-body bg-info">
                                        <a href="{{ route('reporte.pagos_realizados') }}">
                                            <img class="img img-thumbnail" src="{{ asset('image/ico_reporte.png') }}">
                                        </a>
                                        <h2 class="card-title">Pagos Realizados</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-profile ml-auto mr-auto">
                                    <div class="card-body bg-warning">
                                        <a href="{{ route('reporte.pagos_pendientes') }}">
                                            <img class="img img-thumbnail" src="{{ asset('image/ico_reporte.png') }}">
                                        </a>
                                        <h2 class="card-title">Pagos Pendientes</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-profile ml-auto mr-auto">
                                    <div class="card-body bg-primary">
                                        <a href="{{ route('reporte.pedidos_escuelas') }}">
                                            <img class="img img-thumbnail" src="{{ asset('image/ico_reporte.png') }}">
                                        </a>
                                        <h2 class="card-title">Pedidos por Escuela</h2>
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