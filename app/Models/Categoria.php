<?php

namespace App\Models;

use App\Models\SubCategoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Categoria extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categoria';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['nombre', 'icono'];

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
