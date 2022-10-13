<?php

namespace App\Http\Controllers;

use App\Models\Distrito;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class DistritoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $items = Distrito::orderBy('codigo', 'asc')->get();
            $distrito = null;
            return view('sistema.catalogo.escuela.distrito.index', compact('items', 'distrito'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages());

        try {
            $data = $request->all();
            Distrito::create($data);
            toastr()->success('Registro guardado.');
            return redirect()->route('distrito.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar.');
            return redirect()->route('distrito.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Distrito  $distrito
     * @return \Illuminate\Http\Response
     */
    public function edit(Distrito $distrito)
    {
        try {
            $items = Distrito::orderBy('codigo', 'asc')->get();
            return view('sistema.catalogo.escuela.distrito.index', compact('items', 'distrito'));
        } catch (\Throwable $th) {
            toastr()->error('Error al seleccionar el registro.');
            return redirect()->route('distrito.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Distrito  $distrito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Distrito $distrito)
    {
        $this->validate($request, $this->rules($distrito->id), $this->messages());

        try {
            $distrito->codigo = $request->codigo;

            if (!$distrito->isDirty()) {
                toastr()->info('El sistema no detecto cambios nuevos para guardar.');
                return redirect()->route('distrito.index');
            }

            $distrito->save();
            toastr()->success('Registro actualizado.');
            return redirect()->route('distrito.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar la información.');
            return redirect()->route('distrito.edit', ['distrito' => $distrito]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Distrito  $distrito
     * @return \Illuminate\Http\Response
     */
    public function destroy(Distrito $distrito)
    {
        try {
            $distrito->delete();
            toastr()->success('Registro eliminado.');
            return redirect()->route('distrito.index');
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro {$distrito->codigo}, porque tiene información asociada.");
                return redirect()->route('distrito.index');
            }
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = array();

        if (is_null($id)) {
            $validar = [
                'codigo' => 'required|max:10|unique:distrito,codigo'
            ];
        } else {
            $validar = [
                'codigo' => "required|max:10|unique:distrito,codigo,{$id}"
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'codigo.required' => 'El codigo del distrito es obligatorio.',
            'codigo.max'  => 'El codigo debe tener menos de :max caracteres.',
            'codigo.unique'  => 'El codigo del distrito ingresado ya existe en el sistema.'
        ];
    }
}
