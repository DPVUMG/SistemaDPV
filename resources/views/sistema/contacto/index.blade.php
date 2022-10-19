@extends('layouts.app')
@section('title', 'Contactos')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contactos</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @include('sistema.contacto.grid', [ 'titulo' => "Directores", 'items' => $data['directores'] ])
            </div>
            <div class="col-md-6">
                @include('sistema.contacto.grid', [ 'titulo' => "Supervisores", 'items' => $data['supervisores'] ])
            </div>
            <div class="col-md-6">
                @include('sistema.contacto.grid', [ 'titulo' => "Escuelas", 'items' => $data['escuelas'] ])
            </div>
            <div class="col-md-6">
                @include('sistema.contacto.grid', [ 'titulo' => "Usuarios", 'items' => $data['usuarios'] ])
            </div>
        </div>
    </div>
</div>
@endsection