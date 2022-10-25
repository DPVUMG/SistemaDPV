<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gasto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'monto', 'descripcion', 'anio', 'mes_id',
        'usuario_id'
    ];

    public function mes()
    {
        return $this->hasOne(Mes::class, 'id', 'mes_id');
    }

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usuario_id');
    }
}
