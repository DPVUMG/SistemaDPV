<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class NivelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $items = Nivel::orderBy('nombre', 'asc')->get();
            $nivel = null;
            return view('sistema.catalogo.escuela.nivel.index', compact('items', 'nivel'));
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
            Nivel::create($data);
            toastr()->success('Registro guardado.');
            return redirect()->route('nivel.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar.');
            return redirect()->route('nivel.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nivel  $nivel
     * @return \Illuminate\Http\Response
     */
    public function edit(Nivel $nivel)
    {
        try {
            $items = Nivel::orderBy('nombre', 'asc')->get();
            return view('sistema.catalogo.escuela.nivel.index', compact('items', 'nivel'));
        } catch (\Throwable $th) {
            toastr()->error('Error al seleccionar el registro.');
            return redirect()->route('nivel.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nivel  $nivel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nivel $nivel)
    {
        $this->validate($request, $this->rules($nivel->id), $this->messages());

        try {
            $nivel->codigo = $request->codigo;
            $nivel->nombre = $request->nombre;

            if (!$nivel->isDirty()) {
                toastr()->info('El sistema no detecto cambios nuevos para guardar.');
                return redirect()->route('nivel.index');
            }

            $nivel->save();
            toastr()->success('Registro actualizado.');
            return redirect()->route('nivel.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar la información.');
            return redirect()->route('nivel.edit', ['nivel' => $nivel]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nivel  $nivel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nivel $nivel)
    {
        try {
            $nivel->delete();
            toastr()->success('Registro eliminado.');
            return redirect()->route('nivel.index');
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro {$nivel->nombre}, porque tiene información asociada.");
                return redirect()->route('nivel.index');
            }
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = array();

        if (is_null($id)) {
            $validar = [
                'nombre' => 'required|max:25|unique:nivel,nombre',
                'codigo' => 'required|integer|unique:nivel,codigo'
            ];
        } else {
            $validar = [
                'nombre' => "required|max:25|unique:nivel,nombre,{$id}",
                'codigo' => "required|integer|unique:nivel,codigo,{$id}"
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'nombre.required' => 'El nombre del nivel es obligatorio.',
            'nombre.max'  => 'El nombre debe tener menos de :max caracteres.',
            'nombre.unique'  => 'El nombre del nivel ingresado ya existe en el sistema.',

            'codigo.required' => 'El codigo del nivel es obligatorio.',
            'codigo.integer'  => 'El codigo debe tener un número entero.',
            'codigo.unique'  => 'El codigo del nivel ingresado ya existe en el sistema.'
        ];
    }
}
