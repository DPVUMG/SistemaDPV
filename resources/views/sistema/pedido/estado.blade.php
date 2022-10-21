@extends('layouts.app')
@section('title', 'Estado')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Estado</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">
                            {{ "Pedidos en estado {$estado->nombre}" }}
                        </h4>
                    </div>
                    <div class="card-body">
                        @include('sistema.pedido.componente.table', [ 'items' => $items, 'estado' => $estado->id ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection