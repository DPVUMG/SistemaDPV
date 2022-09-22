<?php

namespace App\Models;

use App\Models\Variante;
use App\Models\Presentacion;
use Illuminate\Database\Eloquent\Model;

class ProductoVariante extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'producto_variante';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'precio', 'producto_id', 'variante_presentacion_id', 'variante_id',
        'presentacion_id', 'activo'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'activo' => 'boolean',
    ];

    public function variante()
    {
        return $this->hasOne(Variante::class, 'id', 'variante_id');
    }

    public function presentacion()
    {
        return $this->hasOne(Presentacion::class, 'id', 'presentacion_id');
    }
}
