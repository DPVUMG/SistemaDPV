<?php

namespace App\Models;

use App\Models\ConfiguracionTelefono;
use App\Models\ConfiguracionDireccion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Configuracion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configuracion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'nit',
        'nombre',
        'slogan',
        'vision',
        'mision',
        'logotipo',
        'ubicacion_x',
        'ubicacion_y',
        'facebook',
        'twitter',
        'instagram',
        'url',
        'pagina',
        'sistema'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['logotipoPicture'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y h:i:s',
        'updated_at' => 'datetime:d-m-Y h:i:s',
        'pagina' => 'boolean',
        'sistema' => 'boolean'
    ];

    //Mutadores
    public function getFormatoFechaAttribute()
    {
        $date = date('d/m/Y h:i:s', strtotime($this->created_at));
        return "Última actualización {$date}";
    }

    public function getLogotipoPictureAttribute()
    {
        return Storage::disk('logotipo')->exists($this->logotipo) ? Storage::disk('logotipo')->url($this->logotipo) : null;
    }

    //Relaciones
    public function telefonos()
    {
        return $this->hasMany(ConfiguracionTelefono::class, 'configuracion_id', 'id');
    }

    public function direcciones()
    {
        return $this->hasMany(ConfiguracionDireccion::class, 'configuracion_id', 'id');
    }
}
