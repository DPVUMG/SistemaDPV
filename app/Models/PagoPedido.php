<?php

namespace App\Models;

use App\Models\Escuela;
use App\Models\Usuario;
use App\Models\EscuelaPedido;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class PagoPedido extends Model
{
    use SearchableTrait;

    public const CHEQUE = 'Cheque';

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
            'mes.nombre' => 18,
            'escuela.establecimiento' => 18,
            'pago_pedido.numero_cheque' => 16,
            'usuario.usuario' => 16
        ],
        'joins' => [
            'escuela' => ['escuela.id', 'pago_pedido.escuela_id'],
            'usuario' => ['usuario.id', 'pago_pedido.usuario_id'],
            'mes' => ['mes.id', 'pago_pedido.mes_id']
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pago_pedido';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numero_cheque', 'tipo_pago', 'anio', 'mes_id', 'escuela_id',
        'escuela_pedido_id', 'usuario_id'
    ];


    public function escuela()
    {
        return $this->hasOne(Escuela::class, 'id', 'escuela_id');
    }

    public function escuela_pedido()
    {
        return $this->hasOne(EscuelaPedido::class, 'id', 'escuela_pedido_id');
    }

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usuario_id');
    }
}
