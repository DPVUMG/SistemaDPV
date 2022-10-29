<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use App\Models\PagoPedido;
use App\Models\EstadoPedido;
use App\Models\EscuelaPedido;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PDFController extends Controller
{
    public function pagos_realizados($date_start, $date_end)
    {
        set_time_limit(0);
        $title = "Reporte pagos pendientes";
        $description = null;
        $date = date('d/m/Y');
        $time = date('h:i:s');
        $footer = "Consulta generada en fecha {$date} y hora {$time}";

        $inicio = date('Y-m-d', strtotime($date_start));
        $fin = date('Y-m-d', strtotime($date_end));

        $items = PagoPedido::whereBetween(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), [$inicio, $fin])->orderBy('id', 'DESC')->get();
        $description = "El reporte muestra la información comprendida en el rango de fecha {$date_start} - {$date_end}, el reporte detalla los pedidos que ya fueron pagados.";

        $pdf = PDF::loadView('sistema.pdf.pago_realizado', compact('items', 'title', 'description', 'footer', 'date_start', 'date_end'));
        $nombre_doc = "pago_realizado" . date('dmYHis') . ".pdf";
        return $pdf->stream($nombre_doc);
    }

    public function pagos_pendientes($date_start, $date_end)
    {
        set_time_limit(0);
        $title = "Reporte pagos pendientes";
        $description = null;
        $date = date('d/m/Y');
        $time = date('h:i:s');
        $footer = "Consulta generada en fecha {$date} y hora {$time}";

        $inicio = date('Y-m-d', strtotime($date_start));
        $fin = date('Y-m-d', strtotime($date_end));

        $items = EscuelaPedido::whereBetween('fecha_pedido', [$inicio, $fin])->where('pagado', false)->where('estado_pedido_id', 3)->orderBy('id', 'DESC')->get();
        $description = "El reporte muestra la información comprendida en el rango de fecha {$date_start} - {$date_end}, el reporte detalla los pedidos que están pendientes de cobrar.";

        $pdf = PDF::loadView('sistema.pdf.pago_pendiente', compact('items', 'title', 'description', 'footer', 'date_start', 'date_end'));
        $nombre_doc = "pago_pendiente" . date('dmYHis') . ".pdf";
        return $pdf->stream($nombre_doc);
    }

    public function pedidos_escuelas($escuela_id)
    {
        set_time_limit(0);
        $title = "Reporte de pedidos de la escuela";
        $description = null;
        $date = date('d/m/Y');
        $time = date('h:i:s');
        $footer = "Consulta generada en fecha {$date} y hora {$time}";

        foreach (EstadoPedido::get() as $value) {
            $items[$value->id] = EscuelaPedido::where('escuela_id', $escuela_id)->where('estado_pedido_id', $value->id)->orderBy('id', 'DESC')->get();
        }
        $escuela  = Escuela::find($escuela_id);
        $description = "El reporte muestra la información de los pedidos realizados por la escuela {$escuela->establecimiento} - {$escuela->plan} {$escuela->jornada} seleccionada.";

        $pdf = PDF::loadView('sistema.pdf.pedido_escuela', compact('items', 'title', 'description', 'footer', 'escuela'));
        $nombre_doc = "pedido_escuela" . date('dmYHis') . ".pdf";
        return $pdf->stream($nombre_doc);
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
