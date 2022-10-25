<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Nivel;
use App\Models\Escuela;
use App\Models\Director;
use App\Models\Distrito;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use App\Models\Departamental;
use App\Models\EscuelaCodigo;
use Illuminate\Support\Facades\DB;

class CatalogoEscuelaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sistema.catalogo.escuela.index');
    }

    /**
     * Search autocomplete.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function departamental(Request $request)
    {
        if ($request->has('search') && $request->search != "") {
            $items = Departamental::search($request->search)->orderby('nombre', 'asc')->limit(10)->get();
        } else {
            $items = Departamental::orderby('nombre', 'asc')->limit(10)->get();
        }

        $response = array();
        foreach ($items as $item) {
            $response[] = array("value" => $item->id, "label" => $item->nombre);
        }

        return response()->json($response);
    }

    /**
     * Select list.
     *
     * @return \Illuminate\Http\Response
     */
    public function supervisor()
    {
        $items = Supervisor::join('distrito', 'distrito.id', 'supervisor.distrito_id')
            ->select(
                'supervisor.id AS id',
                DB::RAW("CONCAT(distrito.codigo,' - ',supervisor.nombre) AS supervisor")
            )
            ->where('supervisor.activo', true)
            ->orderby('supervisor.nombre', 'asc')->get();
        return response()->json($items);
    }

    /**
     * Search autocomplete.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function distrito(Request $request)
    {
        if ($request->has('search') && $request->search != "") {
            $items = Distrito::search($request->search)->orderby('codigo', 'asc')->limit(10)->get();
        } else {
            $items = Distrito::orderby('codigo', 'asc')->limit(10)->get();
        }

        $response = array();
        foreach ($items as $item) {
            $response[] = array("value" => $item->id, "label" => $item->codigo);
        }

        return response()->json($response);
    }

    /**
     * Select list.
     *
     * @return \Illuminate\Http\Response
     */
    public function nivel()
    {
        $items = Nivel::select(
            'id AS id',
            DB::RAW("CONCAT(codigo,' | ',nombre) AS nivel")
        )->orderby('nombre', 'asc')->get();
        return response()->json($items);
    }

    /**
     * Search autocomplete.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function director(Request $request)
    {
        if ($request->has('search') && $request->search != "") {
            $items = Director::search($request->search)->orderby('nombre', 'asc')->limit(10)->get();
        } else {
            $items = Director::orderby('nombre', 'asc')->limit(10)->get();
        }

        $response = array();
        foreach ($items as $item) {
            $response[] = array("value" => $item->id, "label" => $item->nombre, "telefono" => $item->telefono);
        }

        return response()->json($response);
    }

    /**
     * Search autocomplete.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function plan(Request $request)
    {
        if ($request->has('search') && $request->search != "") {
            $items = Escuela::select('plan')->where('plan', 'LIKE', "%{$request->search}%")->groupBy('plan')->orderby('plan', 'asc')->limit(10)->get();
        } else {
            $items = Escuela::select('plan')->groupBy('plan')->orderby('plan', 'asc')->limit(10)->get();
        }

        $response = array();
        foreach ($items as $item) {
            $response[] = array("value" => $item->plan, "label" => $item->plan);
        }

        return response()->json($response);
    }

    /**
     * Select list.
     *
     * @param  int  $escuela
     * @return \Illuminate\Http\Response
     */
    public function escuela_codigos($escuela)
    {
        $items = EscuelaCodigo::join('nivel', 'nivel.id', 'escuela_codigo.nivel_id')
            ->select(
                'escuela_codigo.id AS id',
                DB::RAW("CONCAT(nivel.nombre,' - ',escuela_codigo.codigo) AS codigo")
            )
            ->where('escuela_id', $escuela)
            ->where('escuela_codigo.activo', true)
            ->orderby('nivel.nombre', 'asc')->get();
        return response()->json($items);
    }

    /**
     * Select list.
     *
     * @return \Illuminate\Http\Response
     */
    public function escuelas()
    {
        $items = Escuela::select(
            'escuela.id AS id',
            'escuela.establecimiento AS establecimiento'
        )
            ->where('escuela.activo', true)
            ->orderby('escuela.establecimiento', 'asc')->get();
        return response()->json($items);
    }

    /**
     * Search autocomplete.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function banco(Request $request)
    {
        if ($request->has('search') && $request->search != "") {
            $items = Banco::search($request->search)->orderby('nombre', 'asc')->limit(10)->get();
        } else {
            $items = Banco::orderby('nombre', 'asc')->limit(10)->get();
        }

        $response = array();
        foreach ($items as $item) {
            $response[] = array("value" => $item->id, "label" => $item->nombre);
        }

        return response()->json($response);
    }
}
