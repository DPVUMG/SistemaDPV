@extends('layouts.app')
@section('title', 'Usuarios')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('sistema.adminstracion_escuela.usuario.grid', [ 'data' => $items,
                'establecimiento' => null, 'administracion' => true, 'escuela' => true ])
            </div>
        </div>
    </div>
</div>
@endsection