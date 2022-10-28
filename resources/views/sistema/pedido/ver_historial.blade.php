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
                        <div class="timeline">
                            @foreach ($escuela_pedido_historial->escuela_pedido_historial->sortByDesc('created_at') as
                            $item)
                            <div class="{{ $item->getColorAttribute($item->estado_pedido_id) }}">
                                <div class="timeline-icon">
                                    <i class="{{ $item->getIconAttribute($item->estado_pedido_id) }}"></i>
                                </div>
                                <div class="timeline-body">
                                    <h4 class="timeline-title">
                                        <span class="badge">
                                            {{ $item->estado_anterior }}
                                        </span>
                                    </h4>
                                    <p>
                                        {{ $item->descripcion }}
                                    </p>
                                    <p class="timeline-subtitle">
                                        <i class=" fa fa-clock-o"></i>
                                        {{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}
                                    </p>
                                    <p class="timeline-subtitle">
                                        <i class="fa fa-user"></i>
                                        {{ $item->usuario }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection