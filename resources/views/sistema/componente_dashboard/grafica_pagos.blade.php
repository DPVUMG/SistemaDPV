<div class="card card-chart">
    <div class="card-header card-header-info">
        <div id="graficaPagoMensual"></div>
    </div>
    <div class="card-body">
        <h4 class="card-title">Pagos</h4>
        <p class="card-category">Información de los pagos registrados en el sistema.</p>
    </div>
    <div class="card-footer">
        <div class="stats">
            <i class="material-icons">access_time</i> información del año {{ date('Y') }}
        </div>
    </div>
</div>
@push('js')
<script>
    console.log(@json($grafica))
    Highcharts.chart('graficaPagoMensual', {
        title: {
            text: 'Pagos del año '+@json(date('Y'))
        },
        subtitle: {
            text: 'Gráfica que muestra información de los pagos por mes'
        },
        xAxis: {
            categories: [
                'Enero', 
                'Febrero', 
                'Marzo', 
                'Abril', 
                'Mayo', 
                'Junio', 
                'Julio', 
                'Agosto', 
                'Septiembre',
                'Octubre', 
                'Noviembre', 
                'Diciembre'
            ]
        },
        yAxis: {
            title: {
                text: 'Montos'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                allowPointSelect: false
            }
        },
        series: [{
            name: 'Monto Total Q. ',
            data: @json($grafica)
        }],
        responsive: {
            rules: [{
                condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
            }]
        }
    });
</script>
@endpush