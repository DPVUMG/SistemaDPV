@extends('layouts.app')
@section('title', 'Crear Escuela')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('sistema.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Crear Escuela</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form id="formEscuela" method="post" action="{{ route('escuela.store') }}" autocomplete="off"
                    class="form-horizontal " enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="card"
                        style="background-image: url('{{ asset('image/escuela/escuela_header_card.jpg') }}'); background-size: cover;">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Nueva Escuela</h4>
                            <p class="category">Formulario para crear una nueva escuela</p>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <p>NOTA: Todos los campos que cuenta
                                    con el simbolo <b class="text-danger">*</b> son obligatorios.</p>
                            </div>
                            <div class="row jumbotron">
                                <div class="col-md-12">
                                    @include('sistema.escuela.tabs.form_create_escuela', [
                                    'municipios' => $municipios,
                                    'sectores' => $sectores,
                                    'areas' => $areas,
                                    'jornadas' => $jornadas
                                    ])
                                </div>
                                <div class="col-md-7">
                                    @include('sistema.escuela.tabs.form_create_codigos', [
                                    'niveles' => $niveles
                                    ])
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @include('sistema.escuela.tabs.form_create_director')
                                        </div>
                                        <div class="col-md-12">
                                            @include('sistema.escuela.tabs.form_create_supervisor')
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                            <div class="card">
                                                <div class="card-header card-header-text card-header-primary">
                                                    <div class="card-text">
                                                        <h4 class="card-title">Usuario</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        @include('sistema.global.form_create_usuario', [
                                                        'municipios' => $municipios,
                                                        'escuelas' => null,
                                                        'escuela_usuario' => null
                                                        ])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a rel="tooltip" class="btn btn-danger" href="{{ route('escuela.create') }}"
                                data-toggle="tooltip" data-placement="top" title="Cancelar">
                                <img class="img" src="{{ asset('image/ico_borrador.png') }}" width="20px">
                                Cancelar
                            </a>
                            <button rel="tooltip" id="btnFormEscuela" class="btn btn-success" data-toggle="tooltip"
                                data-placement="top" title="Guardar información">
                                <img class="img" src="{{ asset('image/ico_guardar.png') }}" width="20px">
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@once
@push('js')
<script type="text/javascript">
    $(document).ready(function () {
        let respuesta = @json($respuesta)

        if(respuesta) {
            Swal.fire({
                title: '<strong>Escuela Nueva</strong>',
                icon: 'success',
                html: respuesta,
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

        $('#formEscuela').validate({ // initialize the plugin
            rules: {

                /* ESCUELA */
                logo: {
                    required: true,
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

                /* DIRECTOR */
                director: {
                    required: true,
                    maxlength: 75
                },
                director_telefono: {
                    digits: true,
                    minlength: 8,
                    maxlength: 8
                },

                /* SUPERVISOR */
                supervisor_id: {
                    required: true,
                    digits: true
                },

                /* PERSONA */
                cui_persona: {
                    digits: true,
                    minlength: 13,
                    maxlength: 13
                },
                nombre_persona: {
                    required: true,
                    maxlength: 75
                },
                apellido_persona: {
                    required: true,
                    maxlength: 75
                },
                telefono_persona: {
                    digits: true,
                    minlength: 8,
                    maxlength: 8
                },
                correo_electronico_persona: {
                    required: true,
                    email: true,
                    maxlength: 75
                },
                municipio_id_persona: {
                    required: true,
                    digits: true
                },
                direccion_persona: {
                    maxlength: 200
                },
                avatar_persona: {
                    required: true,
                    extension: "jpeg|png|jpg"
                },
                usuario: {
                    required: true,
                    maxlength: 15
                },
                password: {
                    required: true,
                    minlength: 4
                },
            }
        });     

        $('.solo-numero').keyup(function () {
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });
});

$("#btnFormEscuela").on( "click", function(e) {
    e.preventDefault();

    var expresion = /^\D*\d{2}-\D*\d{2}-\D*\d{4}-\D*\d{2}$/
    var mensaje = '';

    jQuery("input[name='codigo[]']").each(function() {
        if(this.value != '' && this.value != null) {
            let cumple = this.value.split('-')
            let id = this.id.split('-')

            if(cumple.length > 3) {
                if(cumple[3] == id[1]) {
                    if(!expresion.test(this.value)) {
                        mensaje += ` ${id[0]}: ${this.value} <br><br>`;
                    }
                } else {
                    mensaje += ` ${id[0]}: ${this.value} <br><br>`;
                }
            } else {
                mensaje += ` ${id[0]}: ${this.value} <br><br>`;
            }
        }
    });

    if(mensaje != '') {
        Swal.fire({
            title: 'Código Inválido',
            icon: 'error',
            html: `Los códigos: <br><br> ${mensaje} son <b>inválidos</b> el formato correcto es (00-00-0000-00) y cada código tiene que pertenecer al nivel.`,
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
        return
    }

    if($('#formEscuela').valid()) {
        Swal.fire({
            title: '¿Guardar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'SI',
            cancelButtonText: 'NO'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#formEscuela`).first().submit();
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
@endonce