@extends('layouts.app')
@section('title', 'Pagos')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pagos</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('sistema.pago.componente.form_create', [ 'bancos' => $bancos, 'pedidos' => $pedidos ])
            </div>
            <div class="col-md-12">
                @include('sistema.pago.componente.grid', [ 'data' => $items ])
            </div>
        </div>
    </div>
</div>
@endsection