<?php

namespace App\Models;

use App\Models\Escuela;
use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class EscuelaUsuario extends Model
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
            'escuela_usuario.usuario' => 10,
            'persona.cui' => 8,
            'persona.nombre' => 8,
            'persona.apellido' => 8,
            'escuela.establecimiento' => 8
        ],
        'joins' => [
            'persona' => ['persona.id', 'escuela_usuario.persona_id'],
            'escuela' => ['escuela.id', 'escuela_usuario.escuela_id']
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'escuela_usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario', 'activo', 'persona_id', 'escuela_id', 'usuario_id', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'activo' => 'boolean',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function persona()
    {
        return $this->hasOne(Persona::class, 'id', 'persona_id');
    }

    public function escuela()
    {
        return $this->hasOne(Escuela::class, 'id', 'escuela_id');
    }

    public function usuario_sistema()
    {
        return $this->hasOne(Usuario::class, 'id', 'usuario_id');
    }
}
