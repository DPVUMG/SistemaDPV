<div class="wrapper ">
    @include('layouts.navbars.sidebar')
    <div class="main-panel">
        @include('layouts.navbars.navs.auth')
        @yield('content')
        @include('layouts.footers.auth')
    </div>
</div>
@once
@push('js')
<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

  function fileValidation(etiquetaPreview = 'imagePreview', etiquetaInput = 'input-logotipo', tamanio = '350px') {
      var fileInput = document.getElementById(etiquetaInput);
      var filePath = fileInput.value;
      var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
      if(!allowedExtensions.exec(filePath))
      {
          Swal.fire({
          type: 'error',
          title: 'Oops...',
          text: 'Solo se permiten imagenes en formato .jpeg/.jpg/.png',
          })
          fileInput.value = '';
          document.getElementById(etiquetaPreview).innerHTML = '';
          return false;
      }else{
          //Image preview
          if (fileInput.files && fileInput.files[0]) {
              var reader = new FileReader();
              reader.onload = function(e) {
                  document.getElementById(etiquetaPreview).innerHTML = `<img width="${tamanio}" class="img" src="${e.target.result}"/>`;
              };
              reader.readAsDataURL(fileInput.files[0]);
          }
      }
  }

  function cargarListSupervisores() {
    $.ajax({
        url:"{{route('catalogo_escuela.supervisor')}}",
        method: 'GET',
        success: function(data) {
            $('select[name="supervisor_id"]').empty();
            $('select[name="supervisor_id"]').append(`<option value="">Seleccionar uno porfavor</option>`);
            $.each(data, function(key, value) {
            $('select[name="supervisor_id"]').append(`<option value="${value.id}" {{ ('${value.id}' == old('supervisor_id')) ? 'selected' : '' }}>${value.supervisor}</option>`).selectpicker('refresh');
            });
        }
    });
  }

  function cargarListNiveles() {
    $.ajax({
        url:"{{route('catalogo_escuela.nivel')}}",
        method: 'GET',
        success: function(data) {
            $('select[name="nivel_id"]').empty();
            $('select[name="nivel_id"]').append(`<option value="">Seleccionar uno porfavor</option>`);
            $.each(data, function(key, value) {
            $('select[name="nivel_id"]').append(`<option value="${value.id}" {{ ('${value.id}' == old('nivel_id')) ? 'selected' : '' }}>${value.nivel}</option>`).selectpicker('refresh');
            });
        }
    });
  }

  function cargarListCodigosEscuelas(escuela = 0) {
    if(escuela > 0) {
        var url = "{{ route('catalogo_escuela.escuela_codigos', ':escuela') }}";

        $.ajax({
        url: url.replace(':escuela', escuela),
        method: 'GET',
        success: function(data) {
        $('select[name="escuela_codigo_id"]').empty();
        $('select[name="escuela_codigo_id"]').append(`<option value="">Seleccionar uno porfavor</option>`);
        $.each(data, function(key, value) {
        $('select[name="escuela_codigo_id"]').append(`<option value="${value.id}" {{ ('${value.id}'==old('escuela_codigo_id'))
            ? 'selected' : '' }}>${value.codigo}</option>`).selectpicker('refresh');
        });
        }
        });
    }
  }

  function cargarListPreciosProductos(cargar = false) {
    if(cargar) {
        $.ajax({
            url: "{{route('producto_variante.index')}}",
            method: 'GET',
            success: function(data) {
                $('select[name="producto_variante_id"]').empty();
                $('select[name="producto_variante_id"]').append(`<option value="">Seleccionar uno porfavor</option>`);
                $.each(data.productos, function(key, producto) {
                    let append = `<optgroup label="${producto.producto}">`
                    $.each(data.precios, function(key, precio) {
                        if(producto.id == precio.producto_id) {
                            append += `<option value="${precio.id}" data-subtext="${precio.producto}">${producto.producto} ${precio.producto} ${precio.precio}</option>`
                        }
                    }) 
                    append += '</optgroup>';
                    $('select[name="producto_variante_id"]').append(append).selectpicker('refresh');
                });
            }
        });
    }
  }

  function cargarListEscuelas(cargar = false, masivo = false) {
    if(cargar) {
        let tag = masivo ? 'escuela_id[]' : 'escuela_id';
        $.ajax({
            url: "{{route('catalogo_escuela.escuelas')}}",
            method: 'GET',
            success: function(data) {
                $(`select[name="${tag}"]`).empty();
                if(!masivo) {
                    $(`select[name="${tag}"]`).append(`<option value="">Seleccionar uno porfavor</option>`);
                }
                $.each(data, function(key, value) {
                    $(`select[name="${tag}"]`).append(`<option value="${value.id}">${value.establecimiento}</option>`).selectpicker('refresh');
                });
            }
        });
    }
  }

  $(document).ready(function() {
    cargarListSupervisores();
    cargarListNiveles();

    $('#dataTableCodigos').DataTable({    
      serverSide: false,
      paging: false,
      autoWidth: true,
      processing: true,
      ordering: false,
      info: true,
      searching: false,
      responsive: true,
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json',
      }
    });

    $('.dataTableSimple').DataTable({    
      serverSide: false,
      paging: true,
      autoWidth: true,
      processing: true,
      ordering: false,
      info: true,
      searching: false,
      responsive: true,
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json',
      }
    });

    $(".btnStatus").on( "click", function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Cambiar estado?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'SI',
            cancelButtonText: 'NO'
            }).then((result) => {
            if (result.isConfirmed) {
                let id = $(this).attr('id').split("-");
                $(`#formStatus${id[1]}`).first().submit();
            }
        })
    });

    $(".btnDelete").on( "click", function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'SI',
            cancelButtonText: 'NO'
            }).then((result) => {
            if (result.isConfirmed) {
                let id = $(this).attr('id').split("-");
                $(`#formDelete${id[1]}`).first().submit();
            }
        })
    });

    $(".departamentalInput" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url:"{{route('catalogo_escuela.departamental')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            $('.departamentalInput').val(ui.item.label); 
            return false;
        }
    });
    $(".departamentalInputModal" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url:"{{route('catalogo_escuela.departamental')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            $('.departamentalInput').val(ui.item.label); 
            return false;
        }
    });
    $(".distritoInput" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url:"{{route('catalogo_escuela.distrito')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            $('.distritoInput').val(ui.item.label); 
            return false;
        }
    });
    $(".distritoInputModal" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url:"{{route('catalogo_escuela.distrito')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            $('.distritoInputModal').val(ui.item.label); 
            return false;
        }
    });
    $(".planInput" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url:"{{route('catalogo_escuela.plan')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            $('.planInput').val(ui.item.label); 
            return false;
        }
    });
    $(".directorInput" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url:"{{route('catalogo_escuela.director')}}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            let director = $(this).attr('id').split("-");
            $('.directorInput').val(ui.item.label);
            if(director.length > 2) {
              $(`#input-${director[2]}_telefono`).val(ui.item.telefono);
            } else {
              $(`#input-telefono`).val(ui.item.telefono);
            }
            return false;
        }
    });

    $('.solo-numero').keyup(function () {
        this.value = (this.value + '').replace(/[^0-9]/g, '');
    });
  });
</script>
@endpush
@endonce