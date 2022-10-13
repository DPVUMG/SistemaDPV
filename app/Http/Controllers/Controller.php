<?php

namespace App\Http\Controllers;

use App\Models\Distrito;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function redireccionarCatch()
    {
        return 'sistema.home';
    }

    protected function sectores()
    {
        return ['Privado', 'Oficial', 'Cooperativa', 'Municipal'];
    }

    protected function areas()
    {
        return ['Urbana', 'Rural'];
    }

    protected function jornadas()
    {
        return ['Matutina', 'Doble', 'Vespertina', 'Nocturna', 'Intermedia', 'Sin Jornada'];
    }

    protected function createOrselect_distrito(string $codigo)
    {
        return Distrito::firstOrCreate(
            ['codigo' => $codigo],
            ['codigo' => $codigo]
        );
    }

    protected function generadorCodigo(string $palabra, int $correlativo)
    {
        $correlativo = $correlativo === 0 ? 1 : $correlativo + 1;
        $codigo = str_pad(strval($correlativo), 5, "0", STR_PAD_LEFT);
        $anio = date('Y');
        return "{$palabra}{$codigo}{$anio}";
    }
}
