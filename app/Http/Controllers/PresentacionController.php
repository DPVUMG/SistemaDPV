<?php

namespace App\Http\Controllers;

use App\Models\Presentacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class PresentacionController extends Controller
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
                $items = Presentacion::search($request->search)->orderBy('nombre', 'asc')->paginate(10);
            else
                $items = Presentacion::orderBy('nombre', 'asc')->paginate(10);

            return view('sistema.catalogo.presentacion.index', compact('items'));
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
            Presentacion::create($data);
            toastr()->success('Registro guardado.');
            return redirect()->route('presentacion.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar.');
            return redirect()->route('presentacion.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presentacion  $presentacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Presentacion $presentacion)
    {
        try {
            return view('sistema.catalogo.presentacion.edit', compact('presentacion'));
        } catch (\Throwable $th) {
            toastr()->error('Error al seleccionar el registro.');
            return redirect()->route('presentacion.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Presentacion  $presentacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presentacion $presentacion)
    {
        $this->validate($request, $this->rules($presentacion->id), $this->messages());

        try {
            $presentacion->nombre = $request->nombre;

            if (!$presentacion->isDirty()) {
                toastr()->info('El sistema no detecto cambios nuevos para guardar.');
                return redirect()->route('presentacion.index');
            }

            $presentacion->save();
            toastr()->success('Registro actualizado.');
            return redirect()->route('presentacion.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar la información.');
            return redirect()->route('presentacion.edit', ['presentacion' => $presentacion]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presentacion  $presentacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presentacion $presentacion)
    {
        try {
            $presentacion->delete();
            toastr()->success('Registro eliminado.');
            return redirect()->route('presentacion.index');
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro {$presentacion->nombre}, porque tiene información asociada.");
                return redirect()->route('presentacion.index');
            }
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = array();

        if (is_null($id)) {
            $validar = [
                'nombre' => 'required|max:15|unique:presentacion,nombre'
            ];
        } else {
            $validar = [
                'nombre' => 'required|max:15|unique:presentacion,nombre,' . $id
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'nombre.required' => 'El nombre de la presentacion es obligatorio.',
            'nombre.max'  => 'El nombre debe tener menos de :max caracteres.',
            'nombre.unique'  => 'El nombre de la presentacion ingresado ya existe en el sistema.'
        ];
    }
}
