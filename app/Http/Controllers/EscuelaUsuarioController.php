<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use App\Models\Municipio;
use Illuminate\Http\Request;
use App\Models\EscuelaUsuario;
use Illuminate\Support\Facades\DB;

class EscuelaUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $items = EscuelaUsuario::orderBy('created_at', 'desc')->get();

            return view('sistema.usuario.escuela.index', compact('items'));
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
            $escuelas = Escuela::select('id', 'establecimiento')->orderBy('establecimiento', 'desc')->get();

            return view('sistema.usuario.escuela.create', compact(
                'municipios',
                'escuelas'
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

            $this->createUsuario($request, $request->escuela_id, true);

            DB::commit();

            toastr()->success('Registro guardado.');
            return redirect()->route('escuela_usuario.create');
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error("Error al guardar.");
            return redirect()->route('escuela_usuario.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Escuela  $escuela_usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Escuela $escuela_usuario)
    {
        try {
            return view('sistema.adminstracion_escuela.usuario.index', compact('escuela_usuario'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route(
                'escuela.edit',
                ['escuela' => $escuela_usuario->id]
            );
        }
    }

    /**
     * Update status.
     *
     * @param  \App\Models\EscuelaUsuario  $escuela_usuario
     * @return \Illuminate\Http\Response
     */
    public function status(EscuelaUsuario $escuela_usuario)
    {
        try {
            $escuela_usuario->activo = $escuela_usuario->activo ? false : true;
            $escuela_usuario->save();

            toastr()->success($escuela_usuario->activo ? "El usuario {$escuela_usuario->usuario} fue activado" : "El usuario {$escuela_usuario->usuario} fue desactivado");
            return redirect()->route('escuela_usuario.show', $escuela_usuario->escuela_id);
        } catch (\Throwable $th) {
            toastr()->error('Error el cambio de estado');
            return redirect()->route('escuela_usuario.show', $escuela_usuario->escuela_id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EscuelaUsuario  $escuela_usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(EscuelaUsuario $escuela_usuario)
    {
        try {
            $municipios = Municipio::get();
            $escuelas = Escuela::select('id', 'establecimiento')->orderBy('establecimiento', 'desc')->get();

            return view('sistema.usuario.escuela.edit', compact(
                'escuela_usuario',
                'municipios',
                'escuelas'
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
     * @param  \App\Models\EscuelaUsuario  $escuela_usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EscuelaUsuario $escuela_usuario)
    {
        $this->validate($request, $this->rules($escuela_usuario->persona_id, $escuela_usuario->id), $this->messages());

        try {
            DB::beginTransaction();

            $this->updateOrcreateOrselect_persona($request, $escuela_usuario->persona_id);

            if ($request->has('password') && is_null($request->password) && $request->password != '') {
                $escuela_usuario->password = $request->password;
            }

            $escuela_usuario->usuario = $request->usuario;
            $escuela_usuario->escuela_id = $request->escuela_id;
            $escuela_usuario->save();

            DB::commit();

            toastr()->success('Registro guardado.');
            return redirect()->route('escuela_usuario.edit', $escuela_usuario);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error("Error al guardar.");
            return redirect()->route('escuela_usuario.edit', $escuela_usuario);
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
            'escuela_id' => 'required|integer|exists:escuela,id',

            //Usuario
            'usuario' => is_null($usuario) ? 'required|max:30|unique:usuario,usuario' : "required|max:30|unique:escuela_usuario,usuario,{$usuario}",
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

            'escuela_id.required' => 'La escuela es obligatorio.',
            'escuela_id.integer'  => 'La escuela debe de ser un número entero.',
            'escuela_id.exists'  => 'La escuela seleccionado no existe.',

            //Usuario
            'usuario.required' => 'El usuario de la persona es obligatorio.',
            'usuario.max'  => 'El usuario de la persona debe tener menos de :max caracteres.',
            'usuario.unique'  => 'El usuario de la persona ingresado ya existe en el sistema.',

            'password.required' => 'El password de la persona es obligatorio.',
            'password.min'  => 'El password de la persona debe tener más de :min caracteres.',
        ];
    }
}
