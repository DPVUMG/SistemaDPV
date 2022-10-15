<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use App\Models\EscuelaSupervisor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class EscuelaSupervisorController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Escuela  $escuela_supervisor
     * @return \Illuminate\Http\Response
     */
    public function show(Escuela $escuela_supervisor)
    {
        try {
            return view('sistema.adminstracion_escuela.supervisor.index', compact('escuela_supervisor'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route(
                'escuela.edit',
                ['escuela' => $escuela_supervisor->id]
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Escuela  $escuela_supervisor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Escuela $escuela_supervisor)
    {
        $this->validate($request, [
            //Supervisor
            'supervisor_id' => 'required|integer|exists:supervisor,id',
        ], [
            //Supervisor
            'supervisor_id.required' => 'El supervisor es obligatorio.',
            'supervisor_id.integer'  => 'El supervisor debe de ser un número entero.',
            'supervisor_id.exists'  => 'El supervisor seleccionado no existe.',
        ]);

        try {
            DB::beginTransaction();

            $supervisor = Supervisor::find($request->supervisor_id);

            Escuela::where('id', $escuela_supervisor->id)->update([
                'distrito_id' => $supervisor->distrito_id
            ]);

            EscuelaSupervisor::where('escuela_id', $escuela_supervisor->id)->update([
                'activo' => false
            ]);

            EscuelaSupervisor::create(
                [
                    'activo' => true,
                    'escuela_id' => $escuela_supervisor->id,
                    'distrito_id' => $escuela_supervisor->distrito_id,
                    'supervisor_id' => $supervisor->id,
                    'usuario_id' => Auth::user()->id
                ]
            );

            DB::commit();

            toastr()->success('Registro guardado.');

            return redirect()->route('escuela_supervisor.show', ['escuela_supervisor' => $escuela_supervisor]);
        } catch (\Throwable $th) {
            DB::rollBack();

            if ($th->getCode() == 1000)
                toastr()->info($th->getMessage());
            else
                toastr()->error('Error al guardar.');

            return redirect()->route('escuela_supervisor.show', ['escuela_supervisor' => $escuela_supervisor]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EscuelaSupervisor  $escuela_supervisor
     * @return \Illuminate\Http\Response
     */
    public function destroy(EscuelaSupervisor $escuela_supervisor)
    {
        try {
            $escuela_supervisor->delete();

            toastr()->success('Registro eliminado.');
            return redirect()->route('escuela_supervisor.show', ['escuela_supervisor' => $escuela_supervisor->escuela_id]);
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro, porque tiene información asociada.");
                return redirect()->route('escuela_supervisor.show', ['escuela_supervisor' => $escuela_supervisor->escuela_id]);
            }
        }
    }
}
