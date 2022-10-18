<?php

namespace App\Models;

use App\Models\EscuelaUsuario;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comentario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment', 'escuela_usuario_id'
    ];

    public function usuario()
    {
        return $this->hasOne(EscuelaUsuario::class, 'id', 'escuela_usuario_id');
    }
}
