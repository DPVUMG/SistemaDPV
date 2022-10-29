<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\EscuelaPedido;
use App\Models\Mes;
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
        } else {
            $anio = date('Y');
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

            $items = DB::table('mes')
                ->select(
                    'mes.nombre AS mes_nombre',
                    DB::RAW("(SELECT SUM(pago_pedido.monto) FROM pago_pedido WHERE pago_pedido.mes_id = mes.id AND YEAR(created_at) = {$anio}) AS total")
                )
                ->groupBy('mes_nombre')
                ->orderBy('id')
                ->get();

            $data['graficaPagoMensual'] = array();
            foreach ($items as $key => $value) {
                array_push($data['graficaPagoMensual'], is_null($value->total) ? 0 : floatval($value->total));
            }

            $items = DB::table('escuela_pedido')
                ->join('escuela', 'escuela.id', 'escuela_pedido.escuela_id')
                ->select(
                    DB::RAW("CONCAT(escuela.establecimiento,' - ',escuela.plan,' ',escuela.jornada) AS nombre_escuela"),
                    DB::RAW("SUM(escuela_pedido.total) AS monto_total")
                )
                ->whereIn('escuela_pedido.estado_pedido_id', [3, 4])
                ->where('escuela_pedido.anio', date('Y'))
                ->groupBy('nombre_escuela')
                ->orderByDesc('monto_total')
                ->limit(10)
                ->get();

            $data['graficaPedidoInversion']['categories'] = array();
            $data['graficaPedidoInversion']['data'] = array();

            foreach ($items as $key => $value) {
                array_push($data['graficaPedidoInversion']['categories'], $value->nombre_escuela);
                array_push($data['graficaPedidoInversion']['data'], is_null($value->monto_total) ? 0 : round($value->monto_total, 2));
            }

            $items = DB::table('escuela_pedido')
                ->join('escuela', 'escuela.id', 'escuela_pedido.escuela_id')
                ->select(
                    DB::RAW("CONCAT(escuela.establecimiento,' - ',escuela.plan,' ',escuela.jornada) AS nombre_escuela"),
                    DB::RAW("COUNT(escuela_pedido.estado_pedido_id) AS pedidos")
                )
                ->whereIn('escuela_pedido.estado_pedido_id', [3, 4])
                ->where('escuela_pedido.anio', date('Y'))
                ->groupBy('nombre_escuela')
                ->orderByDesc('pedidos')
                ->limit(10)
                ->get();

            $data['graficaPedidoSolicitados']['categories'] = array();
            $data['graficaPedidoSolicitados']['data'] = array();

            foreach ($items as $key => $value) {
                array_push($data['graficaPedidoSolicitados']['categories'], $value->nombre_escuela);
                array_push($data['graficaPedidoSolicitados']['data'], $value->pedidos);
            }

            $data['graficaIngresosGastos']['categories'] = array();
            $data['graficaIngresosGastos']['series'] = array();

            $meses = Mes::orderBy('id', 'ASC')->get();
            foreach ($meses as $key => $mes) {
                array_push($data['graficaIngresosGastos']['categories'], $mes->nombre);
            }

            $item['name'] = 'Ingresos';
            $item['color'] = 'rgba(0,255,0,1)';
            $item['data'] = array();
            foreach ($meses as $key => $mes) {
                $info = DB::table('pago_pedido')
                    ->select(
                        DB::RAW("SUM(pago_pedido.monto) AS monto_total")
                    )
                    ->where('pago_pedido.anio', date('Y'))
                    ->where('pago_pedido.mes_id', $mes->id)
                    ->first();

                array_push($item['data'], is_null($info->monto_total) ? 0 : floatval($info->monto_total));
            }
            $item['tooltip']['valuePrefix'] = 'Q ';
            array_push($data['graficaIngresosGastos']['series'], (object) $item);

            $item['name'] = 'Gastos';
            $item['color'] = 'rgba(255,0,0,1)';
            $item['data'] = array();
            foreach ($meses as $key => $mes) {
                $info = DB::table('gasto')
                    ->select(
                        DB::RAW("SUM(gasto.monto) AS monto_total")
                    )
                    ->where('gasto.anio', date('Y'))
                    ->where('gasto.mes_id', $mes->id)
                    ->first();

                array_push($item['data'], is_null($info->monto_total) ? 0 : floatval($info->monto_total));
            }
            $item['tooltip']['valuePrefix'] = 'Q ';
            array_push($data['graficaIngresosGastos']['series'], (object) $item);

            return view('dashboard', compact('data'));
        }
    }
}
