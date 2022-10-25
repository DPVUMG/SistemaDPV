@extends('layouts.app')
@section('title', 'Gastos')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gastos</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('gasto.store') }}" autocomplete="off" class="form-horizontal">
                    @method('post')
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">{{ __('Nuevo gasto') }}</h4>
                            <p class="card-category">{{ "Registrar un nuevo gasto en el sistema" }}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group{{ $errors->has('monto') ? ' has-danger' : '' }}">
                                        <label for="monto">Monto</label>
                                        <input class="form-control{{ $errors->has('monto') ? ' is-invalid' : '' }}"
                                            name="monto" id="input-monto" type="text" min="0"
                                            placeholder="{{ __('monto Q.') }}" aria-required="true" />
                                        @if ($errors->has('monto'))
                                        <span id="monto-error" class="error text-danger" for="input-monto">{{
                                            $errors->first('monto') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group{{ $errors->has('descripcion') ? ' has-danger' : '' }}">
                                        <label for="descripcion">Descripción</label>
                                        <textarea
                                            class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}"
                                            name="descripcion" id="input-descripcion" cols="30" rows="5"></textarea>
                                        @if ($errors->has('descripcion'))
                                        <span id="descripcion-error" class="error text-danger"
                                            for="input-descripcion">{{
                                            $errors->first('descripcion') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <a rel="tooltip" class="btn btn-flat btn-md btn-danger" href="{{ route('gasto.index') }}"
                                data-toggle="tooltip" data-placement="top" title="Cancelar">
                                <i class="material-icons">block</i> Cancelar
                                <div class="ripple-container"></div>
                            </a>
                            <button rel="tooltip" type="submit" class="btn btn-flat btn-md btn-success"
                                data-toggle="tooltip" data-placement="top" title="Guardar información">
                                <i class="material-icons">add_box</i> Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                @include('sistema.gasto.componente.grid', [ 'items' => $items])
            </div>
        </div>
    </div>
</div>
@endsection