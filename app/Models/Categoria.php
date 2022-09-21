<?php

namespace App\Models;

use App\Models\SubCategoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Nicolaslopezj\Searchable\SearchableTrait;

class Categoria extends Model
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
    protected $table = 'categoria';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'icono'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['iconoCat'];

    public function getIconoCatAttribute()
    {
        return Storage::disk('categoria')->exists($this->icono) ? Storage::disk('categoria')->url($this->icono) : null;
    }

    public function sub_categorias()
    {
        return $this->hasMany(SubCategoria::class);
    }
}
