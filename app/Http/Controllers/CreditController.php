<?php

namespace App\Http\Controllers;

use App\Credit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Credit::orderBy('id','desc')->where('approved',Credit::EN_ESPERA)->paginate(10);

        return view('system.credit.index', compact('items'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        $items = Credit::orderBy('id','desc')->where('approved','!=',Credit::EN_ESPERA)->paginate(10);

        return view('system.credit.history', compact('items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Credit $credit)
    {
        $this->validate($request, $this->rules($credit->id), $this->messages());
        try {
            DB::beginTransaction();
                $credit->approved = $request->approved;
                $credit->current = true;
                $credit->employee_id = Auth::user()->id;
                $credit->save();

                if($credit->approved == Credit::APROVADO_SI)
                {
                    $creditos = Credit::where('user_id',$credit->user_id)->get();

                    foreach ($creditos as $value)
                    {
                        if($value->id != $credit->id)
                        {
                            $value->current = false;
                            $value->save();
                        }
                    }
                }
            DB::commit();

            toastr()->success('Registro del crédito aprovado: '.$credit->approved);
            return redirect()->route('credit.index');
        } catch (\Exception $e)
        {
            DB::rollback();
            toastr()->error("Error al responder a la aprobación del crédito solicitado.");
            return redirect()->route('credit.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Credit $credit)
    {
        $credit->current = false;
        $credit->save();
        toastr()->success('Crédito anulado.');
        return redirect()->route('credit.index');
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = array();

        if(is_null($id))
        {
            $validar = [
                'approved'=>'required|starts_with:SI,NO'
            ];
        }
        else
        {
            $validar = [
                'approved'=>'required|starts_with:SI,NO'
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'approved.required' => 'El valor de aprobación es obligatorio.',
            'approved.starts_with'  => 'El valor de aprobación no es correcto.',
        ];
    }
}
