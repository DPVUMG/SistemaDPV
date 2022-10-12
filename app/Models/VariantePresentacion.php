<?php

namespace App\Models;

use App\Models\Variante;
use App\Models\Presentacion;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class VariantePresentacion extends Model
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
            'variante.nombre' => 10,
            'presentacion.nombre' => 10,
        ],
        'joins' => [
            'variante' => ['variante.id', 'variante_presentacion.variante_id'],
            'presentacion' => ['presentacion.id', 'variante_presentacion.presentacion_id'],
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'variante_presentacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['variante_id', 'presentacion_id', 'usuario_id'];

    public function variante()
    {
        return $this->hasOne(Variante::class, 'id', 'variante_id');
    }

    public function presentacion()
    {
        return $this->hasOne(Presentacion::class, 'id', 'presentacion_id');
    }
}
