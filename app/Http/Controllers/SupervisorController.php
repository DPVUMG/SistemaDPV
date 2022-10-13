<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $items = Supervisor::orderBy('nombre', 'asc')->get();
            $supervisor = null;
            return view('sistema.catalogo.escuela.supervisor.index', compact('items', 'supervisor'));
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
            DB::beginTransaction();
            $data = $request->all();
            $data['distrito_id'] = $this->createOrselect_distrito($request->distrito_id)->id;
            Supervisor::create($data);
            DB::commit();

            toastr()->success('Registro guardado.');
            return redirect()->route('supervisor.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error("Error al guardar.");
            return redirect()->route('supervisor.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supervisor  $supervisor
     * @return \Illuminate\Http\Response
     */
    public function show(Supervisor $supervisor)
    {
        try {
            $supervisor->activo = $supervisor->activo ? false : true;
            $supervisor->save();

            toastr()->success($supervisor->activo ? "El supervisor {$supervisor->nombre} fue activado" : "El supervisor {$supervisor->nombre} fue desactivado");
            return redirect()->route('supervisor.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al cambiar el estado.');
            return redirect()->route('supervisor.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supervisor  $supervisor
     * @return \Illuminate\Http\Response
     */
    public function edit(Supervisor $supervisor)
    {
        try {
            $items = Supervisor::orderBy('nombre', 'asc')->get();
            return view('sistema.catalogo.escuela.supervisor.index', compact('items', 'supervisor'));
        } catch (\Throwable $th) {
            toastr()->error('Error al seleccionar el registro.');
            return redirect()->route('supervisor.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supervisor  $supervisor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supervisor $supervisor)
    {
        $this->validate($request, $this->rules($supervisor->id), $this->messages());

        try {
            DB::beginTransaction();
            $supervisor->nombre = $request->nombre;
            $supervisor->telefono = $request->telefono;
            $supervisor->distrito_id = $this->createOrselect_distrito($request->distrito_id)->id;

            if (!$supervisor->isDirty()) {
                toastr()->info('El sistema no detecto cambios nuevos para guardar.');
                return redirect()->route('supervisor.index');
            }

            $supervisor->save();
            DB::commit();

            toastr()->success('Registro actualizado.');
            return redirect()->route('supervisor.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error('Error al guardar la información.');
            return redirect()->route('supervisor.edit', ['supervisor' => $supervisor]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supervisor  $supervisor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supervisor $supervisor)
    {
        try {
            $supervisor->delete();
            toastr()->success('Registro eliminado.');
            return redirect()->route('supervisor.index');
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro {$supervisor->nombre}, porque tiene información asociada.");
                return redirect()->route('supervisor.index');
            }
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = array();

        if (is_null($id)) {
            $validar = [
                'nombre' => 'required|max:25|unique:supervisor,nombre',
                'telefono' => 'nullable|digits:8',
                'distrito_id' => 'required|max:10'
            ];
        } else {
            $validar = [
                'nombre' => "required|max:25|unique:supervisor,nombre,{$id}",
                'telefono' => 'nullable|digits:8',
                'distrito_id' => 'required|max:10'
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'nombre.required' => 'El nombre del supervisor es obligatorio.',
            'nombre.max'  => 'El nombre debe tener menos de :max caracteres.',
            'nombre.unique'  => 'El nombre del supervisor ingresado ya existe en el sistema.',

            'telefono.digits'  => 'El teléfono del supervisor debe tener :digits dígitos.',

            'distrito_id.required' => 'El distrito del supervisor es obligatorio.',
            'distrito_id.max'  => 'El distrito debe tener menos de :max caracteres.'
        ];
    }
}
