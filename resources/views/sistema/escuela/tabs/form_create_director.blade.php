<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="form-group{{ $errors->has('director') ? ' has-danger' : '' }}">
                    <label for="director"><span class="text-danger">*</span> Director</label>
                    <input class="form-control{{ $errors->has('director') ? ' is-invalid' : '' }} directorInput"
                        name="director" id="input-director-director" type="text"
                        placeholder="{{ __('nombre del director') }}" value="{{ old('director') }}"
                        aria-required="true" />
                    @if ($errors->has('director'))
                    <span id="director-error" class="error text-danger" for="input-director">{{
                        $errors->first('director') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group{{ $errors->has('director_telefono') ? ' has-danger' : '' }}">
                    <label for="director_telefono">Teléfono</label>
                    <input class="form-control{{ $errors->has('director_telefono') ? ' is-invalid' : '' }}"
                        name="director_telefono" id="input-director_telefono" type="text"
                        placeholder="{{ __('teléfono del director') }}" value="{{ old('director_telefono') }}"
                        aria-required="true" />
                    @if ($errors->has('director_telefono'))
                    <span id="director_telefono-error" class="error text-danger" for="input-director_telefono">{{
                        $errors->first('director_telefono') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>