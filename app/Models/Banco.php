<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Banco extends Model
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
    protected $table = 'banco';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre'];

    public function escuelas()
    {
        return $this->hasMany(PagoPedido::class, 'banco_id', 'id');
    }
}
