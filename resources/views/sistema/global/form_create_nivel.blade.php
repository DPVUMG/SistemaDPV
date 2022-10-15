<form method="post" action="{{ route('nivel.store') }}" autocomplete="off" class="form-horizontal">
    @csrf
    @method('post')
    <div class="card">
        <div class="card-header card-header-success">
            <h4 class="card-title">{{ __('Nuevo nivel') }}</h4>
            <p class="card-category">{{ __('Registrar un nuevo nivel en el sistema') }}</p>
        </div>
        <div class="card-body ">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="form-group{{ $errors->has('codigo') ? ' has-danger' : '' }}">
                        <label for="codigo">Código</label>
                        <input class="form-control{{ $errors->has('codigo') ? ' is-invalid' : '' }}" name="codigo"
                            id="input-codigo" type="text" placeholder="{{ __('código del nivel') }}"
                            value="{{ old('codigo') }}" aria-required="true" />
                        @if ($errors->has('codigo'))
                        <span id="codigo-error" class="error text-danger" for="input-codigo">{{
                            $errors->first('codigo') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                        <label for="nombre">Nombre</label>
                        <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre"
                            id="input-nombre" type="text" placeholder="{{ __('nombre del nivel') }}"
                            value="{{ old('nombre') }}" aria-required="true" />
                        @if ($errors->has('nombre'))
                        <span id="nombre-error" class="error text-danger" for="input-nombre">{{
                            $errors->first('nombre') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer ml-auto mr-auto">
            <a rel="tooltip" class="btn btn-flat btn-md btn-danger" href="{{ route('nivel.index') }}"
                data-toggle="tooltip" data-placement="top" title="Cancelar">
                <i class="material-icons">block</i> Cancelar
                <div class="ripple-container"></div>
            </a>
            <button rel="tooltip" type="submit" class="btn btn-flat btn-md btn-success" data-toggle="tooltip"
                data-placement="top" title="Guardar información">
                <i class="material-icons">add_box</i> Guardar
            </button>
        </div>
    </div>
</form>