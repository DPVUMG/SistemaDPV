<!--   Core JS Files   -->
<script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
@toastr_js
@toastr_render
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/cylinder.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="{{ asset('material') }}/js/core/popper.min.js"></script>
<script src="{{ asset('material') }}/js/core/bootstrap-material-design.min.js"></script>
<!-- Plugin for the momentJs  -->
<script src="{{ asset('material') }}/js/plugins/moment.min.js"></script>
<!--  Plugin for Sweet Alert -->
<script src="{{ asset('material') }}/js/plugins/sweetalert2.min.js"></script>
<!-- Forms Validations Plugin -->
<script src="{{ asset('material') }}/js/plugins/jquery.validate.min.js"></script>
<script src="{{ asset('material') }}/js/plugins/additional-methods.min.js"></script>
<!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="{{ asset('material') }}/js/plugins/jquery.bootstrap-wizard.js"></script>
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="{{ asset('material') }}/js/plugins/bootstrap-selectpicker.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://jqueryui.com/ -->
<script src="{{ asset('material') }}/js/jquery-ui/jquery-ui.min.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
<script src="{{ asset('material') }}/js/plugins/jquery.dataTables.min.js"></script>
<script src="{{ asset('material') }}/js/plugins/dataTables.buttons.min.js"></script>
<script src="{{ asset('material') }}/js/plugins/jszip.min.js"></script>
<script src="{{ asset('material') }}/js/plugins/pdfmake.min.js"></script>
<script src="{{ asset('material') }}/js/plugins/vfs_fonts.js"></script>
<script src="{{ asset('material') }}/js/plugins/buttons.html5.min.js"></script>
<script src="{{ asset('material') }}/js/plugins/buttons.print.min.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{{ asset('material') }}/js/plugins/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="{{ asset('material') }}/js/plugins/fullcalendar.min.js"></script>
<script src="{{ asset('material') }}/js/plugins/fullcalendar_es.js"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="{{ asset('material') }}/js/plugins/nouislider.min.js"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="{{ asset('material') }}/js/core/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src="{{ asset('material') }}/js/plugins/arrive.min.js"></script>
<!-- Chartist JS -->
<script src="{{ asset('material') }}/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="{{ asset('material') }}/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('material') }}/js/material-dashboard.js" type="text/javascript"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ asset('material') }}/js/settings.js"></script>
<script>
    $(document).ready( function () {
        $('.dataTable').DataTable({
            serverSide: false,
            paging: true,
            autoWidth: true,
            processing: true,
            ordering: true,
            info: true,
            searching: true,
            responsive: false,        
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json',
            }
        });

        $('.dataTableExport').DataTable({
            serverSide: false,
            paging: true,
            autoWidth: true,
            processing: true,
            ordering: true,
            info: true,
            searching: true,
            responsive: true,        
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json',
            },
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'print'
            ]
        });
        
        $('.selectpicker').selectpicker();
        $( ".datepicker" ).datepicker({
            dateFormat: 'dd-mm-yy',
            maxDate: new Date(),
            closeText: 'Cerrar',
            currentText: 'Hoy' , 
            monthNames: ['Enero', 'Febrero' , 'Marzo' , 'Abril' , 'Mayo'
                , 'Junio' , 'Julio' , 'Agosto' , 'Septiembre' , 'Octubre' , 'Noviembre' , 'Diciembre' ], 
            monthNamesShort:
                ['Ene', 'Feb' , 'Mar' , 'Abr' , 'May' , 'Jun' , 'Jul' , 'Ago' , 'Sep' , 'Oct' , 'Nov' , 'Dic' ], 
            dayNames:
                ['Domingo', 'Lunes' , 'Martes' , 'Miércoles' , 'Jueves' , 'Viernes' , 'Sábado' ], 
            dayNamesShort: ['Dom', 'Lun'
                , 'Mar' , 'Mié' , 'Juv' , 'Vie' , 'Sáb' ], 
            dayNamesMin: ['Do', 'Lu' , 'Ma' , 'Mi' , 'Ju' , 'Vi' , 'Sá' ],
            weekHeader: 'Sm' , 
            firstDay: 1, 
            isRTL: false, 
            showMonthAfterYear: false, 
            yearSuffix: ''
        });
    });

    $( function() {
        var dateFormat = "dd-mm-yy"

        $( "#from" ).datepicker({
            dateFormat: dateFormat,
            maxDate: new Date(),
            closeText: 'Cerrar',
            currentText: 'Hoy' , 
            monthNames: ['Enero', 'Febrero' , 'Marzo' , 'Abril' , 'Mayo'
                , 'Junio' , 'Julio' , 'Agosto' , 'Septiembre' , 'Octubre' , 'Noviembre' , 'Diciembre' ], 
            monthNamesShort:
                ['Ene', 'Feb' , 'Mar' , 'Abr' , 'May' , 'Jun' , 'Jul' , 'Ago' , 'Sep' , 'Oct' , 'Nov' , 'Dic' ], 
            dayNames:
                ['Domingo', 'Lunes' , 'Martes' , 'Miércoles' , 'Jueves' , 'Viernes' , 'Sábado' ], 
            dayNamesShort: ['Dom', 'Lun'
                , 'Mar' , 'Mié' , 'Juv' , 'Vie' , 'Sáb' ], 
            dayNamesMin: ['Do', 'Lu' , 'Ma' , 'Mi' , 'Ju' , 'Vi' , 'Sá' ],
            weekHeader: 'Sm' , 
            firstDay: 1, 
            isRTL: false, 
            showMonthAfterYear: false, 
            yearSuffix: '',
            selectOtherMonths: true,      
            changeMonth: true,
            changeYear: true,
            showWeek: true,
            showButtonPanel: true
        })
        
        $( "#to" ).datepicker({
            dateFormat: dateFormat,
            maxDate: new Date(),
            closeText: 'Cerrar',
            currentText: 'Hoy' , 
            monthNames: ['Enero', 'Febrero' , 'Marzo' , 'Abril' , 'Mayo'
                , 'Junio' , 'Julio' , 'Agosto' , 'Septiembre' , 'Octubre' , 'Noviembre' , 'Diciembre' ], 
            monthNamesShort:
                ['Ene', 'Feb' , 'Mar' , 'Abr' , 'May' , 'Jun' , 'Jul' , 'Ago' , 'Sep' , 'Oct' , 'Nov' , 'Dic' ], 
            dayNames:
                ['Domingo', 'Lunes' , 'Martes' , 'Miércoles' , 'Jueves' , 'Viernes' , 'Sábado' ], 
            dayNamesShort: ['Dom', 'Lun'
                , 'Mar' , 'Mié' , 'Juv' , 'Vie' , 'Sáb' ], 
            dayNamesMin: ['Do', 'Lu' , 'Ma' , 'Mi' , 'Ju' , 'Vi' , 'Sá' ],
            weekHeader: 'Sm' , 
            firstDay: 1, 
            isRTL: false, 
            showMonthAfterYear: false, 
            yearSuffix: '',
            selectOtherMonths: true,
            changeMonth: true,
            changeYear: true,
            showWeek: true,
            showButtonPanel: true
        })
    });    

    @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
    @endif

    @if(count($errors) > 0)
        toastr.error("@foreach($errors->all() as $error)"+
                    "<p>{{$error}}</p>"+
                    "@endforeach");
    @endif
</script>