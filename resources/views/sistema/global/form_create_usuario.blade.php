@if (!is_null($escuela_usuario))
@if (!is_null($escuelas))
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group{{ $errors->has('escuela_id') ? ' has-danger' : '' }}">
            <label for="escuela_id"><span class="text-danger">*</span> Escuela</label>
            <select data-live-search="true" data-style="btn-default"
                class="selectpicker form-control-plaintext form-control-sm {{ $errors->has('escuela_id') ? ' is-invalid' : '' }}"
                name="escuela_id" id="input-escuela_id">
            </select>
            @if ($errors->has('escuela_id'))
            <span id="escuela_id-error" class="error text-danger" for="input-escuela_id">{{
                $errors->first('escuela_id') }}</span>
            @endif
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group{{ $errors->has('cui_persona') ? ' has-danger' : '' }}">
            <label for="cui_persona"><span class="text-danger">*</span> CUI</label>
            <input class="form-control{{ $errors->has('cui_persona') ? ' is-invalid' : '' }}" name="cui_persona"
                id="input-cui_persona" type="text" placeholder="{{ __('número de cui') }}"
                value="{{ old('cui_persona', $escuela_usuario->persona->cui) }}" aria-required="true" />
            @if ($errors->has('cui_persona'))
            <span id="cui_persona-error" class="error text-danger" for="input-cui_persona">{{
                $errors->first('cui_persona') }}</span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group{{ $errors->has('nombre_persona') ? ' has-danger' : '' }}">
            <label for="nombre_persona"><span class="text-danger">*</span> Nombre</label>
            <input class="form-control{{ $errors->has('nombre_persona') ? ' is-invalid' : '' }}" name="nombre_persona"
                id="input-nombre_persona" type="text" placeholder="{{ __('nombre de la persona') }}"
                value="{{ old('nombre_persona', $escuela_usuario->persona->nombre) }}" aria-required="true" />
            @if ($errors->has('nombre_persona'))
            <span id="nombre_persona-error" class="error text-danger" for="input-nombre_persona">{{
                $errors->first('nombre_persona') }}</span>
            @endif
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group{{ $errors->has('apellido_persona') ? ' has-danger' : '' }}">
            <label for="apellido_persona"><span class="text-danger">*</span> Apellido</label>
            <input class="form-control{{ $errors->has('apellido_persona') ? ' is-invalid' : '' }}"
                name="apellido_persona" id="input-apellido_persona" type="text"
                placeholder="{{ __('apellido de la persona') }}"
                value="{{ old('apellido_persona', $escuela_usuario->persona->apellido) }}" aria-required="true" />
            @if ($errors->has('apellido_persona'))
            <span id="apellido_persona-error" class="error text-danger" for="input-apellido_persona">{{
                $errors->first('apellido_persona') }}</span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="form-group{{ $errors->has('telefono_persona') ? ' has-danger' : '' }}">
            <label for="telefono_persona">Teléfono</label>
            <input class="form-control{{ $errors->has('telefono_persona') ? ' is-invalid' : '' }}"
                name="telefono_persona" id="input-telefono_persona" type="text"
                placeholder="{{ __('teléfono de la persona') }}"
                value="{{ old('telefono_persona', $escuela_usuario->persona->telefono) }}" aria-required="true" />
            @if ($errors->has('telefono_persona'))
            <span id="telefono_persona-error" class="error text-danger" for="input-telefono_persona">{{
                $errors->first('telefono_persona') }}</span>
            @endif
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group{{ $errors->has('correo_electronico_persona') ? ' has-danger' : '' }}">
            <label for="correo_electronico_persona">Correo Electrónico</label>
            <input class="form-control{{ $errors->has('correo_electronico_persona') ? ' is-invalid' : '' }}"
                name="correo_electronico_persona" id="input-correo_electronico_persona" type="text"
                placeholder="{{ __('correo electrónico de la persona') }}"
                value="{{ old('correo_electronico_persona', $escuela_usuario->persona->correo_electronico) }}"
                aria-required="true" />
            @if ($errors->has('correo_electronico_persona'))
            <span id="correo_electronico_persona-error" class="error text-danger"
                for="input-correo_electronico_persona">{{
                $errors->first('correo_electronico_persona') }}</span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-5">
        <div class="form-group{{ $errors->has('municipio_id_persona') ? ' has-danger' : '' }}">
            <label for="municipio_id_persona"><span class="text-danger">*</span> Departamento y Municipio</label>
            <select data-live-search="true" data-style="btn-default"
                class="selectpicker form-control-plaintext form-control-sm {{ $errors->has('municipio_id_persona') ? ' is-invalid' : '' }}"
                name="municipio_id_persona" id="input-municipio_id_persona">
                <option value="">Seleccionar uno porfavor</option>
                @foreach ($municipios as $item)
                <option value="{{ $item->id }}" {{ ($item->id == old('municipio_id_persona',
                    $escuela_usuario->persona->municipio_id)) ?
                    'selected' : '' }}>{{ $item->getFullNameAttribute() }}</option>
                @endforeach
            </select>
            @if ($errors->has('municipio_id_persona'))
            <span id="municipio_id_persona-error" class="error text-danger" for="input-municipio_id_persona">{{
                $errors->first('municipio_id_persona') }}</span>
            @endif
        </div>
    </div>
    <div class="col-sm-12 col-md-7">
        <div class="form-group{{ $errors->has('direccion_persona') ? ' has-danger' : '' }}">
            <label for="direccion_persona">Dirección</label>
            <input class="form-control{{ $errors->has('direccion_persona') ? ' is-invalid' : '' }}"
                name="direccion_persona" id="input-direccion_persona" type="text"
                placeholder="{{ __('escribir la dirección') }}"
                value="{{ old('direccion_persona', $escuela_usuario->persona->direccion) }}" aria-required="true" />
            @if ($errors->has('direccion_persona'))
            <span id="direccion_persona-error" class="error text-danger" for="input-direccion_persona">{{
                $errors->first('direccion_persona') }}</span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-6 text-center">
        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
            <div class="fileinput-new thumbnail img-raised" style="height: 230px; border: solid;">
            </div>
            <div class="fileinput-exists thumbnail img-raised" style="border: solid;">
                <div id="imagePreviewPersona"></div>
            </div>
            <div>
                <span class="btn btn-raised btn-round btn-rose btn-file">
                    <span class="fileinput-new">Seleccionar logotipo</span>
                    <span class="fileinput-exists">Seleccionar logotipo</span>
                    <input type="file"
                        onchange="return fileValidation('imagePreviewPersona', 'input-avatar_persona', '50%')"
                        name="avatar_persona" id="input-avatar_persona" />
                </span>
                <a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput">
                    Limpiar
                </a>
            </div>
        </div>
        @if ($errors->has('avatar_persona'))
        <br>
        <span id="avatar_persona-error" class="error text-danger" for="input-avatar_persona">{{
            $errors->first('avatar_persona') }}</span>
        @endif
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="form-group{{ $errors->has('usuario') ? ' has-danger' : '' }}">
                    <label for="usuario"><span class="text-danger">*</span> Usuario</label>
                    <input class="form-control{{ $errors->has('usuario') ? ' is-invalid' : '' }}" name="usuario"
                        id="input-usuario" type="text" placeholder="{{ __('escribir el usuario') }}"
                        value="{{ old('usuario', $escuela_usuario->usuario) }}" aria-required="true" />
                    @if ($errors->has('usuario'))
                    <span id="usuario-error" class="error text-danger" for="input-usuario">{{
                        $errors->first('usuario') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label for="password">Contraseña</label>
                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                        id="input-password" type="password" value="{{ old('password') }}" aria-required="true" />
                    @if ($errors->has('password'))
                    <span id="password-error" class="error text-danger" for="input-password">{{
                        $errors->first('password') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@else
@if (!is_null($escuelas))
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group{{ $errors->has('escuela_id') ? ' has-danger' : '' }}">
            <label for="escuela_id"><span class="text-danger">*</span> Escuela</label>
            <select data-live-search="true" data-style="btn-default"
                class="selectpicker form-control-plaintext form-control-sm {{ $errors->has('escuela_id') ? ' is-invalid' : '' }}"
                name="escuela_id" id="input-escuela_id">
            </select>
            @if ($errors->has('escuela_id'))
            <span id="escuela_id-error" class="error text-danger" for="input-escuela_id">{{
                $errors->first('escuela_id') }}</span>
            @endif
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group{{ $errors->has('cui_persona') ? ' has-danger' : '' }}">
            <label for="cui_persona"><span class="text-danger">*</span> CUI</label>
            <input class="form-control{{ $errors->has('cui_persona') ? ' is-invalid' : '' }}" name="cui_persona"
                id="input-cui_persona" type="text" placeholder="{{ __('número de cui') }}"
                value="{{ old('cui_persona') }}" aria-required="true" />
            @if ($errors->has('cui_persona'))
            <span id="cui_persona-error" class="error text-danger" for="input-cui_persona">{{
                $errors->first('cui_persona') }}</span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group{{ $errors->has('nombre_persona') ? ' has-danger' : '' }}">
            <label for="nombre_persona"><span class="text-danger">*</span> Nombre</label>
            <input class="form-control{{ $errors->has('nombre_persona') ? ' is-invalid' : '' }}" name="nombre_persona"
                id="input-nombre_persona" type="text" placeholder="{{ __('nombre de la persona') }}"
                value="{{ old('nombre_persona') }}" aria-required="true" />
            @if ($errors->has('nombre_persona'))
            <span id="nombre_persona-error" class="error text-danger" for="input-nombre_persona">{{
                $errors->first('nombre_persona') }}</span>
            @endif
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group{{ $errors->has('apellido_persona') ? ' has-danger' : '' }}">
            <label for="apellido_persona"><span class="text-danger">*</span> Apellido</label>
            <input class="form-control{{ $errors->has('apellido_persona') ? ' is-invalid' : '' }}"
                name="apellido_persona" id="input-apellido_persona" type="text"
                placeholder="{{ __('apellido de la persona') }}" value="{{ old('apellido_persona') }}"
                aria-required="true" />
            @if ($errors->has('apellido_persona'))
            <span id="apellido_persona-error" class="error text-danger" for="input-apellido_persona">{{
                $errors->first('apellido_persona') }}</span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="form-group{{ $errors->has('telefono_persona') ? ' has-danger' : '' }}">
            <label for="telefono_persona">Teléfono</label>
            <input class="form-control{{ $errors->has('telefono_persona') ? ' is-invalid' : '' }}"
                name="telefono_persona" id="input-telefono_persona" type="text"
                placeholder="{{ __('teléfono de la persona') }}" value="{{ old('telefono_persona') }}"
                aria-required="true" />
            @if ($errors->has('telefono_persona'))
            <span id="telefono_persona-error" class="error text-danger" for="input-telefono_persona">{{
                $errors->first('telefono_persona') }}</span>
            @endif
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group{{ $errors->has('correo_electronico_persona') ? ' has-danger' : '' }}">
            <label for="correo_electronico_persona">Correo Electrónico</label>
            <input class="form-control{{ $errors->has('correo_electronico_persona') ? ' is-invalid' : '' }}"
                name="correo_electronico_persona" id="input-correo_electronico_persona" type="text"
                placeholder="{{ __('correo electrónico de la persona') }}"
                value="{{ old('correo_electronico_persona') }}" aria-required="true" />
            @if ($errors->has('correo_electronico_persona'))
            <span id="correo_electronico_persona-error" class="error text-danger"
                for="input-correo_electronico_persona">{{
                $errors->first('correo_electronico_persona') }}</span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-5">
        <div class="form-group{{ $errors->has('municipio_id_persona') ? ' has-danger' : '' }}">
            <label for="municipio_id_persona"><span class="text-danger">*</span> Departamento y Municipio</label>
            <select data-live-search="true" data-style="btn-default"
                class="selectpicker form-control-plaintext form-control-sm {{ $errors->has('municipio_id_persona') ? ' is-invalid' : '' }}"
                name="municipio_id_persona" id="input-municipio_id_persona">
                <option value="">Seleccionar uno porfavor</option>
                @foreach ($municipios as $item)
                <option value="{{ $item->id }}" {{ ($item->id == old('municipio_id_persona')) ?
                    'selected' : '' }}>{{ $item->getFullNameAttribute() }}</option>
                @endforeach
            </select>
            @if ($errors->has('municipio_id_persona'))
            <span id="municipio_id_persona-error" class="error text-danger" for="input-municipio_id_persona">{{
                $errors->first('municipio_id_persona') }}</span>
            @endif
        </div>
    </div>
    <div class="col-sm-12 col-md-7">
        <div class="form-group{{ $errors->has('direccion_persona') ? ' has-danger' : '' }}">
            <label for="direccion_persona">Dirección</label>
            <input class="form-control{{ $errors->has('direccion_persona') ? ' is-invalid' : '' }}"
                name="direccion_persona" id="input-direccion_persona" type="text"
                placeholder="{{ __('escribir la dirección') }}" value="{{ old('direccion_persona') }}"
                aria-required="true" />
            @if ($errors->has('direccion_persona'))
            <span id="direccion_persona-error" class="error text-danger" for="input-direccion_persona">{{
                $errors->first('direccion_persona') }}</span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-6 text-center">
        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
            <div class="fileinput-new thumbnail img-raised" style="height: 230px; border: solid;">
            </div>
            <div class="fileinput-exists thumbnail img-raised" style="border: solid;">
                <div id="imagePreviewPersona"></div>
            </div>
            <div>
                <span class="btn btn-raised btn-round btn-rose btn-file">
                    <span class="fileinput-new">Seleccionar logotipo</span>
                    <span class="fileinput-exists">Seleccionar logotipo</span>
                    <input type="file"
                        onchange="return fileValidation('imagePreviewPersona', 'input-avatar_persona', '50%')"
                        name="avatar_persona" id="input-avatar_persona" />
                </span>
                <a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput">
                    Limpiar
                </a>
            </div>
        </div>
        @if ($errors->has('avatar_persona'))
        <br>
        <span id="avatar_persona-error" class="error text-danger" for="input-avatar_persona">{{
            $errors->first('avatar_persona') }}</span>
        @endif
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="form-group{{ $errors->has('usuario') ? ' has-danger' : '' }}">
                    <label for="usuario"><span class="text-danger">*</span> Usuario</label>
                    <input class="form-control{{ $errors->has('usuario') ? ' is-invalid' : '' }}" name="usuario"
                        id="input-usuario" type="text" placeholder="{{ __('escribir el usuario') }}"
                        value="{{ old('usuario') }}" aria-required="true" />
                    @if ($errors->has('usuario'))
                    <span id="usuario-error" class="error text-danger" for="input-usuario">{{
                        $errors->first('usuario') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label for="password"><span class="text-danger">*</span> Contraseña</label>
                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                        id="input-password" type="password" value="{{ old('password') }}" aria-required="true" />
                    @if ($errors->has('password'))
                    <span id="password-error" class="error text-danger" for="input-password">{{
                        $errors->first('password') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@push('js')
<script type="text/javascript">
    $(document).ready(function () {
    if(@json($escuelas)) {
        cargarListEscuelas(true)
    }
});
</script>
@endpush