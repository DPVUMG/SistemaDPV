<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamental;
use Illuminate\Database\QueryException;

class DepartamentalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $items = Departamental::orderBy('nombre', 'asc')->get();
            $departamental = null;
            return view('sistema.catalogo.escuela.departamental.index', compact('items', 'departamental'));
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
            Departamental::create($data);
            toastr()->success('Registro guardado.');
            return redirect()->route('departamental.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar.');
            return redirect()->route('departamental.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Departamental  $departamental
     * @return \Illuminate\Http\Response
     */
    public function edit(Departamental $departamental)
    {
        try {
            $items = Departamental::orderBy('nombre', 'asc')->get();
            return view('sistema.catalogo.escuela.departamental.index', compact('items', 'departamental'));
        } catch (\Throwable $th) {
            toastr()->error('Error al seleccionar el registro.');
            return redirect()->route('departamental.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Departamental  $departamental
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departamental $departamental)
    {
        $this->validate($request, $this->rules($departamental->id), $this->messages());

        try {
            $departamental->nombre = $request->nombre;

            if (!$departamental->isDirty()) {
                toastr()->info('El sistema no detecto cambios nuevos para guardar.');
                return redirect()->route('departamental.index');
            }

            $departamental->save();
            toastr()->success('Registro actualizado.');
            return redirect()->route('departamental.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar la información.');
            return redirect()->route('departamental.edit', ['departamental' => $departamental]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departamental  $departamental
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departamental $departamental)
    {
        try {
            $departamental->delete();
            toastr()->success('Registro eliminado.');
            return redirect()->route('departamental.index');
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro {$departamental->nombre}, porque tiene información asociada.");
                return redirect()->route('departamental.index');
            }
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = array();

        if (is_null($id)) {
            $validar = [
                'nombre' => 'required|max:25|unique:departamental,nombre'
            ];
        } else {
            $validar = [
                'nombre' => "required|max:25|unique:departamental,nombre,{$id}"
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'nombre.required' => 'El nombre de la departamental es obligatorio.',
            'nombre.max'  => 'El nombre debe tener menos de :max caracteres.',
            'nombre.unique'  => 'El nombre de la departamental ingresado ya existe en el sistema.'
        ];
    }
}
