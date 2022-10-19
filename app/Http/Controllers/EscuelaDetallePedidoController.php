<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EscuelaPedido;
use App\Models\EscuelaDetallePedido;

class EscuelaDetallePedidoController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EscuelaPedido  $escuela_pedido_detalle
     * @return \Illuminate\Http\Response
     */
    public function show(EscuelaPedido $escuela_pedido_detalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EscuelaDetallePedido  $escuela_pedido_detalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EscuelaDetallePedido $escuela_pedido_detalle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EscuelaDetallePedido  $escuela_pedido_detalle
     * @return \Illuminate\Http\Response
     */
    public function destroy(EscuelaDetallePedido $escuela_pedido_detalle)
    {
        //
    }
}
