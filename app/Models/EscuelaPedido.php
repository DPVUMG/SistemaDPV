<?php

namespace App\Models;

use App\Models\Mes;
use App\Models\Escuela;
use App\Models\PagoPedido;
use App\Models\EstadoPedido;
use App\Models\EscuelaUsuario;
use App\Models\EscuelaDetallePedido;
use App\Models\EscuelaPedidoHistorial;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class EscuelaPedido extends Model
{
    use SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'escuela_usuario.usuario' => 18,
            'escuela.establecimiento' => 18,
            'estado_pedido.nombre' => 16
        ],
        'joins' => [
            'escuela_usuario' => ['escuela_usuario.id', 'escuela_pedido.escuela_usuario_id'],
            'escuela' => ['escuela.id', 'escuela_pedido.escuela_id'],
            'estado_pedido' => ['estado_pedido.id', 'escuela_pedido.estado_pedido_id']
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'escuela_pedido';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pagado', 'fecha_pedido', 'fecha_entrega', 'sub_total', 'descuento',
        'total', 'anio', 'descripcion', 'escuela_usuario_id', 'escuela_id',
        'estado_pedido_id', 'mes_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'pagado' => 'boolean',
    ];

    public function escuela_usuario()
    {
        return $this->hasOne(EscuelaUsuario::class, 'id', 'escuela_usuario_id');
    }

    public function escuela()
    {
        return $this->hasOne(Escuela::class, 'id', 'escuela_id');
    }

    public function estado_pedido()
    {
        return $this->hasOne(EstadoPedido::class, 'id', 'estado_pedido_id');
    }

    public function mes()
    {
        return $this->hasOne(Mes::class, 'id', 'mes_id');
    }

    public function escuela_detalle_pedido()
    {
        return $this->hasMany(EscuelaDetallePedido::class, 'escuela_pedido_id', 'id');
    }

    public function escuela_pedido_historial()
    {
        return $this->hasMany(EscuelaPedidoHistorial::class, 'escuela_pedido_id', 'id');
    }

    public function pago_pedido()
    {
        return $this->hasOne(PagoPedido::class, 'escuela_pedido_id', 'id');
    }
}
