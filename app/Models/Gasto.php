<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Gasto extends Model
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
    protected $table = 'gasto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'monto', 'descripcion', 'anio', 'mes_id',
        'usuario_id'
    ];

    public function mes()
    {
        return $this->hasOne(Mes::class, 'id', 'mes_id');
    }

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usuario_id');
    }
}
