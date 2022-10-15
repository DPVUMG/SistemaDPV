<?php

namespace App\Models;

use App\Models\Mes;
use App\Models\Escuela;
use App\Models\Producto;
use App\Models\Variante;
use App\Models\Presentacion;
use App\Models\EscuelaPedido;
use App\Models\ProductoVariante;
use App\Models\VariantePresentacion;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class EscuelaDetallePedido extends Model
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
            'producto.codigo' => 18,
            'producto.nombre' => 18,
            'variante.nombre' => 16,
            'presentacion.nombre' => 16
        ],
        'joins' => [
            'producto' => ['producto.id', 'escuela_detalle_pedido.producto_id'],
            'variante' => ['variante.id', 'escuela_detalle_pedido.variante_id'],
            'presentacion' => ['presentacion.id', 'escuela_detalle_pedido.presentacion_id']
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'escuela_detalle_pedido';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cantidad', 'precio_real', 'precio_descuento', 'descuento', 'sub_total',
        'anio', 'activo', 'escuela_pedido_id', 'escuela_id', 'producto_variante_id',
        'producto_id', 'variante_presentacion_id', 'variante_id', 'presentacion_id', 'mes_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'activo' => 'boolean',
    ];

    public function escuela_pedido()
    {
        return $this->hasOne(EscuelaPedido::class, 'id', 'escuela_pedido_id');
    }

    public function escuela()
    {
        return $this->hasOne(Escuela::class, 'id', 'escuela_id');
    }

    public function producto_variante()
    {
        return $this->hasOne(ProductoVariante::class, 'id', 'producto_variante_id');
    }

    public function producto()
    {
        return $this->hasOne(Producto::class, 'id', 'producto_id');
    }

    public function variante_presentacion()
    {
        return $this->hasOne(VariantePresentacion::class, 'id', 'variante_presentacion_id');
    }

    public function variante()
    {
        return $this->hasOne(Variante::class, 'id', 'variante_id');
    }

    public function presentacion()
    {
        return $this->hasOne(Presentacion::class, 'id', 'presentacion_id');
    }

    public function mes()
    {
        return $this->hasOne(Mes::class, 'id', 'mes_id');
    }
}
