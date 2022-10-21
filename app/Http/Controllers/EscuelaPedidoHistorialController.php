<?php

namespace App\Http\Controllers;

use App\Models\EscuelaPedido;
use App\Models\EscuelaPedidoHistorial;
use Illuminate\Http\Request;

class EscuelaPedidoHistorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $items = EscuelaPedidoHistorial::get();

            return view('sistema.pedido.historial', compact('items'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route($this->redireccionarCatch());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EscuelaPedido  $escuela_pedido_historial
     * @return \Illuminate\Http\Response
     */
    public function show(EscuelaPedido $escuela_pedido_historial)
    {
        try {
            return view('sistema.pedido.ver_historial', compact('escuela_pedido_historial'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route($this->redireccionarCatch());
        }
    }
}
