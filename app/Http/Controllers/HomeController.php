<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Order;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pedidos = Order::where('status', Order::PEDIDO)->paginate(5);
        $procesos = Order::where('status', Order::PROCESO)->paginate(5);
        $facturados = Order::where('status', Order::FACTURADO)->paginate(5);
        $entregados = Order::where('status', Order::ENTREGADO)->paginate(5);
        $anulados = Order::where('status', Order::ANULADO)->paginate(5);

        $fecha_actual = date("d-m-Y");
        $desactivar_nuevo = date("Y-m-d", strtotime($fecha_actual . "- 6 days"));

        Producto::whereDate('created_at', '<', $desactivar_nuevo)->update(['nuevo' => false]);

        return view('dashboard', compact('pedidos', 'procesos', 'facturados', 'entregados', 'anulados'));
    }
}
