<?php

namespace App\Models;

use App\Models\EscuelaCodigo;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Nivel extends Model
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
            'nombre' => 10
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nivel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'codigo'];

    public function escuelas()
    {
        return $this->hasMany(EscuelaCodigo::class, 'nivel_id', 'id');
    }
}
