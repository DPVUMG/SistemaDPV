<?php

namespace App\Models;

use App\Models\Producto;
use App\Models\EscuelaUsuario;
use Illuminate\Database\Eloquent\Model;

class ComentarioProducto extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'producto_comentario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment', 'producto_id', 'escuela_usuario_id'
    ];

    public function producto()
    {
        return $this->hasOne(Producto::class, 'id', 'producto_id');
    }

    public function usuario()
    {
        return $this->hasOne(EscuelaUsuario::class, 'id', 'escuela_usuario_id');
    }
}
