<?php

namespace App\Models;

use App\Models\Escuela;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Variante;
use App\Models\Presentacion;
use App\Models\ProductoVariante;
use App\Models\VariantePresentacion;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class EscuelaDescuento extends Model
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
            'producto' => ['producto.id', 'escuela_descuento.producto_id'],
            'variante' => ['variante.id', 'escuela_descuento.variante_id'],
            'presentacion' => ['presentacion.id', 'escuela_descuento.presentacion_id']
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'escuela_descuento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'precio_original', 'precio', 'escuela_id', 'producto_variante_id', 'producto_id',
        'variante_presentacion_id', 'variante_id', 'presentacion_id',
        'activo', 'usuario_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'activo' => 'boolean',
    ];

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

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usuario_id');
    }
}
