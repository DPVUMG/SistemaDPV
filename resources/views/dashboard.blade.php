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
        <div class="row">
            <div class="col-sm-12 col-md-7">
                <div class="row badge-dark">
                    <br><br>
                    <div class="col-sm-12 col-md-12 text-white text-center">
                        <h3>
                            Información correspondiente del {{ date('d-m-Y', strtotime($data['fecha_actual'])) }} hasta
                            {{
                            date('d-m-Y', strtotime($data['fecha_menos_siete_dias'])) }}
                        </h3>
                    </div>
                    <hr>
                    <div class="col-sm-12 col-md-4">
                        @include('sistema.componente_dashboard.tarjeta', [
                        'titulo' => "Pedidos Ingresados",
                        'data' => $data,
                        'count' => 'count_ingresado',
                        'estado_id' => 1
                        ])
                    </div>
                    <div class="col-sm-12 col-md-4">
                        @include('sistema.componente_dashboard.tarjeta', [
                        'titulo' => "Pedidos Confirmados",
                        'data' => $data,
                        'count' => 'count_confirmado',
                        'estado_id' => 2
                        ])
                    </div>
                    <div class="col-sm-12 col-md-4">
                        @include('sistema.componente_dashboard.tarjeta', [
                        'titulo' => "Pedidos Entregados",
                        'data' => $data,
                        'count' => 'count_entregado',
                        'estado_id' => 3
                        ])
                    </div>
                    <div class="col-sm-12 col-md-4">
                        @include('sistema.componente_dashboard.tarjeta', [
                        'titulo' => "Pedidos Pagados",
                        'data' => $data,
                        'count' => 'count_pagado',
                        'estado_id' => 4
                        ])
                    </div>
                    <div class="col-sm-12 col-md-4">
                        @include('sistema.componente_dashboard.tarjeta', [
                        'titulo' => "Pedidos Anulados",
                        'data' => $data,
                        'count' => 'count_anulado',
                        'estado_id' => 5
                        ])
                    </div>
                    <div class="col-sm-12 col-md-4">
                        @include('sistema.componente_dashboard.tarjeta', [
                        'titulo' => "Pedidos Cancelados",
                        'data' => $data,
                        'count' => 'count_cancelado',
                        'estado_id' => 6
                        ])
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-5">
                @include('sistema.componente_dashboard.grafica_pagos', [ 'grafica' => $data['graficaPagoMensual'] ])
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('sistema.componente_dashboard.calendario')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('sistema.componente_dashboard.grafica_pedido_inversion', [
                'grafica' => $data['graficaPedidoInversion']
                ])
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('sistema.componente_dashboard.grafica_pedido_solicitado', [
                'grafica' => $data['graficaPedidoSolicitados']
                ])
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('sistema.componente_dashboard.grafica_ingreso_gasto', [
                'grafica' => $data['graficaIngresosGastos']
                ])
            </div>
        </div>
    </div>
    @endsection