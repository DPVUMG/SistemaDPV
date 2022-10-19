<?php

namespace App\Http\Controllers;

use App\Models\EscuelaPedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EscuelaPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $items = EscuelaPedido::join('escuela', 'escuela.id', 'escuela_pedido.escuela_id')
                ->join('mes', 'mes.id', 'escuela_pedido.mes_id')
                ->join('escuela_usuario', 'escuela_usuario.id', 'escuela_pedido.escuela_usuario_id')
                ->join('persona', 'persona.id', 'escuela_usuario.persona_id')
                ->select(
                    'escuela_pedido.id AS id',
                    'escuela.establecimiento AS escuela',
                    'escuela_pedido.fecha_pedido AS fecha_pedido',
                    'escuela_pedido.fecha_entrega AS fecha_entrega',
                    'escuela_pedido.created_at AS created_at',
                    'escuela_pedido.descuento AS descuento',
                    'escuela_pedido.sub_total AS sub_total',
                    'escuela_pedido.total AS total',
                    'escuela_pedido.descripcion AS descripcion',
                    DB::RAW("CONCAT(persona.nombre,' ',persona.apellido) AS solicitante"),
                    'mes.nombre AS mes',
                    'escuela_pedido.anio AS anio',
                    'escuela_pedido.estado_pedido_id AS estado_pedido_id',
                    'escuela_pedido.escuela_id AS escuela_id'
                )
                ->where('anio', date('Y'))
                ->orderBy('id', 'asc')
                ->get();

            return view('sistema.pedido.index', compact('items'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route($this->redireccionarCatch());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EscuelaPedido  $escuela_pedido
     * @return \Illuminate\Http\Response
     */
    public function show(EscuelaPedido $escuela_pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EscuelaPedido  $escuela_pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EscuelaPedido $escuela_pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EscuelaPedido  $escuela_pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(EscuelaPedido $escuela_pedido)
    {
        //
    }
}
