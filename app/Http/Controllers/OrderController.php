<?php

namespace App\Http\Controllers;

use App\Order;
use App\Credit;
use App\Detail;
use App\Product;
use App\RequestCredit;
use App\Traicing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    ///Vista de la pantalla de todos los registros
    public function index(Request $request)
    {
        if($request->has('search'))
            $items = Order::search($request->search)->orderBy('id','asc')->paginate(10);
        else
            $items = Order::orderBy('id','asc')->paginate(10);

        return view('system.order.index', compact('items'));
    }

    ///Vista de la pantalla de todos los registros del pedido
    public function show(Order $order)
    {
        $tipo_credito = null;
        $detalle = Detail::where('order_id', $order->id)->get();
        if($order->status == Order::CREDITO)
        {
            $credito = RequestCredit::where('order_id', $order->id)->first();
            $tipo_credito = Credit::find($credito->credit_id);
        }
        return view('system.order.show', compact('order','detalle','tipo_credito'));
    }

    ///Cambiar de proceso la orden
    public function update(Order $order)
    {
        try {
            DB::beginTransaction();

                switch($order->status)
                {
                    case Order::PEDIDO:
                        $order->status = Order::PROCESO;
                        toastr()->success("El pedido #{$order->id} ahora se encuentra en la etapa de {$order->status}.");
                    break;

                    case Order::PROCESO:
                        $order->status = Order::FACTURADO;
                        $order->employee_id = Auth::user()->id;
                        $credito = RequestCredit::where('order_id',$order->id)->first();
                        if(!is_null($credito))
                        {
                            $credito->current = true;
                             $credito->save();  
                        }

                        toastr()->success("El pedido #{$order->id} ahora se encuentra en la etapa de {$order->status}.");
                    break;

                    case Order::FACTURADO:
                        $order->status = Order::ENTREGADO;
                        toastr()->success("El pedido #{$order->id} ahora se encuentra en la etapa de {$order->status}.");
                    break;

                    default:
                        toastr()->error("El pedido #{$order->id} aun se encuentra en {$order->status}.");
                    break;
                }

                $order->save();

                $insert = new Traicing();
                $insert->status = $order->status;
                $insert->order_id = $order->id;
                $insert->user_id = Auth::user()->id;
                $insert->save();

            DB::commit();
            return redirect()->route('sistema.home');

        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error($e->getMessage());
            return redirect()->route('sistema.home');
        }
    }

    //Anular pedido
    public function delete(Order $order)
    {
        try {
            DB::beginTransaction();

                $order->status = Order::ANULADO;
                $order->save();

                $detalle = Detail::where('order_id', $order->id)->get();

                foreach ($detalle as $value) {
                    $producto = Product::find($value->product_id);
                    $producto->stock += $value->quantity;
                    $producto->save();
                }

                $insert = new Traicing();
                $insert->status = $order->status;
                $insert->order_id = $order->id;
                $insert->user_id = Auth::user()->id;
                $insert->save();

            DB::commit();

            toastr()->success("El pedido #{$order->id} ahora se encuentra {$order->status}.");
            return redirect()->route('sistema.home');
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error($e->getMessage());
            return redirect()->route('sistema.home');
        }
    }
}
