<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="row">
            <div class="col-sm-12 col-md-10">
                <div class="form-group{{ $errors->has('supervisor_id') ? ' has-danger' : '' }}">
                    <label class="control-label" for="supervisor_id">Supervisor</label>
                    <select data-live-search="true" data-style="btn-info"
                        class="selectpicker form-control-plaintext form-control-sm {{ $errors->has('supervisor_id') ? ' is-invalid' : '' }}"
                        name="supervisor_id" id="input-supervisor_id">
                    </select>
                    @if ($errors->has('supervisor_id'))
                    <span id="supervisor_id-error" class="error text-danger" for="input-supervisor_id">{{
                        $errors->first('supervisor_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 col-md-1">
                <br>
                <a href="{{ route('supervisor.index') }}" title="Agregar uno nuevo" target="_blank"
                    rel="noopener noreferrer">
                    <img class="img" src="{{ asset('image/ico_agregar.png') }}" width="28px" alt="Agregar">
                </a>
            </div>
            <div class="col-sm-12 col-md-1">
                <br>
                <a href="#" onclick="cargarListSupervisores()" title="Buscar supervisores">
                    <img class="img" src="{{ asset('image/ico_buscar.png') }}" width="28px" alt="Buscar">
                </a>
            </div>
        </div>
    </div>
</div>