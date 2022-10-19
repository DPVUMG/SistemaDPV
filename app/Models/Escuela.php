<?php

namespace App\Models;

use App\Models\Usuario;
use App\Models\Director;
use App\Models\Distrito;
use App\Models\Municipio;
use App\Models\Departamento;
use App\Models\Departamental;
use App\Models\EscuelaCodigo;
use App\Models\EscuelaUsuario;
use App\Models\EscuelaDescuento;
use App\Models\EscuelaSupervisor;
use App\Models\EscuelaCodigoAlumno;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Nicolaslopezj\Searchable\SearchableTrait;

class Escuela extends Model
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
            'escuela.establecimiento' => 1,
            'escuela.nit' => 18,
            'escuela.sector' => 16,
            'escuela.area' => 16,
            'escuela.jornada' => 16,
            'escuela.plan' => 14,
            'distrito.codigo' => 12,
            'departamental.nombre' => 13,
            'departamento.nombre' => 10,
            'municipio.nombre' => 22
        ],
        'joins' => [
            'distrito' => ['distrito.id', 'escuela.distrito_id'],
            'departamental' => ['departamental.id', 'escuela.departamental_id'],
            'departamento' => ['departamento.id', 'escuela.departamento_id'],
            'municipio' => ['municipio.id', 'escuela.municipio_id']
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'escuela';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo', 'nit', 'establecimiento', 'direccion', 'telefono',
        'sector', 'area', 'jornada', 'plan', 'activo', 'distrito_id',
        'departamental_id', 'departamento_id', 'municipio_id', 'usuario_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'activo' => 'boolean',
    ];

    //Mutadores
    public function getPictureAttribute()
    {
        return Storage::disk('escuela')->exists("{$this->logo}") ? Storage::disk('escuela')->url("{$this->logo}") : asset('image/escuela/escuela_default.png');
    }

    public function distrito()
    {
        return $this->hasOne(Distrito::class, 'id', 'distrito_id');
    }

    public function departamental()
    {
        return $this->hasOne(Departamental::class, 'id', 'departamental_id');
    }

    public function departamento()
    {
        return $this->hasOne(Departamento::class, 'id', 'departamento_id');
    }

    public function municipio()
    {
        return $this->hasOne(Municipio::class, 'id', 'municipio_id');
    }

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usuario_id');
    }

    public function supervisores()
    {
        return $this->hasMany(EscuelaSupervisor::class, 'escuela_id', 'id');
    }

    public function codigos()
    {
        return $this->hasMany(EscuelaCodigo::class, 'escuela_id', 'id');
    }

    public function directores()
    {
        return $this->hasMany(Director::class, 'escuela_id', 'id');
    }

    public function alumnos()
    {
        return $this->hasMany(EscuelaCodigoAlumno::class, 'escuela_id', 'id');
    }

    public function usuarios()
    {
        return $this->hasMany(EscuelaUsuario::class, 'escuela_id', 'id');
    }

    public function descuentos()
    {
        return $this->hasMany(EscuelaDescuento::class, 'escuela_id', 'id');
    }
}
