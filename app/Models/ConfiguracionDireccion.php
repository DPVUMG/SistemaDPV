<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionDireccion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configuracion_direccion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'direccion',
        'configuracion_id'
    ];
}
