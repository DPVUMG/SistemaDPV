<?php

namespace App\Models;

use App\Models\Nivel;
use App\Models\Escuela;
use App\Models\Usuario;
use App\Models\EscuelaCodigo;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class EscuelaCodigoAlumno extends Model
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
            'escuela.establecimiento' => 10,
            'escuela_codigo.codigo' => 8
        ],
        'joins' => [
            'escuela' => ['escuela.id', 'escuela_codigo_alumno.escuela_id'],
            'escuela_codigo' => ['escuela_codigo.id', 'escuela_codigo_alumno.escuela_codigo_id']
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'escuela_codigo_alumno';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cantidad_alumno', 'activo', 'escuela_codigo_id', 'escuela_id', 'nivel_id', 'usuario_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'activo' => 'boolean',
    ];

    public function escuela_codigo()
    {
        return $this->hasOne(EscuelaCodigo::class, 'id', 'escuela_codigo_id');
    }

    public function escuela()
    {
        return $this->hasOne(Escuela::class, 'id', 'escuela_id');
    }

    public function nivel()
    {
        return $this->hasOne(Nivel::class, 'id', 'nivel_id');
    }

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usuario_id');
    }
}
