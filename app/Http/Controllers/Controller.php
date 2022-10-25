<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Persona;
use App\Models\Usuario;
use App\Models\Director;
use App\Models\Distrito;
use App\Models\Municipio;
use Illuminate\Support\Str;
use App\Models\EstadoPedido;
use Illuminate\Http\Request;
use App\Models\Departamental;
use App\Models\EscuelaUsuario;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Models\EscuelaPedidoHistorial;
use Illuminate\Support\Facades\Storage;
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

    protected function createOrselect_departamental(string $nombre)
    {
        return Departamental::firstOrCreate(
            ['nombre' => $nombre],
            ['nombre' => $nombre]
        );
    }

    protected function createOrselect_distrito(string $codigo)
    {
        return Distrito::firstOrCreate(
            ['codigo' => $codigo],
            ['codigo' => $codigo]
        );
    }

    protected function updateMasive_director(string $nombre, string $telefono, int $escuela_id, bool $insert = false)
    {
        Director::where('nombre', $nombre)
            ->update(
                [
                    'nombre' => $nombre,
                    'telefono' => $telefono,
                    'activo' => true
                ]
            );

        if ($insert) {
            return Director::firstOrCreate(
                [
                    'nombre' => $nombre,
                    'telefono' => $telefono,
                    'activo' => true,
                    'escuela_id' => $escuela_id,
                    'usuario_id' => Auth::user()->id
                ],
                ['nombre' => $nombre]
            );
        } else {
            return null;
        }
    }

    protected function createOrselect_banco(string $nombre)
    {
        return Banco::firstOrCreate(
            ['nombre' => $nombre],
            ['nombre' => $nombre]
        );
    }

    protected function updateOrcreateOrselect_persona(Request $request, int $persona_id = 0)
    {
        if ($persona_id > 0) {
            $persona = Persona::find($persona_id);
            $persona->cui = $request->cui_persona;
        } else {
            $persona = Persona::where('cui', $request->cui_persona)->first();
        }

        if (is_null($persona)) {
            $persona = new Persona();
            $persona->cui = $request->cui_persona;
        } else {
            if ($request->has('avatar_persona')) {
                if (!empty($request->avatar_persona)) {
                    Storage::disk('avatar')->exists($persona->avatar_persona) ? Storage::disk('avatar')->delete($persona->avatar_persona) : null;
                }
            }
        }

        $persona->nombre = $request->nombre_persona;
        $persona->apellido = $request->apellido_persona;
        $persona->telefono = $request->telefono_persona;
        $persona->correo_electronico = $request->correo_electronico_persona;
        $persona->direccion = $request->direccion_persona;
        $persona->departamento_id = Municipio::find($request->municipio_id_persona)->departamento_id;
        $persona->municipio_id = $request->municipio_id_persona;

        if ($request->has('avatar_persona')) {
            if (!empty($request->avatar_persona)) {
                $image = Image::make(file_get_contents($request->file('avatar_persona')));
                $image->encode('jpg', 70);
                $persona->avatar = Str::random(10);
                $persona->avatar = "{$persona->avatar}.jpg";

                Storage::disk('avatar')->put($persona->avatar, $image);
            }
        }

        $persona->save();

        return $persona;
    }

    public function createUsuario(Request $request, int $escuela_id, bool $escuela)
    {
        $persona = $this->updateOrcreateOrselect_persona($request);

        if ($escuela) {
            $usuario = EscuelaUsuario::create(
                [
                    'password' => $request->password,
                    'usuario' => $request->usuario,
                    'activo' => true,
                    'persona_id' => $persona->id,
                    'escuela_id' => $escuela_id,
                    'usuario_id' => Auth::user()->id
                ]
            );
        } else {
            $usuario = Usuario::create(
                [
                    'password' => $request->password,
                    'usuario' => $request->usuario,
                    'activo' => true,
                    'persona_id' => $persona->id
                ]
            );
        }

        $data['persona'] = $persona;
        $data['usuario'] = $usuario;

        return $data;
    }

    protected function generadorCodigo(string $palabra, int $correlativo)
    {
        $correlativo = $correlativo === 0 ? 1 : $correlativo + 1;
        $codigo = str_pad(strval($correlativo), 5, "0", STR_PAD_LEFT);
        $anio = date('Y');
        return "{$palabra}{$codigo}{$anio}";
    }

    public function historialPedido(int $estado_anterior, int $estado_actual, int $escuela_pedido_id, int $escuela_id, string $descripcion = null)
    {
        if (is_null($descripcion)) {
            switch ($estado_actual) {
                case 1:
                    $descripcion = "El pedido con número {$escuela_pedido_id} fue ingresado.";
                    break;
                case 2:
                    $descripcion = "El pedido con número {$escuela_pedido_id} fue confirmado.";
                    break;
                case 3:
                    $descripcion = "El pedido con número {$escuela_pedido_id} fue entregado.";
                    break;
                case 4:
                    $descripcion = "El pedido con número {$escuela_pedido_id} fue pagado.";
                    break;
                case 5:
                    $descripcion = "El pedido con número {$escuela_pedido_id} fue anulado.";
                    break;
                case 6:
                    $descripcion = "El pedido con número {$escuela_pedido_id} fue cancelado.";
                    break;
            }
        }

        EscuelaPedidoHistorial::create(
            [
                'estado_anterior' => EstadoPedido::find($estado_anterior)->nombre,
                'estado_actual' => EstadoPedido::find($estado_actual)->nombre,
                'descripcion' => $descripcion,
                'usuario' => Auth::user()->usuario,
                'escuela_id' => $escuela_id,
                'estado_pedido_id' => $estado_actual,
                'escuela_pedido_id' => $escuela_pedido_id
            ]
        );
    }
}
