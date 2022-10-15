<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use App\Models\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Escuela  $director
     * @return \Illuminate\Http\Response
     */
    public function show(Escuela $director)
    {
        try {
            return view('sistema.adminstracion_escuela.director.index', compact('director'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route(
                'escuela.edit',
                ['escuela' => $director->id]
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Escuela  $director
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Escuela $director)
    {
        $this->validate($request, [
            //Director
            'director' => 'required|max:150',
            'director_telefono' => 'nullable|digits:8',
        ], [
            //Director
            'director.required' => 'El nombre del director es obligatorio.',
            'director.max'  => 'El nombre del director debe tener menos de :max caracteres.',

            'director_telefono.digits'  => 'El teléfono del director debe tener :digits dígitos.',
        ]);

        try {
            DB::beginTransaction();

            Director::where('escuela_id', $director->id)->update([
                'activo' => false
            ]);

            Director::create(
                [
                    'nombre' => $request->director,
                    'telefono' => $request->director_telefono,
                    'activo' => true,
                    'escuela_id' => $director->id,
                    'usuario_id' => Auth::user()->id
                ]
            );

            DB::commit();

            toastr()->success('Registro guardado.');

            return redirect()->route('director.show', ['director' => $director]);
        } catch (\Throwable $th) {
            DB::rollBack();

            if ($th->getCode() == 1000)
                toastr()->info($th->getMessage());
            else
                toastr()->error('Error al guardar.');

            return redirect()->route('director.show', ['director' => $director]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Director  $director
     * @return \Illuminate\Http\Response
     */
    public function destroy(Director $director)
    {
        try {
            DB::beginTransaction();

            Director::where('escuela_id', $director->escuela_id)->update([
                'activo' => false
            ]);

            $director->activo = $director->activo ? false : true;
            $director->save();
            DB::commit();

            toastr()->success($director->activo ? "El director {$director->cantidad_alumno} fue activado" : "El director {$director->cantidad_alumno} fue desactivado");
            return redirect()->route('director.show', ['director' => $director->escuela_id]);
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al cambiar el estado.');
            return redirect()->route('director.show', ['director' => $director->escuela_id]);
        }
    }
}
