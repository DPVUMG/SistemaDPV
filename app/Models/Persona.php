<?php

namespace App\Models;

use App\Models\Municipio;
use App\Models\Departamento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Nicolaslopezj\Searchable\SearchableTrait;

class Persona extends Model
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
            'cui' => 10,
            'nombre' => 8,
            'apellido' => 8
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'persona';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cui',
        'nombre',
        'apellido',
        'telefono',
        'correo_electronico',
        'direccion',
        'avatar',
        'departamento_id',
        'municipio_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['picture'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y h:i:s',
        'updated_at' => 'datetime:d-m-Y h:i:s'
    ];

    //Mutadores
    public function getPictureAttribute()
    {
        return Storage::disk('avatar')->exists("{$this->avatar}") ? Storage::disk('avatar')->url("{$this->avatar}") : asset('image/persona_default.png');
    }

    public function departamento()
    {
        return $this->hasOne(Departamento::class, 'id', 'departamento_id');
    }

    public function municipio()
    {
        return $this->hasOne(Municipio::class, 'id', 'municipio_id');
    }
}
