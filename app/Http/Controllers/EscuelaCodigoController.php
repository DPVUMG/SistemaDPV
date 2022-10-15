<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use App\Models\Escuela;
use Illuminate\Http\Request;
use App\Models\EscuelaCodigo;
use Exception;
use Illuminate\Support\Facades\Auth;

class EscuelaCodigoController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Escuela  $escuela_codigo
     * @return \Illuminate\Http\Response
     */
    public function show(Escuela $escuela_codigo)
    {
        try {
            return view('sistema.adminstracion_escuela.codigo.index', compact('escuela_codigo'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route(
                'escuela.edit',
                ['escuela' => $escuela_codigo->id]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Escuela  $escuela_codigo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Escuela $escuela_codigo)
    {
        $this->validate($request, [
            //Código de Escuela
            'codigo' => 'nullable|regex:/(^\D*\d{2}-\D*\d{2}-\D*\d{4}-\D*\d{2}$)/u|unique:escuela_codigo,codigo',
            'nivel_id' => 'required|integer|exists:nivel,id',
        ], [
            //Código de Escuela
            'codigo.regex'  => 'El código de la escuela no tiene formato correcto (00-00-0000-00).',
            'codigo.unique'  => 'El código de la escuela seleccionado ya existe en el sistema.',

            'nivel_id.required' => 'El nivel es obligatorio.',
            'nivel_id.integer'  => 'El nivel debe de ser un número entero.',
            'nivel_id.exists'  => 'El nivel seleccionado no existe.',
        ]);

        try {

            $codigo_ingresado = explode("-", $request->codigo);
            $codigo = Nivel::find($request->nivel_id);

            if ($codigo_ingresado[3] != $codigo->codigo) {
                throw new Exception("El código {$request->codigo} ingresado, no cumple con el código correcto para el nivel seleccionado {$codigo->nombre}", 1000);
            }

            EscuelaCodigo::create(
                [
                    'codigo' => $request->codigo,
                    'activo' => true,
                    'escuela_id' => $escuela_codigo->id,
                    'nivel_id' => $request->nivel_id,
                    'usuario_id' => Auth::user()->id
                ]
            );

            toastr()->success('Registro guardado.');

            return redirect()->route('escuela_codigo.show', ['escuela_codigo' => $escuela_codigo]);
        } catch (\Throwable $th) {
            if ($th->getCode() == 1000)
                toastr()->info($th->getMessage());
            else
                toastr()->error('Error al guardar.');

            return redirect()->route('escuela_codigo.show', ['escuela_codigo' => $escuela_codigo]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EscuelaCodigo  $escuela_codigo
     * @return \Illuminate\Http\Response
     */
    public function destroy(EscuelaCodigo $escuela_codigo)
    {
        try {
            $escuela_codigo->activo = $escuela_codigo->activo ? false : true;
            $escuela_codigo->save();

            toastr()->success($escuela_codigo->activo ? "El código {$escuela_codigo->codigo} fue activado" : "El código {$escuela_codigo->codigo} fue desactivado");
            return redirect()->route('escuela_codigo.show', ['escuela_codigo' => $escuela_codigo->escuela_id]);
        } catch (\Throwable $th) {
            toastr()->error('Error al cambiar el estado.');
            return redirect()->route('escuela_codigo.show', ['escuela_codigo' => $escuela_codigo->escuela_id]);
        }
    }
}
