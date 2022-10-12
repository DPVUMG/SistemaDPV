<?php

namespace App\Models;

use App\Models\Marca;
use App\Models\ProductoFoto;
use App\Models\ProductoVariante;
use App\Models\ProductoSubCategoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Nicolaslopezj\Searchable\SearchableTrait;

class Producto extends Model
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
            'producto.codigo' => 10,
            'producto.nombre' => 10,
            'marca.nombre' => 10
        ],
        'joins' => [
            'marca' => ['marca.id', 'producto.marca_id']
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'producto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo', 'nombre', 'descripcion', 'foto',
        'nuevo', 'activo', 'marca_id', 'usuario_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'nuevo' => 'boolean',
        'activo' => 'boolean'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['picture'];

    public function getPictureAttribute()
    {
        return Storage::disk('producto')->exists("{$this->id}/{$this->foto}") ? Storage::disk('producto')->url("{$this->id}/{$this->foto}") : null;
    }

    public function marca()
    {
        return $this->hasOne(Marca::class, 'id', 'marca_id');
    }

    public function producto_subcategoria()
    {
        return $this->hasMany(ProductoSubCategoria::class, 'producto_id', 'id');
    }

    public function producto_variante()
    {
        return $this->hasMany(ProductoVariante::class, 'producto_id', 'id');
    }

    public function producto_foto()
    {
        return $this->hasMany(ProductoFoto::class, 'producto_id', 'id');
    }
}
