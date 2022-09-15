<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Credit;
use App\RequestCredit;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    public function traicing($month)
    {
        set_time_limit(0);
        $title = "Reporte del recorrido del pedido";
        $description = null;
        $date = date('d/m/Y');
        $time = date('h:i:s');
        $footer = "Con sulta generada en fecha {$date} y hora {$time}";

        $items = Order::with('traicings')->whereMonth('created_at', $month)->whereYear('created_at', 2020)->orderBy('id','DESC')->get();
        $description = "El reporte muestra la información del mes de {$this->devuelveMes($month)}, el reporte detalla los pedidos con su respectivo recorrido de cambio de estado.";

        $pdf = PDF::loadView('system.pdf.traicing', compact('items','title','description','footer','month'));
        return $pdf->stream('traicing.pdf');
    }

    public function credit($date_start,$date_end)
    {
        set_time_limit(0);
        $title = "Reporte créditos pendientes por cobrar";
        $description = null;
        $date = date('d/m/Y');
        $time = date('h:i:s');
        $footer = "Con sulta generada en fecha {$date} y hora {$time}";

        $inicio = date('d/m/Y', strtotime($date_start));
        $fin = date('d/m/Y', strtotime($date_end));

        $items = RequestCredit::with('credit')->whereBetween('date_start',[$date_start,$date_end])->where('payment',false)->where('current',true)->orderBy('id','DESC')->get();
        $description = "El reporte muestra la información comprendida en el rango de fecha {$inicio} - {$fin}, el reporte detalla los pedidos que están pendientes de cobrar.";

        $pdf = PDF::loadView('system.pdf.credit', compact('items','title','description','footer','date_start','date_end'));
        return $pdf->stream('credit.pdf');
    }

    public function client($user_id)
    {
        set_time_limit(0);
        $title = "Reporte de información del cliente";
        $description = null;
        $date = date('d/m/Y');
        $time = date('h:i:s');
        $footer = "Con sulta generada en fecha {$date} y hora {$time}";

        $client = User::find($user_id);
        $pedidos_creditos = Order::where('user_id',$client->id)->where('type_payment',Order::CREDITO)->where('status','!=',Order::ANULADO)->orderBy('id','DESC')->get();
        $pedidos_contado = Order::where('user_id',$client->id)->where('type_payment',Order::CONTADO)->where('status','!=',Order::ANULADO)->orderBy('id','DESC')->get();
        $pagar = RequestCredit::with('credit')->where('user_id',$client->id)->where('payment',false)->where('current',true)->orderBy('id','DESC')->get();
        $creditos = Credit::where('user_id',$client->id)->orderBy('id','DESC')->get();
        $description = "El reporte muestra la información del cliente {$client->name}, el reporte detalla la información de pedidos, créditos, etc.";

        $pdf = PDF::loadView('system.pdf.client', compact('client','pedidos_creditos','pedidos_contado','pagar','creditos','title','description','footer','user_id'));
        return $pdf->stream('client.pdf');
    }

    public function devuelveMes($mes_en_numero)
    {
        $mes = '';

        switch ($mes_en_numero) {
            case 1:
                $mes = 'Enero';
                break;

            case 2:
                $mes = 'Febrero';
                break;

            case 3:
                $mes = 'Marzo';
                break;

            case 4:
                $mes = 'Abril';
                break;

            case 5:
                $mes = 'Mayo';
                break;

            case 6:
                $mes = 'Junio';
                break;

            case 7:
                $mes = 'Julio';
                break;

            case 8:
                $mes = 'Agosto';
                break;

            case 9:
                $mes = 'Septiembre';
                break;

            case 10:
                $mes = 'Octubre';
                break;

            case 11:
                $mes = 'Noviembre';
                break;

            case 12:
                $mes = 'Diciembre';
                break;
        }

        return $mes;
    }

    //Reglas de validaciones
    public function rules($traicing,$credit,$client)
    {
        $validar = array();

        if($traicing)
        {
            $validar = [
                'month'=>'required|starts_with:1,2,3,4,5,6,7,8,9,10,11,12'
            ];
        }
        elseif ($credit)
        {
            $validar = [
                'date_start'=>'required|date',
                'date_end'=>'required|date|after_or_equal:date_start'
            ];
        }
        elseif ($client)
        {
            $validar = [
                'user_id' => 'required|integer|exists:users,id'
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages()
    {
        return [
            'month.required' => 'El mes es obligatorio.',
            'month.starts_with'  => 'El mes no es correcto.',

            'date_start.required' => 'La primer fecha es obligatoria.',
            'date_start.date'  => 'La información ingresada no tiene formato de fecha.',
            'date_end.required' => 'La segunda fecha es obligatoria.',
            'date_end.date'  => 'La información ingresada no tiene formato de fecha.',
            'date_end.after_or_equal'  => 'La segunda fecha tiene que ser mayor o igual que la primer fecha seleccionada.',

            'user_id.required' => 'El cliente es obligatorio.',
            'user_id.integer'  => 'El cliente debe de ser un número entero.',
            'user_id.exists'  => 'El cliente seleccionado no existe.'
        ];
    }
}
