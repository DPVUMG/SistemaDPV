<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EscuelaPedido;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $fecha_actual = date('Y-m-d');
        $fecha_menos_siete_dias = date("Y-m-d", strtotime($fecha_actual . "- 7 days"));

        $data['fecha_actual'] = $fecha_actual;
        $data['fecha_menos_siete_dias'] = $fecha_menos_siete_dias;
        $data['count_ingresado'] = EscuelaPedido::where('estado_pedido_id', 1)->whereBetween('fecha_pedido', [$fecha_menos_siete_dias, $fecha_actual])->count();
        $data['count_confirmado'] = EscuelaPedido::where('estado_pedido_id', 2)->whereBetween('fecha_pedido', [$fecha_menos_siete_dias, $fecha_actual])->count();
        $data['count_entregado'] = EscuelaPedido::where('estado_pedido_id', 3)->whereBetween('fecha_pedido', [$fecha_menos_siete_dias, $fecha_actual])->count();
        $data['count_pagado'] = EscuelaPedido::where('estado_pedido_id', 4)->whereBetween('fecha_pedido', [$fecha_menos_siete_dias, $fecha_actual])->count();
        $data['count_anulado'] = EscuelaPedido::where('estado_pedido_id', 5)->whereBetween('fecha_pedido', [$fecha_menos_siete_dias, $fecha_actual])->count();
        $data['count_cancelado'] = EscuelaPedido::where('estado_pedido_id', 6)->whereBetween('fecha_pedido', [$fecha_menos_siete_dias, $fecha_actual])->count();

        if ($request->ajax()) {
            $data = EscuelaPedido::join('escuela', 'escuela.id', 'escuela_pedido.escuela_id')
                ->select(
                    'escuela_pedido.id AS id',
                    DB::RAW("CONCAT('Pedido #', escuela_pedido.id,' - Escuela ',escuela.establecimiento) AS title"),
                    DB::RAW("CONCAT('Q ',FORMAT(escuela_pedido.sub_total, 2)) AS sub_total"),
                    DB::RAW("CONCAT('Q ',FORMAT(escuela_pedido.descuento, 2)) AS descuento"),
                    DB::RAW("CONCAT('Q ',FORMAT(escuela_pedido.total, 2)) AS total"),
                    'escuela_pedido.fecha_pedido AS start',
                    'escuela_pedido.fecha_entrega AS end'
                )
                ->where('estado_pedido_id', 2)
                ->get();

            return response()->json($data);
        }

        return view('dashboard', compact('data'));
    }
}
