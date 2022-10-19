<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use App\Models\Director;
use App\Models\Supervisor;
use App\Models\EscuelaUsuario;
use Illuminate\Support\Facades\DB;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data['directores'] = Director::select(
                'nombre AS nombre',
                'telefono AS telefono'
            )
                ->where('activo', true)
                ->groupBy('nombre', 'telefono')
                ->orderBy('nombre', 'asc')->get();

            $data['supervisores'] = Supervisor::select(
                'nombre AS nombre',
                'telefono AS telefono'
            )
                ->where('activo', true)
                ->groupBy('nombre', 'telefono')
                ->orderBy('nombre', 'asc')->get();

            $data['escuelas'] = Escuela::select(
                'establecimiento AS nombre',
                'telefono AS telefono'
            )
                ->where('activo', true)
                ->groupBy('establecimiento', 'telefono')
                ->orderBy('nombre', 'asc')->get();

            $data['usuarios'] = EscuelaUsuario::join('persona', 'persona.id', 'escuela_usuario.persona_id')
                ->select(
                    DB::RAW("CONCAT(persona.nombre,' ',persona.apellido) AS nombre"),
                    'persona.telefono AS telefono'
                )
                ->where('escuela_usuario.activo', true)
                ->groupBy('nombre', 'apellido', 'telefono')
                ->orderBy('nombre', 'asc')->get();

            return view('sistema.contacto.index', compact('data'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route($this->redireccionarCatch());
        }
    }
}
