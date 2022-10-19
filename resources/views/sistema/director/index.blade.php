@extends('layouts.app')
@section('title', 'Directores')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Directores</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">
                            {{ __('Directores Activos') }}
                        </h4>
                        <p class="card-category"> {{ __("En esta pantalla el sistema muestra todos los directores
                            registrados en el sistema.") }}</p>
                    </div>
                    <div class="card-body">
                        <table class="dataTableExport display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">Director</th>
                                    <th class="text-center align-middle">Teléfono</th>
                                    <th class="text-center align-middle">Escuela</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td class="text-left align-middle">{{ $item->nombre }}</td>
                                    <td class="text-center align-middle">{{ $item->telefono }}</td>
                                    <td class="text-left align-middle">{{ $item->establecimiento }}</td>
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