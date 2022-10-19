<?php

namespace App\Http\Controllers;

use App\Models\EscuelaPedido;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $fecha_actual = date('Y-m-d');
        $fecha_menos_siete_dias = date("d-m-Y", strtotime($fecha_actual . "- 7 days"));

        $data['count_ingresado'] = EscuelaPedido::where('estado_pedido_id', 1)->whereBetween('fecha_pedido', [$fecha_menos_siete_dias, $fecha_actual])->count();
        $data['count_confirmado'] = EscuelaPedido::where('estado_pedido_id', 2)->whereBetween('fecha_pedido', [$fecha_menos_siete_dias, $fecha_actual])->count();
        $data['count_entregado'] = EscuelaPedido::where('estado_pedido_id', 3)->whereBetween('fecha_pedido', [$fecha_menos_siete_dias, $fecha_actual])->count();
        $data['count_pagado'] = EscuelaPedido::where('estado_pedido_id', 4)->whereBetween('fecha_pedido', [$fecha_menos_siete_dias, $fecha_actual])->count();
        $data['count_anulado'] = EscuelaPedido::where('estado_pedido_id', 5)->whereBetween('fecha_pedido', [$fecha_menos_siete_dias, $fecha_actual])->count();
        $data['count_cancelado'] = EscuelaPedido::where('estado_pedido_id', 6)->whereBetween('fecha_pedido', [$fecha_menos_siete_dias, $fecha_actual])->count();

        return view('dashboard', compact('data'));
    }
}
