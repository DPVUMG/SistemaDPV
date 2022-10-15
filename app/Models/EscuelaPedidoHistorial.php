<?php

namespace App\Models;

use App\Models\Escuela;
use App\Models\EstadoPedido;
use App\Models\EscuelaPedido;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class EscuelaPedidoHistorial extends Model
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
            'escuela.establecimiento' => 18,
            'estado_pedido.nombre' => 16,
            'escuela_pedido_historial.usuario' => 16
        ],
        'joins' => [
            'escuela' => ['escuela.id', 'escuela_pedido.escuela_id'],
            'estado_pedido' => ['estado_pedido.id', 'escuela_pedido.estado_pedido_id']
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'escuela_pedido_historial';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estado_anterior', 'estado_actual', 'descripcion', 'escuela_id', 'estado_pedido_id',
        'escuela_pedido_id', 'usuario'
    ];


    public function escuela()
    {
        return $this->hasOne(Escuela::class, 'id', 'escuela_id');
    }

    public function estado_pedido()
    {
        return $this->hasOne(EstadoPedido::class, 'id', 'estado_pedido_id');
    }

    public function escuela_pedido()
    {
        return $this->hasOne(EscuelaPedido::class, 'id', 'escuela_pedido_id');
    }
}
