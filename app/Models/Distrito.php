<?php

namespace App\Models;

use App\Models\Escuela;
use App\Models\Supervisor;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Distrito extends Model
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
            'codigo' => 10
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'distrito';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['codigo'];

    public function supervisores()
    {
        return $this->hasMany(Supervisor::class, 'distrito_id', 'id');
    }

    public function escuelas()
    {
        return $this->hasMany(Escuela::class, 'distrito_id', 'id');
    }
}
