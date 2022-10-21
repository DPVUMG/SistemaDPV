@extends('layouts.app')
@section('title', 'Historial de Pedidos')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Historial de Pedidos</li>
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
                        <table class="dataTable display" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center align-middle">Pedido</th>
                                    <th colspan="2" class="text-center align-middle">Estado</th>
                                    <th rowspan="2" class="text-center align-middle">Usuario</th>
                                    <th rowspan="2" class="text-center align-middle">Descripción</th>
                                    <th rowspan="2" class="text-center align-middle">Escuela</th>
                                    <th rowspan="2" class="text-center align-middle">Fecha</th>
                                    <th rowspan="2" class="text-center align-middle">
                                        <img src="{{ asset('image/ico_opcion.png') }}" title="Opciones" height="20px"
                                            alt="Opciones">
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-center align-middle">Anterior</th>
                                    <th class="text-center align-middle">Actual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td class="text-center align-middle">{{ $item->escuela_pedido_id }}</td>
                                    <td class="text-center align-middle">{{ $item->estado_anterior }}</td>
                                    <td class="text-center align-middle">{{ $item->estado_actual }}</td>

                                    <td class="text-center align-middle">{{ $item->usuario }}</td>
                                    <td class="text-left align-middle">{{ $item->descripcion }}</td>
                                    <td class="text-left align-middle">{{ $item->escuela->establecimiento }}</td>
                                    <td class="text-center align-middle">
                                        {{ date('d/m/Y H:i:s', strtotime($item->created_at)) }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('escuela_pedido_historial.show', $item->escuela_pedido_id) }}"
                                            class="btn btn-link btn-outline-info" rel="noopener noreferrer">
                                            Pedido #{{ $item->escuela_pedido_id }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection