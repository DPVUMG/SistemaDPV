<?php

namespace App\Models;

use App\Models\Departamento;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'municipio';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['nombre', 'departamento_id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $departament = Departamento::find($this->departamento_id)->nombre;
        return str_replace('  ', ' ', "{$departament}, {$this->nombre}");
    }
}
