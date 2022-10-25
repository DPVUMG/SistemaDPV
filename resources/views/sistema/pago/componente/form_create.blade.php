<form method="post" action="{{ route('pago.store') }}" autocomplete="off" class="form-horizontal">
    @method('post')
    @csrf
    <div class="card">
        <div class="card-header card-header-success">
            <h4 class="card-title">{{ __('Nuevo pago') }}</h4>
            <p class="card-category">{{ "Registrar un nuevo pago en el sistema" }}</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="form-group{{ $errors->has('numero_cheque') ? ' has-danger' : '' }}">
                        <label for="numero_cheque">Número Cheque</label>
                        <input class="form-control{{ $errors->has('numero_cheque') ? ' is-invalid' : '' }}"
                            name="numero_cheque" id="input-numero_cheque" type="text"
                            placeholder="{{ __('numero_cheque') }}" aria-required="true" />
                        @if ($errors->has('numero_cheque'))
                        <span id="numero_cheque-error" class="error text-danger" for="input-numero_cheque">{{
                            $errors->first('numero_cheque') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group{{ $errors->has('banco_id') ? ' has-danger' : '' }}">
                        <label for="banco_id"><span class="text-danger">*</span> Banco</label>
                        <select data-live-search="true" data-style="btn-default"
                            class="selectpicker form-control-plaintext form-control-sm {{ $errors->has('banco_id') ? ' is-invalid' : '' }}"
                            name="banco_id" id="input-banco_id">
                            @foreach ($bancos as $item)
                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('banco_id'))
                        <span id="banco_id-error" class="error text-danger" for="input-banco_id">{{
                            $errors->first('banco_id') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="form-group{{ $errors->has('monto') ? ' has-danger' : '' }}">
                        <label for="monto">Monto</label>
                        <input class="form-control{{ $errors->has('monto') ? ' is-invalid' : '' }}" name="monto"
                            id="input-monto" type="text" min="0" placeholder="{{ __('monto Q.') }}"
                            aria-required="true" />
                        @if ($errors->has('monto'))
                        <span id="monto-error" class="error text-danger" for="input-monto">{{
                            $errors->first('monto') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="form-group{{ $errors->has('escuela_pedido_id[]') ? ' has-danger' : '' }}">
                        <label for="escuela_pedido_id[]"><span class="text-danger">*</span> Pedidos</label>
                        <select data-live-search="true" multiple data-selected-text-format="count > 5"
                            data-header="Seleccionar uno a más" data-actions-box="true" title="Seleccionar uno a más"
                            class="selectpicker show-tick form-control-plaintext form-control-sm {{ $errors->has('escuela_pedido_id[]') ? ' is-invalid' : '' }}"
                            name="escuela_pedido_id[]" id="input-escuela_pedido_id[]">
                            @foreach ($pedidos as $item)
                            <option value="{{ $item->id }}" data-subtext="{{ $item->escuela }}">{{ $item->pedido }}
                            </option>
                            @endforeach
                        </select>
                        @if ($errors->has('escuela_pedido_id[]'))
                        <span id="escuela_pedido_id[]-error" class="error text-danger"
                            for="input-escuela_pedido_id[]">{{
                            $errors->first('escuela_pedido_id[]') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer ml-auto mr-auto">
            <a rel="tooltip" class="btn btn-flat btn-md btn-danger" href="{{ route('pago.index') }}"
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