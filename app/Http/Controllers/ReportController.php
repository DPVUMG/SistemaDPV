<?php

namespace App\Http\Controllers;

use App\Credit;
use App\Order;
use App\RequestCredit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function traicing(Request $request)
    {
        $title = "Reporte del recorrido del pedido";
        $description = null;
        $date = date('d/m/Y');
        $time = date('h:i:s');
        $footer = "Con sulta generada en fecha {$date} y hora {$time}";
        $month = null;

        $items = null;

        if($request->has('month'))
        {
            $this->validate($request, $this->rules(true,false,false), $this->messages());
            $items = Order::with('traicings')->whereMonth('created_at', $request->month)->whereYear('created_at', 2020)->orderBy('id','DESC')->paginate(10);
            $description = "El reporte muestra la información del mes de {$this->devuelveMes($request->month)}, el reporte detalla los pedidos con su respectivo recorrido de cambio de estado.";
            $month = $request->month;
        }

        return view('system.report.traicing', compact('items','title','description','footer','month'));
    }

    public function credit(Request $request)
    {
        $title = "Reporte créditos pendientes por cobrar";
        $description = null;
        $date = date('d/m/Y');
        $time = date('h:i:s');
        $footer = "Con sulta generada en fecha {$date} y hora {$time}";
        $date_start = null;
        $date_end = null;

        $items = null;

        if($request->has('date_start') && $request->has('date_end'))
        {
            $inicio = date('d/m/Y', strtotime($request->date_start));
            $fin = date('d/m/Y', strtotime($request->date_end));

            $this->validate($request, $this->rules(false,true,false), $this->messages());
            $items = RequestCredit::with('credit')->whereBetween('date_start',[$request->date_start,$request->date_end])->where('payment',false)->where('current',true)->orderBy('id','DESC')->paginate(10);
            $description = "El reporte muestra la información comprendida en el rango de fecha {$inicio} - {$fin}, el reporte detalla los pedidos que están pendientes de cobrar.";
            $date_start = $request->date_start;
            $date_end = $request->date_end;
        }

        return view('system.report.credit', compact('items','title','description','footer','date_start','date_end'));
    }

    public function client(Request $request)
    {
        $title = "Reporte de información del cliente";
        $description = null;
        $date = date('d/m/Y');
        $time = date('h:i:s');
        $footer = "Con sulta generada en fecha {$date} y hora {$time}";
        $user_id = null;
        $clientes = User::where('id','!=',Auth::user()->id)->get();

        $client = null;
        $pedidos_creditos = null;
        $pedidos_contado = null;
        $pagar = null;
        $creditos = null;

        if($request->has('user_id'))
        {
            $this->validate($request, $this->rules(false,false,true), $this->messages());

            $client = User::find($request->user_id);
            $pedidos_creditos = Order::where('user_id',$client->id)->where('type_payment',Order::CREDITO)->where('status','!=',Order::ANULADO)->orderBy('id','DESC')->paginate(10);
            $pedidos_contado = Order::where('user_id',$client->id)->where('type_payment',Order::CONTADO)->where('status','!=',Order::ANULADO)->orderBy('id','DESC')->paginate(10);
            $pagar = RequestCredit::with('credit')->where('user_id',$client->id)->where('payment',false)->where('current',true)->orderBy('id','DESC')->paginate(10);
            $creditos = Credit::where('user_id',$client->id)->orderBy('id','DESC')->paginate(10);

            $description = "El reporte muestra la información del cliente {$client->name}, el reporte detalla la información de pedidos, créditos, etc.";
            $user_id = $request->user_id;
        }

        return view('system.report.client', compact('clientes','client','pedidos_creditos','pedidos_contado','pagar','creditos','title','description','footer','user_id'));
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
