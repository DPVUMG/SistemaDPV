<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class SubCategoriaController extends Controller
{
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
            $category = Categoria::find($request->categoria_id);
            if (!is_null(SubCategoria::where('nombre', $request->nombre)->where('categoria_id', $category->id)->first())) {
                toastr()->warning("La sub categoría {$request->nombre} ya se encuentra asignada a la categoría {$category->nombre}.");
                return redirect()->route('categoria.show', $category);
            }

            $data = $request->all();
            $data['usuario_id'] = Auth::user()->id;
            SubCategoria::create($data);
            toastr()->success('Registro guardado.');

            return redirect()->route('categoria.show', $category);
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar.');
            return redirect()->route('categoria.show', $category);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategoria  $sub_categorium
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategoria $sub_categorium)
    {
        $category = Categoria::find($sub_categorium->categoria_id);
        return view('sistema.catalogo.categoria.sub_categoria.edit', compact('sub_categorium', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategoria  $sub_categorium
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategoria $sub_categorium)
    {
        $this->validate($request, $this->rules($sub_categorium->id), $this->messages());

        try {
            $category = Categoria::find($sub_categorium->categoria_id);
            $sub_categorium->nombre = $request->nombre;

            if (!$sub_categorium->isDirty()) {
                toastr()->info('El sistema no detecto cambios nuevos para guardar.');
                return redirect()->route('categoria.show', $category);
            }

            if (!is_null(SubCategoria::where('nombre', $request->nombre)->where('categoria_id', $category->id)->first())) {
                toastr()->warning("La sub categoría {$request->nombre} ya se encuentra asignada a la categoría {$category->nombre}.");
                return redirect()->route('categoria.show', $category);
            }

            $sub_categorium->save();
            toastr()->success('Registro actualizado.');
            return redirect()->route('categoria.show', $category);
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar.');
            return redirect()->route('categoria.show', $sub_categorium->categoria_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategoria  $sub_categorium
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategoria $sub_categorium)
    {
        try {
            $sub_categorium->delete();
            toastr()->success('Registro eliminado.');
            return redirect()->route('categoria.show', $sub_categorium->categoria_id);
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro {$sub_categorium->nombre}, porque tiene información asociada.");
                return redirect()->route('categoria.show', $sub_categorium->categoria_id);
            }
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = array();

        if (is_null($id)) {
            $validar = [
                'nombre' => 'required|max:25',
                'categoria_id' => 'required|integer|exists:categoria,id'
            ];
        } else {
            $validar = [
                'nombre' => 'required|max:25',
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'nombre.required' => 'El nombre de la sub categoría es obligatorio.',
            'nombre.max'  => 'El nombre debe tener menos de :max caracteres.',

            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.integer'  => 'La categoría debe de ser un número entero.',
            'categoria_id.exists'  => 'La categoría seleccionada no existe.'
        ];
    }
}
