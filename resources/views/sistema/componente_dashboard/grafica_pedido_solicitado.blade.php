<div class="card card-chart">
    <div class="card-header card-header-info">
        <div id="graficaPedidoSolicitado"></div>
    </div>
    <div class="card-body">
        <h4 class="card-title">Pedidos Solicitados</h4>
        <p class="card-category">
            Información de las 10 escuelas que más pedidos han solicitado, los pedidos
            seleccionados son los que están en estado <strong class="text-primary">Entregado</strong> o
            <strong class="text-primary">Pagado</strong>.
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
    Highcharts.chart('graficaPedidoSolicitado', {
        title: {
            text: 'Pedidos Solicitados en el año '+@json(date('Y'))
        },
        subtitle: {
            text: 'Gráfica que muestra información de las 10 escuelas que más pedidos han solicitado, los pedidos seleccionados son los que se encuentran en estado Entregado o Pagado'
        },
        xAxis: {
            labels: {
                style: {
                    fontSize: '10px',
                    fontFamily: 'Verdana, sans-serif'
                }
            },
            categories: @json($grafica['categories'])
        },
        yAxis: {
            title: {
                text: 'Solicitados'
            },
            labels: {
                format: '{value} pedidos'
            },
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        series: [{
            type: 'column',
            colorByPoint: true,
            name: 'Cantidad ',
            data: @json($grafica['data']),
            showInLegend: false
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