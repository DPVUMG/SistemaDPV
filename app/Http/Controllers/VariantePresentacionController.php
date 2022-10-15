<?php

namespace App\Http\Controllers;

use App\Models\Variante;
use App\Models\Presentacion;
use Illuminate\Http\Request;
use App\Models\VariantePresentacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class VariantePresentacionController extends Controller
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
                $items = VariantePresentacion::with('variante', 'presentacion')->search($request->search)->paginate(10);
            else
                $items = VariantePresentacion::with('variante', 'presentacion')->paginate(10);

            $variantes = Variante::orderBy('nombre', 'asc')->get();
            $presentaciones = Presentacion::orderBy('nombre', 'asc')->get();

            return view('sistema.catalogo.variante_presentacion.index', compact('items', 'variantes', 'presentaciones'));
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
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
            $variante = Variante::find($request->variante_id);
            $presentacion = Presentacion::find($request->presentacion_id);

            if (!is_null(VariantePresentacion::where('variante_id', $variante->id)->where('presentacion_id', $presentacion->id)->first())) {
                toastr()->warning("La variante {$variante->nombre} ya se encuentra asignada a la presentación {$presentacion->nombre}.");
                return redirect()->route('variante_presentacion.index');
            }

            $data = $request->all();
            $data['usuario_id'] = Auth::user()->id;
            VariantePresentacion::create($data);
            toastr()->success('Registro guardado.');

            return redirect()->route('variante_presentacion.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar.');
            return redirect()->route('variante_presentacion.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VariantePresentacion  $variante_presentacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(VariantePresentacion $variante_presentacion)
    {
        try {
            $variante_presentacion->delete();
            toastr()->success('Registro eliminado.');
            return redirect()->route('variante_presentacion.index');
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                $variante = Variante::find($variante_presentacion->variante_id);
                $presentacion = Presentacion::find($variante_presentacion->presentacion_id);

                toastr()->error("El sistema no puede eliminar la variante {$variante->nombre} de la presentación {$presentacion->nombre}, porque tiene información asociada.");
                return redirect()->route('variante_presentacion.index');
            }
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = [
            'variante_id' => 'required|integer|exists:variante,id',
            'presentacion_id' => 'required|integer|exists:presentacion,id'
        ];

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'variante_id.required' => 'La variante es obligatoria.',
            'variante_id.integer'  => 'La variante debe de ser un número entero.',
            'variante_id.exists'  => 'La variante seleccionada no existe.',

            'presentacion_id.required' => 'La presentación es obligatoria.',
            'presentacion_id.integer'  => 'La presentación debe de ser un número entero.',
            'presentacion_id.exists'  => 'La presentación seleccionada no existe.'
        ];
    }
}
