<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class RequestCredit extends Model
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
            'users.name' => 10
        ],
        'joins' => [
            'users' => ['users.id','request_credits.user_id'],
        ]
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'request_credits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_start',
        'date_end',
        'total',
        'order_id',
        'credit_id',
        'user_id',
        'payment',
        'current'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['order_concat'];

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
    public function getOrderConcatAttribute()
    {
        return "#{$this->order_id}";
    }

    public function getTotalConcatAttribute()
    {
        $total = number_format($this->total,2,'.',',');
        return "Q {$total}";
    }

    public function getDateIAttribute()
    {
        return date('d/m/Y', strtotime($this->date_start));
    }

    public function getDateFAttribute()
    {
        return date('d/m/Y', strtotime($this->date_end));
    }

    public function getPasoAttribute()
    {
        $date = date('Y-m-d') > date('Y-m-d',strtotime($this->date_end))  ? true : false;
        return $date;
    }

    public function getRestaAttribute()
    {
        $fechaActual = date('Y-m-d');
        $datetime1 = date_create($this->date_end);
        $datetime2 = date_create($fechaActual);
        $data = date_diff($datetime1, $datetime2);
        $differenceFormat = '%a';
        return "{$data->format($differenceFormat)} días";
    }

    public function getUsuarioAttribute()
    {
        $user = User::find($this->user_id);
        !is_null($user) ? $usuario = $user->name : $usuario = '';

        return $usuario;
    }

    //Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function credit()
    {
        return $this->belongsTo(Credit::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
