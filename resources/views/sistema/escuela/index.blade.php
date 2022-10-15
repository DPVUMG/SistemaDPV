@extends('layouts.app')
@section('title', 'Escuela')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Escuela</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">{{ __('Escuelas') }}</h4>
                        <p class="card-category"> {{ __('En esta pantalla el sistema muestra todas las escuelas
                            registradas.') }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="get" action="{{ route('escuela.index') }}" autocomplete="off"
                                    class="form-horizontal">
                                    @csrf
                                    @method('get')
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" value="{{ old('search') }}"
                                            name="search">
                                        <div class="input-group-append">
                                            <button rel="tooltip" class="btn btn-sm btn-success" data-toggle="tooltip"
                                                data-placement="top" title="Buscar información"
                                                type="submit">Buscar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12">
                                <p class="badge badge-secondary text-md-right pull-right">
                                    Página
                                    <span class="badge badge-light">{{ number_format($items->currentPage(),0,'',',')
                                        }}</span>
                                    de
                                    <span class="badge badge-light">{{ $items->total() > $items->perPage() ?
                                        number_format($items->perPage(),0,'',',') :
                                        number_format($items->total(),0,'',',')
                                        }}</span>
                                    registros, mostrados
                                    <span class="badge badge-light">{{ $items->total() > $items->perPage() ?
                                        number_format($items->perPage() * $items->currentPage(),0,'',',') :
                                        number_format($items->total(),0,'',',') }}</span>
                                    de un total de
                                    <span class="badge badge-light">{{ number_format($items->total(),0,'',',') }}</span>
                                    registros
                                </p>
                            </div>
                            <div class="col-md-12">
                                <nav aria-label="...">
                                    <ul class="pagination justify-content-end">
                                        {{ $items->links() }}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <table class="dataTableSimple display" style="width:100%">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center align-middle">Información</th>
                                    <th colspan="4" class="text-center align-middle">Ubicación</th>
                                    <th colspan="5" class="text-center align-middle">Extra</th>
                                    <th rowspan="2" class="text-center align-middle">Distrito</th>
                                    <th rowspan="2" class="text-center align-middle">
                                        <img src="{{ asset('image/ico_opcion.png') }}" title="Opciones" height="20px"
                                            alt="Opciones">
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-center align-middle">Logo</th>
                                    <th class="text-center align-middle">NIT</th>
                                    <th class="text-center align-middle">Nombre</th>

                                    <th class="text-center align-middle">Departamento</th>
                                    <th class="text-center align-middle">Municipio</th>
                                    <th class="text-center align-middle">Dirección</th>
                                    <th class="text-center align-middle">Teléfono</th>

                                    <th class="text-center align-middle">Sector</th>
                                    <th class="text-center align-middle">Area</th>
                                    <th class="text-center align-middle">Jornada</th>
                                    <th class="text-center align-middle">Plan</th>
                                    <th class="text-center align-middle">Departamental</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td class="text-center align-middle">
                                        <img src="{{ $item->getPictureAttribute() }}" height="20px"
                                            alt="{{ $item->id }}">
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $item->nit }}
                                    </td>
                                    <td class="text-left align-middle">
                                        {{ $item->establecimiento }}
                                    </td>

                                    <td class="text-left align-middle">
                                        {{ $item->departamento->nombre }}
                                    </td>
                                    <td class="text-left align-middle">
                                        {{ $item->municipio->nombre }}
                                    </td>
                                    <td class="text-left align-middle">
                                        {{ $item->direccion }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $item->telefono }}
                                    </td>

                                    <td class="text-center align-middle">
                                        {{ $item->sector }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $item->area }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $item->jornada }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $item->plan }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $item->departamental->nombre }}
                                    </td>

                                    <td class="text-center align-middle">
                                        {{ $item->distrito->codigo }}
                                    </td>

                                    <td class="text-center">
                                        <form id="formStatus{{ $item->id }}" method="get" action="{{
                                            route('escuela.status', $item) }}">
                                            @csrf
                                            @method('get')
                                            <button rel="tooltip" data-toggle="tooltip" data-placement="top"
                                                title="{{ $item->activo ? " Desactivar {$item->establecimiento}" :
                                                "Activar
                                                {$item->establecimiento}"
                                                }}"
                                                class="{{ $item->activo ? 'btn btn-info btn-sm btn-round' : 'btn
                                                btn-default btn-sm btn-round' }} btnStatus"
                                                id="btnStatus-{{ $item->id }}">
                                                <i class="material-icons">toggle_on</i>
                                                <div class="ripple-container"></div>
                                            </button>
                                        </form>
                                        @if ($item->activo)
                                        <form id="formDelete{{ $item->id }}" method="post"
                                            action="{{ route('escuela.destroy', $item) }}">
                                            @csrf
                                            @method('delete')
                                            <a rel="tooltip" class="btn btn-warning btn-sm btn-round"
                                                href="{{ route('escuela.edit', $item) }}" data-toggle="tooltip"
                                                data-placement="top" title="Editar información">
                                                <i class="material-icons">edit</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                            <button id="btnDelete-{{ $item->id }}" rel="tooltip" data-toggle="tooltip"
                                                data-placement="top" title="{{ __(" Eliminar {$item->establecimiento}")
                                                }}"
                                                class="btn btn-danger btn-sm btn-round btnDelete">
                                                <i class="material-icons">close</i>
                                                <div class="ripple-container"></div>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer mr-auto ml-auto">
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