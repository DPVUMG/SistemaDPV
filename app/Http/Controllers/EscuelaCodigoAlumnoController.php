<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use Illuminate\Http\Request;
use App\Models\EscuelaCodigo;
use Illuminate\Support\Facades\DB;
use App\Models\EscuelaCodigoAlumno;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class EscuelaCodigoAlumnoController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  Escuela  $escuela_alumno
     * @return \Illuminate\Http\Response
     */
    public function show(Escuela $escuela_alumno)
    {
        try {
            return view('sistema.adminstracion_escuela.alumno.index', compact('escuela_alumno'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route(
                'escuela.edit',
                ['escuela' => $escuela_alumno->id]
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Escuela  $escuela_alumno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Escuela $escuela_alumno)
    {
        $this->validate($request, [
            //Código de Escuela
            'cantidad_alumno' => 'required|integer',
            'escuela_codigo_id' => 'required|integer|exists:escuela_codigo,id',
        ], [
            //Código de Escuela
            'cantidad_alumno.required' => 'La cantidad de alumnos es obligatorio.',
            'cantidad_alumno.integer'  => 'La cantidad de alumnos debe de ser un número entero.',

            'escuela_codigo_id.required' => 'El código de la escuela es obligatorio.',
            'escuela_codigo_id.integer'  => 'El código de la escuela debe de ser un número entero.',
            'escuela_codigo_id.exists'  => 'El código de la escuela seleccionado no existe.',
        ]);

        try {
            DB::beginTransaction();

            EscuelaCodigoAlumno::where('escuela_codigo_id', $request->escuela_codigo_id)->update(['activo' => false]);

            EscuelaCodigoAlumno::create(
                [
                    'cantidad_alumno' => $request->cantidad_alumno,
                    'activo' => true,
                    'escuela_codigo_id' => $request->escuela_codigo_id,
                    'escuela_id' => $escuela_alumno->id,
                    'nivel_id' => EscuelaCodigo::find($request->escuela_codigo_id)->nivel_id,
                    'usuario_id' => Auth::user()->id
                ]
            );

            DB::commit();
            toastr()->success('Registro guardado.');

            return redirect()->route('escuela_alumno.show', ['escuela_alumno' => $escuela_alumno]);
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($th->getCode() == 1000)
                toastr()->info($th->getMessage());
            else
                toastr()->error('Error al guardar.');

            return redirect()->route('escuela_alumno.show', ['escuela_alumno' => $escuela_alumno]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EscuelaCodigoAlumno  $escuela_alumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(EscuelaCodigoAlumno $escuela_alumno)
    {
        try {
            $escuela_alumno->activo = $escuela_alumno->activo ? false : true;
            $escuela_alumno->save();

            toastr()->success($escuela_alumno->activo ? "La cantidad de alumnos {$escuela_alumno->cantidad_alumno} fue activado" : "La cantidad de alumnos {$escuela_alumno->cantidad_alumno} fue desactivado");
            return redirect()->route('escuela_alumno.show', ['escuela_alumno' => $escuela_alumno->escuela_id]);
        } catch (\Throwable $th) {
            toastr()->error('Error al cambiar el estado.');
            return redirect()->route('escuela_alumno.show', ['escuela_alumno' => $escuela_alumno->escuela_id]);
        }
    }
}
