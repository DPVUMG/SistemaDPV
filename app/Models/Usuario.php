<?php

namespace App\Models;

use App\Models\Persona;
use Illuminate\Support\Facades\Storage;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
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
            'usuario' => 10,
            'persona.cui' => 8,
            'persona.nombre' => 6,
            'persona.apellido' => 6
        ],
        'joins' => [
            'persona' => ['persona.id', 'usuario.persona_id']
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario',
        'activo',
        'persona_id',
        'password'
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
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y h:i:s',
        'updated_at' => 'datetime:d-m-Y h:i:s',
        'activo' => 'boolean'
    ];

    //Mutadores
    public function getNameCompleteAttribute()
    {
        return "{$this->persona->nombre} {$this->persona->apellido}";
    }

    //Mutadores
    public function getPictureAttribute()
    {
        if (is_null($this->persona->avatar)) {
            return asset('image/persona_default.png');
        }

        return Storage::disk('avatar')->exists("{$this->persona->avatar}") ? Storage::disk('avatar')->url("{$this->persona->avatar}") : asset('image/persona_default.png');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function persona()
    {
        return $this->hasOne(Persona::class, 'id', 'persona_id');
    }
}
