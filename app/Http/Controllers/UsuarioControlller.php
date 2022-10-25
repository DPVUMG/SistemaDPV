<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioControlller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $items = Usuario::orderBy('created_at', 'desc')->get();

            return view('sistema.usuario.sistema.index', compact('items'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route($this->redireccionarCatch());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $municipios = Municipio::get();

            return view('sistema.usuario.sistema.create', compact(
                'municipios'
            ));
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
            DB::beginTransaction();

            $this->createUsuario($request, 0, false);

            DB::commit();

            toastr()->success('Registro guardado.');
            return redirect()->route('usuario.create');
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error("Error al guardar.");
            return redirect()->route('usuario.create');
        }
    }

    /**
     * Update status.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function status(Usuario $usuario)
    {
        try {
            $usuario->activo = $usuario->activo ? false : true;
            $usuario->save();

            toastr()->success($usuario->activo ? "El usuario {$usuario->usuario} fue activado" : "El usuario {$usuario->usuario} fue desactivado");
            return redirect()->route('usuario.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al cambiar el estado.');
            return redirect()->route('usuario.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        try {
            $municipios = Municipio::get();

            return view('sistema.usuario.sistema.edit', compact(
                'usuario',
                'municipios'
            ));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route($this->redireccionarCatch());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        $this->validate($request, $this->rules($usuario->persona_id, $usuario->id), $this->messages());

        try {
            DB::beginTransaction();

            $this->updateOrcreateOrselect_persona($request, $usuario->persona_id);

            if ($request->has('password') && is_null($request->password) && $request->password != '') {
                $usuario->password = $request->password;
            }

            $usuario->usuario = $request->usuario;
            $usuario->save();

            DB::commit();

            toastr()->success('Registro guardado.');
            return redirect()->route('usuario.edit', $usuario);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error("Error al guardar.");
            return redirect()->route('usuario.edit', $usuario);
        }
    }

    //Reglas de validaciones
    public function rules($cui = null, $usuario = null)
    {
        return [
            //Persona
            'cui_persona' => is_null($cui) ? 'required|digits:13|unique:persona,cui' : "required|digits:13|unique:persona,cui,{$cui}",
            'nombre_persona' => 'required|max:75',
            'apellido_persona' => 'required|max:75',
            'telefono_persona' => 'nullable|digits:8',
            'correo_electronico_persona' => 'nullable|email|max:75',
            'direccion_persona' => 'nullable|max:500',
            'avatar_persona' => is_null($cui) ? 'required|file' : '',
            'municipio_id_persona' => 'required|integer|exists:municipio,id',

            //Usuario
            'usuario' => is_null($usuario) ? 'required|max:30|unique:usuario,usuario' : "required|max:30|unique:usuario,usuario,{$usuario}",
            'password' => is_null($usuario) ? 'required|min:6' : 'nullable|min:6',
        ];
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            //Persona
            'cui_persona.required' => 'El CUI de la persona es obligatorio.',
            'cui_persona.digits'  => 'El CUI de la persona debe tener :digits dígitos.',
            'cui_persona.unique'  => 'El CUI de la persona ingresado ya existe en el sistema.',

            'nombre_persona.required' => 'El nombre de la persona es obligatorio.',
            'nombre_persona.max'  => 'El nombre de la persona debe tener menos de :max caracteres.',

            'apellido_persona.required' => 'El apellido de la persona es obligatorio.',
            'apellido_persona.max'  => 'El apellido de la persona debe tener menos de :max caracteres.',

            'telefono_persona.digits'  => 'El teléfono de la persona debe tener :digits dígitos.',

            'correo_electronico_persona.email'  => 'El correo electrónico de la persona debe no es válido.',
            'correo_electronico_persona.max'  => 'El correo electrónico de la persona debe tener menos de :max caracteres.',

            'direccion_persona.max'  => 'La dirección de la persona debe tener menos de :max caracteres.',

            'avatar_persona.required' => 'El avatar de la persona es obligatorio.',
            'avatar_persona.file' => 'El avatar de la persona no tiene el formato correcto.',

            'municipio_id_persona.required' => 'El municipio de la persona es obligatorio.',
            'municipio_id_persona.integer'  => 'El municipio de la persona debe de ser un número entero.',
            'municipio_id_persona.exists'  => 'El municipio de la persona seleccionado no existe.',

            //Usuario
            'usuario.required' => 'El usuario de la persona es obligatorio.',
            'usuario.max'  => 'El usuario de la persona debe tener menos de :max caracteres.',
            'usuario.unique'  => 'El usuario de la persona ingresado ya existe en el sistema.',

            'password.required' => 'El password de la persona es obligatorio.',
            'password.min'  => 'El password de la persona debe tener más de :min caracteres.',
        ];
    }
}
