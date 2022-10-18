<div class="card"
    style="background-image: url('{{ asset('image/escuela/escuela_header_card.jpg') }}'); background-size: cover;">
    <div class="card-header card-header-warning card-header-icon">
        <div class="card-text">
            <img src="{{ is_null($escuela->getPictureAttribute()) ? asset('image/escuela/escuela_default.png') : $escuela->getPictureAttribute() }}"
                class="my-auto" height="40px" alt="Escuela">
            <p class="card-category">Editar Escuela</p>
            <h3 class="card-title">{{ $escuela->establecimiento }}</h3>
            <h1 class="card-title"># {{ $escuela->id }}</h1>
        </div>
    </div>
    <div class="card-body">
        <form id="formEscuelaEdit" method="post" action="{{ route('escuela.update', $escuela) }}" autocomplete="off"
            class="form-horizontal jumbotron" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-sm-12 col-md-3 text-center">
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail img-raised" style="height: 230px; border: solid;">
                        </div>
                        <div class="fileinput-exists thumbnail img-raised" style="border: solid;">
                            <div id="imagePreview"></div>
                        </div>
                        <div>
                            <span class="btn btn-raised btn-round btn-rose btn-file">
                                <span class="fileinput-new">Seleccionar logotipo</span>
                                <span class="fileinput-exists">Seleccionar logotipo</span>
                                <input type="file" onchange="return fileValidation()" name="logo" id="input-logotipo" />
                            </span>
                            <a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput">
                                Limpiar
                            </a>
                        </div>
                    </div>
                    @if ($errors->has('logo'))
                    <br>
                    <span id="logo-error" class="error text-danger" for="input-logo">{{
                        $errors->first('logo') }}</span>
                    @endif
                </div>
                <div class="col-sm-12 col-md-9">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group{{ $errors->has('nit') ? ' has-danger' : '' }}">
                                <label for="nit"><span class="text-danger">*</span> NIT</label>
                                <input class="form-control{{ $errors->has('nit') ? ' is-invalid' : '' }}" name="nit"
                                    id="input-nit" type="text" placeholder="{{ __('número de NIT') }}"
                                    value="{{ old('nit', $escuela->nit) }}" aria-required="true" />
                                @if ($errors->has('nit'))
                                <span id="nit-error" class="error text-danger" for="input-nit">{{
                                    $errors->first('nit') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-9">
                            <div class="form-group{{ $errors->has('establecimiento') ? ' has-danger' : '' }}">
                                <label for="establecimiento"><span class="text-danger">*</span> Nombre</label>
                                <input class="form-control{{ $errors->has('establecimiento') ? ' is-invalid' : '' }}"
                                    name="establecimiento" id="input-establecimiento" type="text"
                                    placeholder="{{ __('nombre del establecimiento') }}"
                                    value="{{ old('establecimiento', $escuela->establecimiento) }}"
                                    aria-required="true" />
                                @if ($errors->has('establecimiento'))
                                <span id="establecimiento-error" class="error text-danger"
                                    for="input-establecimiento">{{
                                    $errors->first('establecimiento') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group{{ $errors->has('telefono') ? ' has-danger' : '' }}">
                                <label for="telefono">Teléfono</label>
                                <input class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}"
                                    name="telefono" id="input-telefono" type="text"
                                    placeholder="{{ __('escribir el teléfono') }}"
                                    value="{{ old('telefono', $escuela->telefono) }}" aria-required="true" />
                                @if ($errors->has('telefono'))
                                <span id="telefono-error" class="error text-danger" for="input-telefono">{{
                                    $errors->first('telefono') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <div class="form-group{{ $errors->has('municipio_id') ? ' has-danger' : '' }}">
                                <label for="municipio_id"><span class="text-danger">*</span> Departamento y
                                    Municipio</label>
                                <select data-live-search="true" data-style="btn-info"
                                    class="selectpicker form-control-plaintext form-control-sm {{ $errors->has('municipio_id') ? ' is-invalid' : '' }}"
                                    name="municipio_id" id="input-municipio_id">
                                    <option value="">Seleccionar uno porfavor</option>
                                    @foreach ($municipios as $item)
                                    <option value="{{ $item->id }}" {{ ($item->id == old('municipio_id',
                                        $escuela->municipio_id)) ?
                                        'selected' : '' }}>{{ $item->getFullNameAttribute() }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('municipio_id'))
                                <span id="municipio_id-error" class="error text-danger" for="input-municipio_id">{{
                                    $errors->first('municipio_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="form-group{{ $errors->has('direccion') ? ' has-danger' : '' }}">
                                <label for="direccion">Dirección</label>
                                <input class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}"
                                    name="direccion" id="input-direccion" type="text"
                                    placeholder="{{ __('escribir la dirección') }}"
                                    value="{{ old('direccion', $escuela->direccion) }}" aria-required="true" />
                                @if ($errors->has('direccion'))
                                <span id="direccion-error" class="error text-danger" for="input-direccion">{{
                                    $errors->first('direccion') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group{{ $errors->has('sector') ? ' has-danger' : '' }}">
                                <label for="sector"><span class="text-danger">*</span> Sector</label>
                                <select data-live-search="true" data-style="btn-default"
                                    class="selectpicker form-control-plaintext form-control-sm {{ $errors->has('sector') ? ' is-invalid' : '' }}"
                                    name="sector" id="input-sector">
                                    <option value="">Seleccionar uno porfavor</option>
                                    @foreach ($sectores as $item)
                                    <option value="{{ $item }}" {{ ($item==old('sector', $escuela->sector)) ?
                                        'selected'
                                        : ''
                                        }}>{{
                                        $item }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('sector'))
                                <span id="sector-error" class="error text-danger" for="input-sector">{{
                                    $errors->first('sector') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group{{ $errors->has('area') ? ' has-danger' : '' }}">
                                <label for="area"><span class="text-danger">*</span> Área</label>
                                <select data-live-search="true" data-style="btn-default"
                                    class="selectpicker form-control-plaintext form-control-sm {{ $errors->has('area') ? ' is-invalid' : '' }}"
                                    name="area" id="input-area">
                                    <option value="">Seleccionar uno porfavor</option>
                                    @foreach ($areas as $item)
                                    <option value="{{ $item }}" {{ ($item==old('area', $escuela->area)) ? 'selected'
                                        :
                                        '' }}>{{
                                        $item }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('area'))
                                <span id="area-error" class="error text-danger" for="input-area">{{
                                    $errors->first('area') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group{{ $errors->has('jornada') ? ' has-danger' : '' }}">
                                <label for="jornada"><span class="text-danger">*</span> Jornada</label>
                                <select data-live-search="true" data-style="btn-default"
                                    class="selectpicker form-control-plaintext form-control-sm {{ $errors->has('jornada') ? ' is-invalid' : '' }}"
                                    name="jornada" id="input-jornada">
                                    <option value="">Seleccionar uno porfavor</option>
                                    @foreach ($jornadas as $item)
                                    <option value="{{ $item }}" {{ ($item==old('jornada', $escuela->jornada)) ?
                                        'selected' : ''
                                        }}>{{
                                        $item }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('jornada'))
                                <span id="jornada-error" class="error text-danger" for="input-jornada">{{
                                    $errors->first('jornada') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group{{ $errors->has('plan') ? ' has-danger' : '' }}">
                                <label for="plan"><span class="text-danger">*</span> Plan</label>
                                <input class="form-control{{ $errors->has('plan') ? ' is-invalid' : '' }} planInput"
                                    name="plan" id="input-plan" type="text" placeholder="{{ __('escribir el plan') }}"
                                    value="{{ old('plan', $escuela->plan) }}" aria-required="true" />
                                @if ($errors->has('plan'))
                                <span id="plan-error" class="error text-danger" for="input-plan">{{
                                    $errors->first('plan') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group{{ $errors->has('departamental_id') ? ' has-danger' : '' }}">
                                <label for="departamental_id"><span class="text-danger">*</span>
                                    Departamental</label>
                                <input
                                    class="form-control{{ $errors->has('departamental_id') ? ' is-invalid' : '' }} departamentalInput"
                                    name="departamental_id" id="input-departamental_id" type="text"
                                    placeholder="{{ __('escribir la departamental') }}"
                                    value="{{ old('departamental_id', $escuela->departamental->nombre) }}"
                                    aria-required="true" />
                                @if ($errors->has('departamental_id'))
                                <span id="departamental_id-error" class="error text-danger"
                                    for="input-departamental_id">{{
                                    $errors->first('departamental_id') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <a rel="tooltip" class="btn btn-danger" href="{{ route('escuela.edit', $escuela) }}" data-toggle="tooltip"
            data-placement="top" title="Cancelar">
            <img class="img" src="{{ asset('image/ico_borrador.png') }}" width="20px">
            Cancelar
        </a>
        <button rel="tooltip" id="btnFormEscuelaEdit" class="btn btn-success" data-toggle="tooltip" data-placement="top"
            title="Guardar información">
            <img class="img" src="{{ asset('image/ico_editar.png') }}" width="20px">
            Modificar
        </button>
    </div>
</div>

@push('js')
<script type="text/javascript">
    $(document).ready(function () {
        $('#formEscuelaEdit').validate({ // initialize the plugin
            rules: {
                /* ESCUELA */
                logo: {
                    required: false,
                    extension: "jpeg|png|jpg"
                },
                nit: {
                    required: true,
                    digits: true,
                    minlength: 5,
                    maxlength: 12
                },
                establecimiento: {
                    required: true,
                    maxlength: 200
                },
                telefono: {
                    digits: true,
                    minlength: 8,
                    maxlength: 8
                },
                municipio_id: {
                    required: true,
                    digits: true
                },
                direccion: {
                    maxlength: 200
                },
                sector: {
                    required: true
                },
                area: {
                    required: true
                },
                jornada: {
                    required: true
                },
                plan: {
                    required: true,
                    maxlength: 75
                },
                departamental_id: {
                    required: true,
                    maxlength: 35
                },
            }
        });
});

$("#btnFormEscuelaEdit").on( "click", function(e) {
    e.preventDefault();

    if($('#formEscuelaEdit').valid()) {
        Swal.fire({
            title: '¿Editar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'SI',
            cancelButtonText: 'NO'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#formEscuelaEdit`).first().submit();
            }
        })
    } else {
        Swal.fire({
            title: 'Validación',
            icon: 'error',
            text: 'Revisar el formularion, hay campos que son necesarios de validar.',
            allowOutsideClick: () => {
                const popup = Swal.getPopup()
                popup.classList.remove('swal2-show')
                setTimeout(() => {
                    popup.classList.add('animate__animated', 'animate__headShake')
                })
                setTimeout(() => {
                    popup.classList.remove('animate__animated', 'animate__headShake')
                }, 500)
                return false
            }
        })        
    }
});
</script>
@endpush