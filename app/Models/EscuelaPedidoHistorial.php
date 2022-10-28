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

    /**
     * Get the Icon
     *
     * @param  string  $value
     * @return string
     */
    public function getIconAttribute(int $value)
    {
        $icon = '';
        switch ($value) {
            case 1:
                $icon = 'fa fa-plus';
                break;
            case 2:
                $icon = 'fa fa-check';
                break;
            case 3:
                $icon = 'fa fa-list';
                break;
            case 4:
                $icon = 'fa fa-money';
                break;
            case 5:
                $icon = 'fa fa-trash';
                break;
            case 6:
                $icon = 'fa fa-close';
                break;
        }

        return $icon;
    }

    /**
     * Get the Color
     *
     * @param  string  $value
     * @return string
     */
    public function getColorAttribute($value)
    {
        $color = '';
        switch ($value) {
            case 1:
                $color = 'timeline-container info';
                break;
            case 2:
                $color = 'timeline-container success';
                break;
            case 3:
                $color = 'timeline-container primary';
                break;
            case 4:
                $color = 'timeline-container payment';
                break;
            case 5:
                $color = 'timeline-container warning';
                break;
            case 6:
                $color = 'timeline-container danger';
                break;
        }

        return $color;
    }

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
