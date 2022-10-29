<div class="card card-chart">
    <div class="card-header card-header-info">
        <div id="graficaIngresoGasto"></div>
    </div>
    <div class="card-body">
        <h4 class="card-title">Ingresos y Gastos</h4>
        <p class="card-category">
            Información de los ingresos se consultan de los
            <strong class="text-primary">pagos realizados por las escuelas</strong> y los gastos se consultan de los
            <strong class="text-primary">gasto registrados en el sistema</strong>.
        </p>
    </div>
    <div class="card-footer">
        <div class="stats">
            <i class="material-icons">access_time</i> información del año {{ date('Y') }}
        </div>
    </div>
</div>
@push('js')
<script>
    Highcharts.chart('graficaIngresoGasto', {
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Ingresos y Gastos del año '+@json(date('Y'))
        },
        subtitle: {
            text: 'Gráfica que muestra información de los ingresos y gastos registrados en el sistema.'
        },
        xAxis: {
            categories: @json($grafica['categories']),
            crosshair: false
        },
        yAxis: {
            min: 0,
            allowDecimals: false,
            title: {
                text: ''
            },
            labels: {
                format: '{value} quetazales'
            },
        },
        tooltip: {
            shared: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                borderRadius: 5,
                borderWidth: 1
            }
        },
        series: @json($grafica['series']),
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                }
            }]
        }
    });
</script>
@endpush