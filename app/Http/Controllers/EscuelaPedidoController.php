<?php

namespace App\Http\Controllers;

use App\Models\EstadoPedido;
use Illuminate\Http\Request;
use App\Models\EscuelaPedido;
use Illuminate\Support\Facades\DB;
use App\Models\EscuelaDetallePedido;

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
        try {
            return view('sistema.pedido.detalle', compact('escuela_pedido'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EstadoPedido  $estado
     * @return \Illuminate\Http\Response
     */
    public function estado(EstadoPedido $estado)
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
                ->where('estado_pedido_id', $estado->id)
                ->orderBy('escuela_pedido.id', 'desc')
                ->get();

            return view('sistema.pedido.estado', compact('items', 'estado'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route($this->redireccionarCatch());
        }
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
        try {
            if ($escuela_pedido->estado_pedido_id == 2) {
                DB::beginTransaction();

                $escuela_pedido->estado_pedido_id = 3;
                $escuela_pedido->save();

                $this->historialPedido($escuela_pedido->estado_pedido_id, 3, $escuela_pedido->id, $escuela_pedido->escuela_id);

                DB::commit();

                toastr()->success("El pedido número {$escuela_pedido->id} fue entregado.");
            } else {
                toastr()->info("El pedido número {$escuela_pedido->id} no pudo ser entregado porque ya no se encuentra en estado de Confirmado.");
            }

            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error('Error al anular el pedido.');
            return redirect()->route($this->redireccionarCatch());
        }
    }

    /**
     * Update status anulado.
     *
     * @param  \App\Models\EscuelaPedido  $escuela_pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(EscuelaPedido $escuela_pedido)
    {
        try {
            if ($escuela_pedido->estado_pedido_id == 1) {
                DB::beginTransaction();

                EscuelaDetallePedido::where("escuela_pedido_id", $escuela_pedido->id)->update(['activo' => false]);
                $escuela_pedido->estado_pedido_id = 5;
                $escuela_pedido->save();

                $this->historialPedido($escuela_pedido->estado_pedido_id, 5, $escuela_pedido->id, $escuela_pedido->escuela_id);

                DB::commit();

                toastr()->success("El pedido número {$escuela_pedido->id} fue anulado.");
            } else {
                toastr()->info("El pedido número {$escuela_pedido->id} no pudo ser anulado porque ya no se encuentra en estado de Ingreso.");
            }

            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error('Error al anular el pedido.');
            return redirect()->route($this->redireccionarCatch());
        }
    }

    /**
     * Update status entregado.
     *
     * @param  \App\Models\EscuelaPedido  $escuela_pedido
     * @return \Illuminate\Http\Response
     */
    public function entregado(EscuelaPedido $escuela_pedido)
    {
        try {
            if ($escuela_pedido->estado_pedido_id == 2) {
                DB::beginTransaction();

                $escuela_pedido->estado_pedido_id = 3;
                $escuela_pedido->save();

                $this->historialPedido($escuela_pedido->estado_pedido_id, 3, $escuela_pedido->id, $escuela_pedido->escuela_id);

                DB::commit();

                return response()->json(['mensaje' => "El pedido número {$escuela_pedido->id} fue entregado.", "estado" => 200], 200);
            } else {
                return response()->json(['mensaje' => "El pedido número {$escuela_pedido->id} no pudo ser entregado porque ya no se encuentra en estado de Confirmado.", "estado" => 201], 200);
            }

            return redirect()->route($this->redireccionarCatch());
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json("Error al entregar el pedido.", 500);
        }
    }

    /**
     * Update status ingresado.
     *
     * @param  \App\Models\EscuelaPedido  $escuela_pedido
     * @return \Illuminate\Http\Response
     */
    public function ingresado(EscuelaPedido $escuela_pedido)
    {
        try {
            if ($escuela_pedido->estado_pedido_id == 2) {
                DB::beginTransaction();

                $escuela_pedido->estado_pedido_id = 1;
                $escuela_pedido->save();

                $this->historialPedido($escuela_pedido->estado_pedido_id, 1, $escuela_pedido->id, $escuela_pedido->escuela_id, "El pedido número {$escuela_pedido->id} fue regresado a ingresado.");

                DB::commit();

                return response()->json(['mensaje' => "El pedido número {$escuela_pedido->id} fue regresado a ingresado.", "estado" => 200], 200);
            } else {
                return response()->json(['mensaje' => "El pedido número {$escuela_pedido->id} no pudo ser regresado a ingresado porque ya no se encuentra en estado de Confirmado.", "estado" => 201], 200);
            }

            return redirect()->route($this->redireccionarCatch());
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json("Error al entregar el pedido.", 500);
        }
    }
}
