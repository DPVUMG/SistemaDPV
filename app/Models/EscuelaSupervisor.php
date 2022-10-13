<?php

namespace App\Models;

use App\Models\Escuela;
use App\Models\Usuario;
use App\Models\Distrito;
use App\Models\Supervisor;
use Illuminate\Database\Eloquent\Model;

class EscuelaSupervisor extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'escuela_supervisor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activo', 'escuela_id', 'distrito_id', 'supervisor_id', 'usuario_id'
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

    public function distrito()
    {
        return $this->hasMany(Distrito::class, 'id', 'distrito_id');
    }

    public function supervisor()
    {
        return $this->hasMany(Supervisor::class, 'id', 'supervisor_id');
    }

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usuario_id');
    }
}
