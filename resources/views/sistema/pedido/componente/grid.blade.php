<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Ingresados</a></li>
        <li><a href="#tabs-2">Confirmados</a></li>
        <li><a href="#tabs-3">Entregados</a></li>
        <li><a href="#tabs-4">Pagados</a></li>
        <li><a href="#tabs-5">Anulados</a></li>
        <li><a href="#tabs-6">Cancelados</a></li>
    </ul>
    <div id="tabs-1">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title">
                    <img src="{{ asset('image/pedido/ingreso.png') }}" title="Ingresados" width="50px" height="50px"
                        alt="Ingresados">
                    {{ __('Ingresados') }}
                </h4>
            </div>
            <div class="card-body">
                @include('sistema.pedido.componente.table', [ 'items' => $items->filter(function($item) {
                return $item->estado_pedido_id == 1;
                })->all(), 'estado' => 1 ])
            </div>
        </div>
    </div>
    <div id="tabs-2">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title">
                    <img src="{{ asset('image/pedido/confirmado.png') }}" title="Confirmados" width="50px" height="50px"
                        alt="Confirmados">
                    {{ __('Confirmados') }}
                </h4>
            </div>
            <div class="card-body">
                @include('sistema.pedido.componente.table', [ 'items' => $items->filter(function($item) {
                return $item->estado_pedido_id == 2;
                })->all(), 'estado' => 2 ])
            </div>
        </div>
    </div>
    <div id="tabs-3">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title">
                    <img src="{{ asset('image/pedido/entregado.png') }}" title="Entregados" width="50px" height="50px"
                        alt="Entregados">
                    {{ __('Entregados') }}
                </h4>
            </div>
            <div class="card-body">
                @include('sistema.pedido.componente.table', [ 'items' => $items->filter(function($item) {
                return $item->estado_pedido_id == 3;
                })->all(), 'estado' => 3 ])
            </div>
        </div>
    </div>
    <div id="tabs-4">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title">
                    <img src="{{ asset('image/pedido/pagado.png') }}" title="Pagados" width="50px" height="50px"
                        alt="Pagados">
                    {{ __('Pagados') }}
                </h4>
            </div>
            <div class="card-body">
                @include('sistema.pedido.componente.table', [ 'items' => $items->filter(function($item) {
                return $item->estado_pedido_id == 4;
                })->all(), 'estado' => 4 ])
            </div>
        </div>
    </div>
    <div id="tabs-5">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title">
                    <img src="{{ asset('image/pedido/anulado.png') }}" title="Anulados" width="50px" height="50px"
                        alt="Anulados">
                    {{ __('Anulados') }}
                </h4>
            </div>
            <div class="card-body">
                @include('sistema.pedido.componente.table', [ 'items' => $items->filter(function($item) {
                return $item->estado_pedido_id == 5;
                })->all(), 'estado' => 5 ])
            </div>
        </div>
    </div>
    <div id="tabs-6">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title">
                    <img src="{{ asset('image/pedido/cancelado.png') }}" title="Cancelados" width="50px" height="50px"
                        alt="Cancelados">
                    {{ __('Cancelados') }}
                </h4>
            </div>
            <div class="card-body">
                @include('sistema.pedido.componente.table', [ 'items' => $items->filter(function($item) {
                return $item->estado_pedido_id == 6;
                })->all(), 'estado' => 6 ])
            </div>
        </div>
    </div>
</div>
@push('js')
<script type="text/javascript">
    $( function() {
$( "#tabs" ).tabs();
} );
</script>
@endpush