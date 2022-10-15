@if ($escuela)
<form method="post" action="{{ route('escuela_descuento.update', $escuela) }}" autocomplete="off"
    class="form-horizontal">
    @method('PUT')
    @else
    <form method="post" action="{{ route('escuela_descuento.store') }}" autocomplete="off" class="form-horizontal">
        @method('post')
        @endif
        @csrf
        <div class="card">
            <div class="card-header card-header-success">
                <h4 class="card-title">{{ __('Nuevo descuento') }}</h4>
                @if ($escuela)
                <p class="card-category">{{ "Registrar un nuevo descuento para el escuela {$escuela->establecimiento}"
                    }}
                </p>
                @else
                <p class="card-category">{{ "Registrar un nuevo descuento en el sistema" }}</p>
                @endif
            </div>
            <div class="card-body ">
                <div class="row">
                    @if (!$escuela)
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group{{ $errors->has('escuela_id[]') ? ' has-danger' : '' }}">
                            <label for="escuela_id[]"><span class="text-danger">*</span> Escuela</label>
                            <select data-live-search="true" multiple data-selected-text-format="count > 5"
                                data-header="Seleccionar uno a más" data-actions-box="true"
                                title="Seleccionar uno a más"
                                class="selectpicker show-tick form-control-plaintext form-control-sm {{ $errors->has('escuela_id[]') ? ' is-invalid' : '' }}"
                                name="escuela_id[]" id="input-escuela_id[]">
                            </select>
                            @if ($errors->has('escuela_id[]'))
                            <span id="escuela_id[]-error" class="error text-danger" for="input-escuela_id[]">{{
                                $errors->first('escuela_id[]') }}</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="col-sm-12 col-md-8">
                        <div class="form-group{{ $errors->has('producto_variante_id') ? ' has-danger' : '' }}">
                            <label for="producto_variante_id"><span class="text-danger">*</span> Productos</label>
                            <select data-live-search="true" data-style="btn-default"
                                class="selectpicker form-control-plaintext form-control-sm {{ $errors->has('producto_variante_id') ? ' is-invalid' : '' }}"
                                name="producto_variante_id" id="input-producto_variante_id">
                            </select>
                            @if ($errors->has('producto_variante_id'))
                            <span id="producto_variante_id-error" class="error text-danger"
                                for="input-producto_variante_id">{{
                                $errors->first('producto_variante_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group{{ $errors->has('precio') ? ' has-danger' : '' }}">
                            <label for="precio">Precio</label>
                            <input class="form-control{{ $errors->has('precio') ? ' is-invalid' : '' }}" name="precio"
                                id="input-precio" type="text" min="0" placeholder="{{ __('precio Q.') }}"
                                value="{{ old('precio','0.00') }}" aria-required="true" />
                            @if ($errors->has('precio'))
                            <span id="precio-error" class="error text-danger" for="input-precio">{{
                                $errors->first('precio') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ml-auto mr-auto">
                @if ($escuela)
                <a rel="tooltip" class="btn btn-flat btn-md btn-danger"
                    href="{{ route('escuela_descuento.show', $escuela) }}" data-toggle="tooltip" data-placement="top"
                    title="Cancelar">
                    <i class="material-icons">block</i> Cancelar
                    <div class="ripple-container"></div>
                </a>
                @else
                <a rel="tooltip" class="btn btn-flat btn-md btn-danger" href="{{ route('escuela_descuento.index') }}"
                    data-toggle="tooltip" data-placement="top" title="Cancelar">
                    <i class="material-icons">block</i> Cancelar
                    <div class="ripple-container"></div>
                </a>
                @endif
                <button rel="tooltip" type="submit" class="btn btn-flat btn-md btn-success" data-toggle="tooltip"
                    data-placement="top" title="Guardar información">
                    <i class="material-icons">add_box</i> Guardar
                </button>
            </div>
        </div>
    </form>
    @push('js')
    <script type="text/javascript">
        $(document).ready(function () {
        cargarListPreciosProductos(true)
        cargarListEscuelas(true, true)
});
    </script>
    @endpush