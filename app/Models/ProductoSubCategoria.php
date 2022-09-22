<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoSubCategoria extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'producto_subcategoria';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'producto_id', 'categoria_id', 'sub_categoria_id'
    ];

    public function producto()
    {
        return $this->hasOne(Producto::class, 'id', 'producto_id');
    }

    public function categoria()
    {
        return $this->hasOne(Categoria::class, 'id', 'categoria_id');
    }

    public function sub_categoria()
    {
        return $this->hasOne(SubCategoria::class, 'id', 'sub_categoria_id');
    }
}
