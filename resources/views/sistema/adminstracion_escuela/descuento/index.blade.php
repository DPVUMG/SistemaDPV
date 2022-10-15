@extends('layouts.app')
@section('title', 'Descuentos')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('escuela.index') }}">Escuela</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('escuela.edit', $escuela_descuento) }}">Escuela
                                Editar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Descuento</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('sistema.global.form_create_descuento', [ 'escuela' => $escuela_descuento ])
            </div>
            <div class="col-md-12">
                @include('sistema.adminstracion_escuela.descuento.grid', [ 'data' => $escuela_descuento->descuentos,
                'establecimiento' => $escuela_descuento->establecimiento ])
            </div>
        </div>
    </div>
</div>
@endsection