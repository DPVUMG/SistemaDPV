<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EscuelaPedido;
use Illuminate\Support\Facades\DB;
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
        try {
            if ($escuela_pedido_detalle->estado_pedido_id == 1) {
                return view('sistema.pedido.confirmado_detalle', compact('escuela_pedido_detalle'));
            } else {
                toastr()->error('El pedido seleccionado ya fue confirmado.');
                return redirect()->route('escuela_pedido.estado', 1);
            }
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EscuelaPedido  $escuela_pedido_detalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EscuelaPedido $escuela_pedido_detalle)
    {
        $this->validate($request, [
            'detale.*.id' => 'required|integer|exists:escuela_detalle_pedido,id',
            'detale.*.cantidad' => 'required|integer|between:1,100000',
            'detale.*.precio' => 'required|numeric|between:0,100000'
        ], [
            'detale.*.id.required' => 'El producto es obligatorio.',
            'detale.*.id.required.integer'  => 'El producto seleccionado no es válido.',
            'detale.*.id.exists'  => 'El producto seleccionado no existe.',

            'detale.*.cantidad.required' => 'La cantidad del producto es obligatoria.',
            'detale.*.cantidad.integer'  => 'La cantidad del producto debe de ser un número entero.',
            'detale.*.cantidad.between'  => 'La cantidad del producto debe ser un valor entre :min y :max.',

            'detale.*.precio.required' => 'El precio del producto es obligatoria.',
            'detale.*.precio.numeric'  => 'El precio del producto debe de ser un número.',
            'detale.*.precio.between'  => 'El precio del producto debe ser un valor entre :min y :max.'
        ]);

        try {
            if ($escuela_pedido_detalle->estado_pedido_id == 1) {
                DB::beginTransaction();

                $escuela_pedido_detalle->estado_pedido_id = 2;

                foreach ($request->detale as $key => $value) {
                    $detalle = EscuelaDetallePedido::find($request->detale[$key]["id"]);

                    $detalle->cantidad = $request->detale[$key]["cantidad"];
                    $precio = $request->detale[$key]["precio"] == 0 ? $detalle->precio_real : $request->detale[$key]["precio"];

                    $sub_totalArrayNew = $detalle->cantidad * $detalle->precio_real;
                    $descuentoArrayNew = $detalle->cantidad * ($detalle->precio_real - $precio);
                    $totalArrayNew = $detalle->cantidad * $precio;

                    $sub_totalNew = ($escuela_pedido_detalle->sub_total - ($detalle->sub_total + $detalle->descuento)) + $sub_totalArrayNew;
                    $descuentoNew = ($escuela_pedido_detalle->descuento - $detalle->descuento) + $descuentoArrayNew;
                    $totalNew = ($escuela_pedido_detalle->total - $detalle->sub_total) + $totalArrayNew;

                    $detalle->descuento = ($precio > 0 || $detalle->precio_descuento > 0) ? $descuentoArrayNew : $detalle->descuento;
                    $detalle->sub_total = $totalArrayNew;
                    $detalle->precio_descuento = $request->detale[$key]["precio"];
                    $detalle->save();

                    $escuela_pedido_detalle->sub_total = $sub_totalNew;
                    $escuela_pedido_detalle->descuento = ($precio > 0 || $detalle->precio_descuento > 0) ? $descuentoNew : $escuela_pedido_detalle->descuento;
                    $escuela_pedido_detalle->total = $totalNew;
                }

                $escuela_pedido_detalle->save();

                $this->historialPedido($escuela_pedido_detalle->estado_pedido_id, 2, $escuela_pedido_detalle->id, $escuela_pedido_detalle->escuela_id);

                DB::commit();

                toastr()->success("El pedido número {$escuela_pedido_detalle->id} fue confirmado.");
            } else {
                toastr()->info("El pedido número {$escuela_pedido_detalle->id} no pudo ser confirmado porque ya no se encuentra en estado de Ingreso.");
            }

            return redirect()->route('escuela_pedido.estado', 1);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error('Error al confirmar el pedido');
            return redirect()->route($this->redireccionarCatch());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EscuelaDetallePedido  $escuela_pedido_detalle
     * @return \Illuminate\Http\Response
     */
    public function destroy(EscuelaDetallePedido $escuela_pedido_detalle)
    {
        try {
            if ($escuela_pedido_detalle->escuela_pedido->estado_pedido_id == 1) {
                DB::beginTransaction();

                $escuela_pedido_detalle->activo = false;
                $escuela_pedido_detalle->save();

                $this->historialPedido(
                    $escuela_pedido_detalle->escuela_pedido->estado_pedido_id,
                    5,
                    $escuela_pedido_detalle->escuela_pedido_id,
                    $escuela_pedido_detalle->escuela_id,
                    "El producto {$escuela_pedido_detalle->producto->codigo} con la cantidad de {$escuela_pedido_detalle->cantidad} artículos fue anulado."
                );

                $escuela_pedido = EscuelaPedido::find($escuela_pedido_detalle->escuela_pedido_id);
                $escuela_pedido->sub_total -= ($escuela_pedido_detalle->sub_total + $escuela_pedido_detalle->descuento);
                $escuela_pedido->descuento -= $escuela_pedido_detalle->descuento;
                $escuela_pedido->total -= $escuela_pedido_detalle->sub_total;
                $escuela_pedido->save();

                DB::commit();

                toastr()->success("El producto {$escuela_pedido_detalle->producto->codigo} fue anulado.");
            } else {
                toastr()->info("El producto {$escuela_pedido_detalle->producto->codigo} no pudo ser anulado porque ya no se encuentra en estado de Ingreso.");
            }

            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error('Error al anular el pedido.');
            return redirect()->route($this->redireccionarCatch());
        }
    }
}
