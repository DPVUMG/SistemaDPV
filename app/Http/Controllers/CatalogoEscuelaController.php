<?php

namespace App\Http\Controllers;

use App\Models\Distrito;
use Illuminate\Http\Request;

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
    public function distrito(Request $request)
    {
        if ($request->has('search') && $request->search != "") {
            $items = Distrito::search($request->search)->orderby('codigo', 'asc')->get();
        } else {
            $items = Distrito::orderby('codigo', 'asc')->get();
        }

        $response = array();
        foreach ($items as $item) {
            $response[] = array("value" => $item->id, "label" => $item->codigo);
        }

        return response()->json($response);
    }
}
