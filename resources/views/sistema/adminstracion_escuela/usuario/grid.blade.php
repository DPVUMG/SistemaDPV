<div class="card">
    <div class="card-header card-header-info">
        <h4 class="card-title ">
            {{ __('Usuarios') }}
            @if ($administracion)
            @php
            $ruta = $escuela ? 'escuela_usuario.create' : 'usuario.create';
            @endphp
            <a href="{{ route($ruta) }}" title="Agregar uno nuevo" rel="noopener noreferrer">
                <img class="img" src="{{ asset('image/ico_agregar.png') }}" width="28px" alt="Agregar">
            </a>
            @endif
        </h4>
        @if (is_null($establecimiento))
        <p class="card-category"> {{ __("En esta pantalla el sistema muestra todos los usuarios
            registrados en el sistema.") }}</p>
        @else
        <p class="card-category"> {{ __("En esta pantalla el sistema muestra todos los usuarios
            registrados en la escuela {$establecimiento}.") }}</p>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center align-middle">Fotografía</th>
                        <th colspan="{{ $escuela ? '3' : '2' }}" class="text-center align-middle">Identificador</th>
                        <th rowspan="2" class="text-center align-middle">Nombre Completo</th>
                        <th colspan="3" class="text-center align-middle">Ubicación</th>
                        <th colspan="2" class="text-center align-middle">Contacto</th>
                        <th colspan="2" class="text-center align-middle">Fecha</th>
                        <th rowspan="2" class="text-center align-middle">
                            <img src="{{ asset('image/ico_opcion.png') }}" title="Opciones" height="20px"
                                alt="Opciones">
                        </th>
                    </tr>
                    <tr>
                        <th class="text-center align-middle">CUI</th>
                        <th class="text-center align-middle">Usuario</th>
                        @if ($escuela)
                        <th class="text-center align-middle">Escuela</th>
                        @endif

                        <th class="text-center align-middle">Departamento</th>
                        <th class="text-center align-middle">Municipio</th>
                        <th class="text-center align-middle">Dirección</th>

                        <th class="text-center align-middle">Teléfono</th>
                        <th class="text-center align-middle">Correo Electrónico</th>

                        <th class="text-center align-middle">Creación</th>
                        <th class="text-center align-middle">Actualización</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td class="text-center align-middle">
                            <img src="{{ is_null($item->persona->getPictureAttribute()) ? asset('image/persona_default.png') : $item->persona->getPictureAttribute() }}"
                                alt="{{ $item->persona->cui }}" width="100px" class="img img-thumbnail">
                        </td>

                        <td class="text-center align-middle">{{ $item->persona->cui }}</td>
                        <td class="text-center align-middle">{{ $item->usuario }}</td>
                        @if ($escuela)
                        <td class="text-center align-middle">{{ $item->escuela->establecimiento }}</td>
                        @endif

                        <td class="text-center align-middle">{{ "{$item->persona->nombre} {$item->persona->apellido}"}}
                        </td>

                        <td class="text-center align-middle">{{ $item->persona->departamento->nombre }}</td>
                        <td class="text-center align-middle">{{ $item->persona->municipio->nombre }}</td>
                        <td class="text-center align-middle">{{ $item->persona->direccion }}</td>

                        <td class="text-center align-middle">
                            <a href="tel:+502 {{ $item->persona->telefono }}">{{
                                $item->persona->telefono }}</a>
                        </td>
                        <td class="text-center align-middle">
                            <a href="mailto:{{ $item->persona->correo_electronico }}">
                                {{ $item->persona->correo_electronico}}</a>
                        </td>

                        <td class="text-center align-middle">{{ date('d/m/Y H:i:s',
                            strtotime($item->persona->created_at))
                            }}</td>
                        <td class="text-center align-middle">{{ date('d/m/Y H:i:s',
                            strtotime($item->persona->updated_at))
                            }}</td>

                        <td class="text-center align-middle">
                            @if (!$escuela)
                            <a rel="tooltip" class="btn btn-warning btn-sm btn-round"
                                href="{{ route('usuario.edit', $item) }}" data-toggle="tooltip" data-placement="top"
                                title="Ver usuario">
                                <i class="fa fa-edit"></i>
                            </a>

                            <form id="formStatus{{ $item->id }}" method="get"
                                action="{{ route('usuario.status', $item) }}">
                                @csrf
                                @method('get')
                                <button rel="tooltip" data-toggle="tooltip" data-placement="top"
                                    title="{{ $item->activo ? " Desactivar {$item->usuario}" :
                                    "Activar
                                    {$item->usuario}"
                                    }}"
                                    class="{{ $item->activo ? 'btn btn-info btn-sm btn-round' : 'btn
                                    btn-default btn-sm btn-round' }} btnStatus"
                                    id="btnStatus-{{ $item->id }}">
                                    <i class="material-icons">toggle_on</i>
                                    <div class="ripple-container"></div>
                                </button>
                            </form>
                            @else
                            @if ($administracion)
                            <a rel="tooltip" class="btn btn-warning btn-sm btn-round"
                                href="{{ route('escuela_usuario.edit', $item) }}" data-toggle="tooltip"
                                data-placement="top" title="Editar información">
                                <i class="material-icons">edit</i>
                                <div class="ripple-container"></div>
                            </a>
                            @else
                            <form id="formStatus{{ $item->id }}" method="get"
                                action="{{ route('escuela_usuario.status', $item) }}">
                                @csrf
                                @method('get')
                                <button rel="tooltip" data-toggle="tooltip" data-placement="top"
                                    title="{{ $item->activo ? " Desactivar {$item->usuario}" :
                                    "Activar
                                    {$item->usuario}"
                                    }}"
                                    class="{{ $item->activo ? 'btn btn-info btn-sm btn-round' : 'btn
                                    btn-default btn-sm btn-round' }} btnStatus"
                                    id="btnStatus-{{ $item->id }}">
                                    <i class="material-icons">toggle_on</i>
                                    <div class="ripple-container"></div>
                                </button>
                            </form>
                            @endif
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>