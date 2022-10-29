<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use Illuminate\Http\Request;
use App\Models\EscuelaPedido;
use App\Models\EstadoPedido;
use App\Models\PagoPedido;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        return view('sistema.reporte.index');
    }

    public function pagos_realizados(Request $request)
    {
        $title = "Reporte pagos realizados";
        $description = null;
        $date = date('d/m/Y');
        $time = date('h:i:s');
        $footer = "Con sulta generada en fecha {$date} y hora {$time}";
        $date_start = null;
        $date_end = null;

        $items = null;

        if ($request->has('date_start') && $request->has('date_end')) {
            $inicio = date('Y-m-d', strtotime($request->date_start));
            $fin = date('Y-m-d', strtotime($request->date_end));

            $this->validate($request, $this->rules(false, true, false), $this->messages());
            $items = PagoPedido::whereBetween(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), [$inicio, $fin])->orderBy('id', 'DESC')->get();
            $description = "El reporte muestra la información comprendida en el rango de fecha {$request->date_start} - {$request->date_end}, el reporte detalla los pedidos que ya fueron pagados.";
            $date_start = $request->date_start;
            $date_end = $request->date_end;
        }

        return view('sistema.reporte.pago_realizado', compact('items', 'title', 'description', 'footer', 'date_start', 'date_end'));
    }

    public function pagos_pendientes(Request $request)
    {
        $title = "Reporte pagos pendientes";
        $description = null;
        $date = date('d/m/Y');
        $time = date('h:i:s');
        $footer = "Con sulta generada en fecha {$date} y hora {$time}";
        $date_start = null;
        $date_end = null;

        $items = null;

        if ($request->has('date_start') && $request->has('date_end')) {
            $inicio = date('Y-m-d', strtotime($request->date_start));
            $fin = date('Y-m-d', strtotime($request->date_end));

            $this->validate($request, $this->rules(false, true, false), $this->messages());
            $items = EscuelaPedido::whereBetween('fecha_pedido', [$inicio, $fin])->where('pagado', false)->where('estado_pedido_id', 3)->orderBy('id', 'DESC')->get();
            $description = "El reporte muestra la información comprendida en el rango de fecha {$request->date_start} - {$request->date_end}, el reporte detalla los pedidos que están pendientes de cobrar.";
            $date_start = $request->date_start;
            $date_end = $request->date_end;
        }

        return view('sistema.reporte.pago_pendiente', compact('items', 'title', 'description', 'footer', 'date_start', 'date_end'));
    }

    public function pedidos_escuelas(Request $request)
    {
        $title = "Reporte de pedidos de la escuela";
        $description = null;
        $date = date('d/m/Y');
        $time = date('h:i:s');
        $footer = "Con sulta generada en fecha {$date} y hora {$time}";
        $escuela_id = null;

        $items = null;

        if ($request->has('escuela_id')) {
            $this->validate($request, $this->rules(false, false, true), $this->messages());
            $escuela_id = $request->escuela_id;
            foreach (EstadoPedido::get() as $value) {
                $items[$value->id] = EscuelaPedido::where('escuela_id', $escuela_id)->where('estado_pedido_id', $value->id)->orderBy('id', 'DESC')->get();
            }
            $escuela  = Escuela::find($escuela_id);
            $description = "El reporte muestra la información de los pedidos realizados por la escuela {$escuela->establecimiento} - {$escuela->plan} {$escuela->jornada} seleccionada.";
        }

        return view('sistema.reporte.pedido_escuela', compact('items', 'title', 'description', 'footer', 'escuela_id'));
    }

    //Reglas de validaciones
    public function rules($mes, $fechas, $escuela)
    {
        $validar = array();

        if ($mes) {
            $validar = [
                'mes_id' => 'required|integer|exists:mes,id'
            ];
        } elseif ($fechas) {
            $validar = [
                'date_start' => 'required|date',
                'date_end' => 'required|date|after_or_equal:date_start'
            ];
        } elseif ($escuela) {
            $validar = [
                'escuela_id' => 'required|integer|exists:escuela,id'
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages()
    {
        return [
            'mes_id.required' => 'El mes es obligatorio.',
            'mes_id.integer'  => 'El mes debe de ser un número entero.',
            'mes_id.exists'  => 'El mes seleccionado no existe.',

            'date_start.required' => 'La primer fecha es obligatoria.',
            'date_start.date'  => 'La información ingresada no tiene formato de fecha.',
            'date_end.required' => 'La segunda fecha es obligatoria.',
            'date_end.date'  => 'La información ingresada no tiene formato de fecha.',
            'date_end.after_or_equal'  => 'La segunda fecha tiene que ser mayor o igual que la primer fecha seleccionada.',

            'escuela_id.required' => 'La escuela es obligatorio.',
            'escuela_id.integer'  => 'La escuela debe de ser un número entero.',
            'escuela_id.exists'  => 'La escuela seleccionado no existe.'
        ];
    }
}
