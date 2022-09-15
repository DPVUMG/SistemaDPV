<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionTelefono extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configuracion_telefono';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'telefono',
        'configuracion_id'
    ];
}
