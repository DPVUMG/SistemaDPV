<div class="card">
    <div class="card-header card-header-info">
        <div class="card-icon">
            <i class="material-icons">
                <img src="{{ asset('image/ico_calendario.png') }}" title="Calendario" width="50px" height="50px"
                    alt="Calendario">
            </i>
        </div>
        <h1 class="card-title">Pendientes de Entrega</h1>
    </div>
    <div class="card-body">
        <div id='full_calendar_events'></div>
    </div>
</div>
@push('js')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendar = $('#full_calendar_events').fullCalendar({
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: false,
            events: "{{route('sistema.home')}}",
            displayEventTime: false,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            eventClick: function (event) {
                if(event) {

                    console.log(event)
                    var show = "{{ route('escuela_pedido.show', ':id') }}";
                    var event_start = $.fullCalendar.formatDate(event.start, "DD-MM-YYYY");
                    var event_end = $.fullCalendar.formatDate(event.end, "DD-MM-YYYY");

                    Swal.fire({
                        title: event.title,
                        icon: 'success',
                        html:
                        `<p>El pedido fue creado el ${event_start} y la fecha de entrega es ${event_end}</p>
                        <h4 class="card-title">
                            <ul class="list-group list-group-flush text-nowrap">
                                <li class="list-group-item">
                                    <small class="text-left"><b>Sub Total Q</b></small>
                                    <p class="display-4" id="sub_total">
                                        ${event.sub_total}
                                    </p>
                                </li>
                                <li class="list-group-item">
                                    <small class="text-left"><b>Descuento Q</b></small>
                                    <p class="display-4" id="descuento">
                                        ${event.descuento}
                                    </p>
                                </li>
                                <li class="list-group-item">
                                    <small class="text-left"><b>Total Q</b></small>
                                    <p class="display-4" id="total">
                                        ${event.total}
                                    </p>
                                </li>
                            </ul>
                        </h4>`,
                        footer:
                        `<a href="${show.replace(':id', event.id)}" class="btn btn-link btn-outline-info" target="_blank"
                            rel="noopener noreferrer">
                            Detalle del Pedido
                        </a>`,
                        showCloseButton: true,
                        showCancelButton: true,
                        showConfirmButton: true,
                        customClass: {
                            cancelButton: 'btn btn-primary',
                            confirmButton: 'btn btn-success'
                        },
                        buttonsStyling: false,
                        reverseButtons: true,
                        cancelButtonText: 'Regresar Pedido a Ingresado',
                        confirmButtonText: 'Entregar Pedido',
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
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var isConfirmed = "{{ route('escuela_pedido.entregado', ':escuela_pedido') }}";

                            $.ajax({
                                url: isConfirmed.replace(':escuela_pedido', event.id),
                                type: "GET",
                                success: function(data){
                                    if(data.estado == 200) {
                                        calendar.fullCalendar('removeEvents', event.id);
                                        Swal.fire({
                                            title: '¡Entregado!',
                                            icon: 'success',
                                            text: data.mensaje,
                                            showCloseButton: false,
                                            showCancelButton: false,
                                            showConfirmButton: true,
                                            confirmButtonText: 'Recargar Página',
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
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.reload();
                                            }
                                        })
                                    } else if(data.estado == 201) {
                                        Swal.fire(
                                            '¡Entregado!',
                                            data.mensaje,
                                            'warning'
                                        )
                                    }
                                },
                                error: function(data){
                                    var errors = data.responseJSON;
                                    Swal.fire(
                                        '¡Error!',
                                        errors.message?? errors,
                                        'error'
                                    )
                                }
                            });
                        } else if(result.dismiss === Swal.DismissReason.cancel) {
                            var dismiss = "{{ route('escuela_pedido.ingresado', ':escuela_pedido') }}";

                            $.ajax({
                                url: dismiss.replace(':escuela_pedido', event.id),
                                type: "GET",
                                success: function(data){
                                    if(data.estado == 200) {
                                        calendar.fullCalendar('removeEvents', event.id);
                                        Swal.fire({
                                            title: '¡Regreso a Ingresado!',
                                            icon: 'success',
                                            text: data.mensaje,
                                            showCloseButton: false,
                                            showCancelButton: false,
                                            showConfirmButton: true,
                                            confirmButtonText: 'Recargar Página',
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
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.reload();
                                            }
                                        })
                                    } else if(data.estado == 201) {
                                        Swal.fire(
                                            '¡Regreso a Ingresado!',
                                            data.mensaje,
                                            'warning'
                                        )
                                    }
                                },
                                error: function(data){
                                    var errors = data.responseJSON;
                                    Swal.fire(
                                        '¡Error!',
                                        errors.message?? errors,
                                        'error'
                                    )
                                }
                            });
                        }
                    })
                }
            }
        });
    });
</script>
@endpush
