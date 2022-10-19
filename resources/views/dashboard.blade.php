@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row badge-dark">
            <div class="col-sm-12 col-md-4">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">
                                <img src="{{ asset('image/pedido/ingreso.png') }}" title="ingreso" width="50px"
                                    height="50px" alt="ingreso">
                            </i>
                        </div>
                        <p class="card-category">Pedidos Ingresados</p>
                        <h3 class="card-title">{{ $data['count_ingresado'] }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-primary">info</i>
                            <a href="{{ route('escuela_pedido.index') }}">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">
                                <img src="{{ asset('image/pedido/confirmado.png') }}" title="Libreta" width="50px"
                                    height="50px" alt="Libreta">
                            </i>
                        </div>
                        <p class="card-category">Pedidos Confirmados</p>
                        <h3 class="card-title">{{ $data['count_confirmado'] }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-primary">info</i>
                            <a href="{{ route('escuela_pedido.index') }}">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">
                                <img src="{{ asset('image/pedido/entregado.png') }}" title="Libreta" width="50px"
                                    height="50px" alt="Libreta">
                            </i>
                        </div>
                        <p class="card-category">Pedidos Entregados</p>
                        <h3 class="card-title">{{ $data['count_entregado'] }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-primary">info</i>
                            <a href="{{ route('escuela_pedido.index') }}">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">
                                <img src="{{ asset('image/pedido/pagado.png') }}" title="Libreta" width="50px"
                                    height="50px" alt="Libreta">
                            </i>
                        </div>
                        <p class="card-category">Pedidos Pagados</p>
                        <h3 class="card-title">{{ $data['count_pagado'] }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-primary">info</i>
                            <a href="{{ route('escuela_pedido.index') }}">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">
                                <img src="{{ asset('image/pedido/anulado.png') }}" title="Libreta" width="50px"
                                    height="50px" alt="Libreta">
                            </i>
                        </div>
                        <p class="card-category">Pedidos Anulados</p>
                        <h3 class="card-title">{{ $data['count_anulado'] }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-primary">info</i>
                            <a href="{{ route('escuela_pedido.index') }}">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">
                                <img src="{{ asset('image/pedido/cancelado.png') }}" title="Libreta" width="50px"
                                    height="50px" alt="Libreta">
                            </i>
                        </div>
                        <p class="card-category">Pedidos Cancelados</p>
                        <h3 class="card-title">{{ $data['count_cancelado'] }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-primary">info</i>
                            <a href="{{ route('escuela_pedido.index') }}">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection