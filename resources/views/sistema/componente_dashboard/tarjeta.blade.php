<div class="card card-stats">
    <div class="card-header card-header-info card-header-icon">
        <div class="card-icon">
            <i class="material-icons">
                <img src="{{ asset('image/pedido/ingreso.png') }}" title="ingreso" width="50px" height="50px"
                    alt="ingreso">
            </i>
        </div>
        <p class="card-category">{{ $titulo }}</p>
        <h3 class="card-title">{{ $data[$count] }}</h3>
    </div>
    <div class="card-footer">
        <div class="stats">
            <i class="material-icons text-primary">info</i>
            <a href="{{ route('escuela_pedido.estado', $estado_id) }}">Ver más</a>
        </div>
    </div>
</div>