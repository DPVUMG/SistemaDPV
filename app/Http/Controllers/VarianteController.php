<?php

namespace App\Http\Controllers;

use App\Models\Variante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class VarianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('search'))
                $items = Variante::search($request->search)->orderBy('nombre', 'asc')->paginate(10);
            else
                $items = Variante::orderBy('nombre', 'asc')->paginate(10);

            return view('sistema.catalogo.variante.index', compact('items'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route($this->redireccionarCatch());
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
            $data['usuario_id'] = Auth::user()->id;
            Variante::create($data);
            toastr()->success('Registro guardado.');
            return redirect()->route('variante.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar.');
            return redirect()->route('variante.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Variante  $variante
     * @return \Illuminate\Http\Response
     */
    public function edit(Variante $variante)
    {
        try {
            return view('sistema.catalogo.variante.edit', compact('variante'));
        } catch (\Throwable $th) {
            toastr()->error('Error al seleccionar el registro.');
            return redirect()->route('variante.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Variante  $variante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variante $variante)
    {
        $this->validate($request, $this->rules($variante->id), $this->messages());

        try {
            $variante->nombre = $request->nombre;

            if (!$variante->isDirty()) {
                toastr()->info('El sistema no detecto cambios nuevos para guardar.');
                return redirect()->route('variante.index');
            }

            $variante->save();
            toastr()->success('Registro actualizado.');
            return redirect()->route('variante.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar la información.');
            return redirect()->route('variante.edit', ['variante' => $variante]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Variante  $variante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variante $variante)
    {
        try {
            $variante->delete();
            toastr()->success('Registro eliminado.');
            return redirect()->route('variante.index');
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro {$variante->nombre}, porque tiene información asociada.");
                return redirect()->route('variante.index');
            }
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = array();

        if (is_null($id)) {
            $validar = [
                'nombre' => 'required|max:15|unique:variante,nombre'
            ];
        } else {
            $validar = [
                'nombre' => 'required|max:15|unique:variante,nombre,' . $id
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'nombre.required' => 'El nombre de la variante es obligatorio.',
            'nombre.max'  => 'El nombre debe tener menos de :max caracteres.',
            'nombre.unique'  => 'El nombre de la variante ingresado ya existe en el sistema.'
        ];
    }
}
