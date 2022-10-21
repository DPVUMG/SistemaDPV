@extends('layouts.app')
@section('title', 'Detalle del Historial')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('escuela_pedido_historial.index') }}">
                                Historial del Pedido
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Pedido #{{ $escuela_pedido_historial->id }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-historia">
                        <h4 class="card-title">
                            {{ __('Historial') }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <ul class="timeline timeline-simple">
                            @foreach ($escuela_pedido_historial->escuela_pedido_historial->sortByDesc('created_at') as
                            $item)
                            <li class="timeline-inverted">
                                <div class="timeline-badge danger">
                                    <i class="material-icons">info</i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <span class="badge badge-pill badge-info">{{ $item->estado_actual }}</span>
                                    </div>
                                    <div class="timeline-body">
                                        <p>{{ $item->usuario }}</p>
                                    </div>
                                    <h6>
                                        <i class="ti-time"></i> {{ date('d/m/Y H:i:s', strtotime($item->created_at)) }}
                                    </h6>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection