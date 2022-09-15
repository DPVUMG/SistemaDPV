@extends('layouts.app')
@section('title', 'Categorías')

@section('content')
  <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Créditos para aprobación</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">{{ __('Créditos') }}</h4>
                        <p class="card-category"> {{ __('En esta pantalla el sistema muestra todos los créditos que esperan respuesta de aprobación.') }}</p>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-default pull-right">
                            Página
                            <span class="badge badge-light">{{ number_format($items->currentPage(),0,'',',') }}</span>
                            de
                            <span class="badge badge-light">{{ $items->total() > $items->perPage() ? number_format($items->perPage(),0,'',',') : number_format($items->total(),0,'',',') }}</span>
                            registros, mostrados
                            <span class="badge badge-light">{{ $items->total() > $items->perPage() ? number_format($items->perPage() * $items->currentPage(),0,'',',') : number_format($items->total(),0,'',',') }}</span>
                            de un total de
                            <span class="badge badge-light">{{ number_format($items->total(),0,'',',') }}</span>
                            registros
                        </button>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <th class="text-center">
                                        {{ __('Cliente') }}
                                    </th>
                                    <th class="text-center">
                                        {{ __('Aplicando al crédito') }}
                                    </th>
                                    <th class="text-center">
                                        {{ __('Opciones') }}
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td class="text-left">
                                                {{ $item->getUsuarioAttribute() }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->getCreditConcatAttribute() }}
                                            </td>
                                            <td class="text-center">
                                                <form method="post" action="{{ route('credit.update', $item) }}" autocomplete="off" class="form-horizontal">
                                                    @csrf
                                                    @method('PUT')
                                                    <input name="approved" hidden id="input-approved" type="text" value="SI"/>
                                                    <button rel="tooltip"  type="submit" class="btn btn-flat btn-md btn-success" data-toggle="tooltip" data-placement="top" title="Aprobar crédito">
                                                        SI
                                                    </button>
                                                </form>
                                                <form method="post" action="{{ route('credit.update', $item) }}" autocomplete="off" class="form-horizontal">
                                                    @csrf
                                                    @method('PUT')
                                                    <input name="approved" hidden id="input-approved" type="text" value="NO"/>
                                                    <button rel="tooltip"  type="submit" class="btn btn-flat btn-md btn-danger" data-toggle="tooltip" data-placement="top" title="Rechazar crédito">
                                                        NO
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end">
                                {{ $items->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
