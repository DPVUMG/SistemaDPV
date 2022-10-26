<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Banco;
use App\Models\PagoPedido;
use Illuminate\Http\Request;
use App\Models\EscuelaPedido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class PagoPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $items = PagoPedido::orderBy('id', 'asc')
                ->get();

            $bancos = Banco::orderBy('nombre', 'asc')->get();
            $pedidos = EscuelaPedido::join('escuela', 'escuela.id', 'escuela_pedido.escuela_id')
                ->select(
                    'escuela_pedido.id AS id',
                    'escuela.establecimiento AS escuela',
                    DB::RAW("CONCAT('Pedido #',escuela_pedido.id,' | Q ',FORMAT(escuela_pedido.total,2)) AS pedido")
                )
                ->where('escuela_pedido.estado_pedido_id', 3)
                ->orderBy('id', 'asc')
                ->get();

            return view('sistema.pago.index', compact('items', 'bancos', 'pedidos'));
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
        $this->validate($request, [
            'numero_cheque' => 'required|integer|between:1,100000',
            'monto' => 'required|numeric|between:1,100000',
            'banco_id' => 'required|integer|exists:banco,id',
            'escuela_pedido_id.*' => 'required|integer|exists:escuela_pedido,id',
        ], [
            'numero_cheque.required' => 'El número de cheque es obligatorio.',
            'numero_cheque.integer'  => 'El número de cheque debe de ser un número entero.',
            'numero_cheque.between'  => 'El número de cheque debe ser un valor entre :min y :max.',

            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric'  => 'El monto debe de ser un número.',
            'monto.between'  => 'El monto debe ser un valor entre :min y :max.',

            'banco_id.required' => 'El banco es obligatorio.',
            'banco_id.integer'  => 'El banco debe de ser un número entero.',
            'banco_id.exists'  => 'El banco seleccionado no existe.',

            'escuela_pedido_id.*.required' => 'El pedido es obligatorio.',
            'escuela_pedido_id.*.integer'  => 'El pedido debe de ser un número entero.',
            'escuela_pedido_id.*.exists'  => 'El pedido seleccionado no existe.'
        ]);

        try {
            DB::beginTransaction();

            $existe = PagoPedido::where('banco_id', $request->banco_id)->where('numero_cheque', $request->numero_cheque)->first();
            $banco = Banco::find($request->banco_id);

            if (!is_null($existe)) {
                throw new Exception("El número de cheque {$request->numero_cheque} ya fue registrado para el banco {$banco->nombre}.", 1000);
            }

            $total = 0;
            foreach ($request->escuela_pedido_id as $pedido) {

                $pedido_select = EscuelaPedido::find($pedido);
                $pedido_select->estado_pedido_id = 4;
                $pedido_select->save();

                $total += $pedido_select->total;

                PagoPedido::create(
                    [
                        'numero_cheque' => $request->numero_cheque,
                        'tipo_pago' => PagoPedido::CHEQUE,
                        'anio' => date('Y'),
                        'mes_id' => date('m'),
                        'escuela_id' => $pedido_select->escuela_id,
                        'escuela_pedido_id' => $pedido_select->id,
                        'banco_id' => $banco->id,
                        'monto' => $pedido_select->total,
                        'usuario_id' => Auth::user()->id
                    ]
                );

                $this->historialPedido($pedido_select->estado_pedido_id, 4, $pedido_select->id, $pedido_select->escuela_id);
            }

            $monto = number_format($request->monto, 2, '.', ',');
            $monto_formato = number_format($total, 2, '.', ',');

            if ($total != $request->monto) {
                throw new Exception("El monto {$monto} del cheque {$request->numero_cheque} no cubre el cuadra con el monto total {$monto_formato} de los pedidos seleccionados", 1000);
            }

            DB::commit();

            toastr()->success('Registro guardado.');

            return redirect()->route('pago.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            if ($th->getCode() == 1000)
                toastr()->info($th->getMessage());
            else
                toastr()->error('Error al guardar.');

            return redirect()->route('pago.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PagoPedido  $pago
     * @return \Illuminate\Http\Response
     */
    public function show(PagoPedido $pago)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PagoPedido  $pago
     * @return \Illuminate\Http\Response
     */
    public function destroy(PagoPedido $pago)
    {
        try {
            $fecha_eliminar = date('Ymd', strtotime($pago->created_at));
            $fecha_actual = date('Ymd');

            if ($fecha_eliminar == $fecha_actual) {
                throw new Exception("No puede eliminar el pago porque es un registro histórico.", 1000);
            }

            DB::beginTransaction();

            $pago->delete();
            $pedido_select = EscuelaPedido::find($pago->escuela_pedido_id);
            $pedido_select->estado_pedido_id = 3;
            $pedido_select->save();

            $this->historialPedido($pedido_select->estado_pedido_id, 3, $pedido_select->id, $pedido_select->escuela_id, "El pago número {$pago->id} fue anulado para el pago del pedido número {$pedido_select->id}");

            DB::commit();

            toastr()->success('Registro eliminado.');
            return redirect()->route('pago.index');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($e->getCode() == 1000) {
                toastr()->info($e->getMessage());
            } else if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro {$pago->id}, porque tiene información asociada.");
            } else {
                toastr()->error("Error en el controlador.");
            }

            return redirect()->route('pago.index');
        }
    }
}
