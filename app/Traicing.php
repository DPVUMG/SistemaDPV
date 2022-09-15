<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traicing extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'traicings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'order_id',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y h:i:s',
        'updated_at' => 'datetime:d-m-Y h:i:s'
    ];

    //Mutadores
    public function getUserAttribute()
    {
        return User::find($this->user_id)->name;
    }

    public function getDateAttribute()
    {
        return date('d/m/Y h:i:s', strtotime($this->created_at));
    }

    //Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
