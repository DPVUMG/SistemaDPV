<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="table-responsive">
            <table id="dataTableCodigos" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center">Código Guía</th>
                        <th rowspan="2" class="text-center">Nombre</th>
                        <th colspan="3" class="text-center">Ingresar Información</th>
                    </tr>
                    <tr>
                        <th class="text-center">Código</th>
                        <th class="text-center">Alumnos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($niveles as $item)
                    <tr>
                        <td class="text-center">
                            <input type="hidden" id="input-nivel_id" name="nivel_id[]" value="{{ $item->id }}" readonly>
                            {{ $item->codigo }}
                        </td>
                        <td class="text-left">{{ $item->nombre }}</td>
                        <td class="text-center">
                            <div class="form-group{{ $errors->has('codigo') ? ' has-danger' : '' }}">
                                <label for="codigo">Código</label>
                                <input class="form-control{{ $errors->has('codigo') ? ' is-invalid' : '' }}"
                                    name="codigo[]" id="{{ " {$item->nombre}-{$item->codigo}" }}" type="text"
                                placeholder="{{
                                __('00-00-0000-00') }}"
                                value="{{ old('codigo') }}" aria-required="true" />
                                @if ($errors->has('codigo'))
                                <span id="codigo-error" class="error text-danger" for="{{ "
                                    {$item->nombre}-{$item->codigo}"
                                    }}">{{
                                    $errors->first('codigo') }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-group{{ $errors->has('cantidad_alumno') ? ' has-danger' : '' }}">
                                <label for="cantidad_alumno">Cantidad</label>
                                <input
                                    class="form-control{{ $errors->has('cantidad_alumno') ? ' is-invalid' : '' }} solo-numero"
                                    name="cantidad_alumno[]" id="input-cantidad_alumno" type="text"
                                    placeholder="{{ __('cantidad de alumnos') }}" value="{{ old('cantidad_alumno') }}"
                                    aria-required="true" />
                                @if ($errors->has('cantidad_alumno'))
                                <span id="cantidad_alumno-error" class="error text-danger"
                                    for="input-cantidad_alumno">{{
                                    $errors->first('cantidad_alumno') }}</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>