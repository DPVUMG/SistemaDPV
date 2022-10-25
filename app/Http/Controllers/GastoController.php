<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GastoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $items = Gasto::orderBy('id', 'asc')
                ->get();

            return view('sistema.gasto.index', compact('items'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route($this->redireccionarCatch());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['anio'] = date('Y');
            $data['mes_id'] = date('m');
            $data['usuario_id'] = Auth::user()->id;
            Gasto::create($data);
            toastr()->success('Registro guardado.');
            return redirect()->route('gasto.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar.');
            return redirect()->route('gasto.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gasto  $gasto
     * @return \Illuminate\Http\Response
     */
    public function show(Gasto $gasto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gasto  $gasto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gasto $gasto)
    {
        try {
            $gasto->delete();
            toastr()->success('Registro eliminado.');
            return redirect()->route('gasto.index');
        } catch (\Exception $e) {
            toastr()->error("Error al eliminar.");
            return redirect()->route('gasto.index');
        }
    }
}
