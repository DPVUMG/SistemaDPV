<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Nivel;
use App\Models\Escuela;
use App\Models\Municipio;
use App\Models\Supervisor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EscuelaCodigo;
use App\Models\EscuelaSupervisor;
use Illuminate\Support\Facades\DB;
use App\Models\EscuelaCodigoAlumno;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class EscuelaController extends Controller
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
                $items = Escuela::search($request->search)->orderBy('created_at', 'desc')->paginate(10);
            else
                $items = Escuela::orderBy('created_at', 'desc')->paginate(10);

            return view('sistema.escuela.index', compact('items'));
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
    public function create(Request $request)
    {
        try {
            $municipios = Municipio::get();
            $sectores = $this->sectores();
            $areas = $this->areas();
            $jornadas = $this->jornadas();
            $niveles = Nivel::orderBy('nombre', 'asc')->get();
            $respuesta = $request->has('respuesta') ? $request->respuesta : null;

            return view('sistema.escuela.crear', compact('municipios', 'sectores', 'areas', 'jornadas', 'niveles', 'respuesta'));
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

            $mensaje = "<b>Información registrada:</b>";

            $image = Image::make(file_get_contents($request->file('logo')));
            $image->encode('jpg', 70);
            $logo = Str::random(10);

            Storage::disk('escuela')->put("{$logo}.jpg", $image);

            $mensaje .= "<br>Imagen: {$logo}.jpg</br>";

            $supervisor = Supervisor::find($request->supervisor_id);

            $escuela = Escuela::create(
                [
                    'logo' => "{$logo}.jpg",
                    'nit' => $request->nit,
                    'establecimiento' => $request->establecimiento,
                    'direccion' => $request->direccion,
                    'telefono' => $request->telefono,
                    'sector' => $request->sector,
                    'area' => $request->area,
                    'jornada' => $request->jornada,
                    'plan' => $request->plan,
                    'activo' => true,
                    'distrito_id' => $supervisor->distrito_id,
                    'departamental_id' => $this->createOrselect_departamental($request->departamental_id)->id,
                    'departamento_id' => Municipio::find($request->municipio_id)->id,
                    'municipio_id' => $request->municipio_id,
                    'usuario_id'  => Auth::user()->id
                ]
            );

            $mensaje .= "<br>Escuela: {$escuela->establecimiento}</br>";

            if ((count($request->codigo) == count($request->cantidad_alumno)) && (count($request->codigo) == count($request->nivel_id))) {

                $mensaje .= "<br>Códigos:</br>";

                for ($i = 0; $i < count($request->codigo); $i++) {
                    if (!is_null($request->codigo[$i]) && !is_null($request->cantidad_alumno[$i])) {
                        $codigo = EscuelaCodigo::create(
                            [
                                'codigo' => $request->codigo[$i],
                                'activo' => true,
                                'escuela_id' => $escuela->id,
                                'nivel_id' => $request->nivel_id[$i],
                                'usuario_id' => $escuela->usuario_id
                            ]
                        );
                        $alumnos = EscuelaCodigoAlumno::create(
                            [
                                'cantidad_alumno' => $request->cantidad_alumno[$i],
                                'activo' => true,
                                'escuela_codigo_id' => $codigo->id,
                                'escuela_id' => $codigo->escuela_id,
                                'nivel_id' => $codigo->nivel_id,
                                'usuario_id' => $codigo->usuario_id
                            ]
                        );

                        $mensaje .= " {$codigo->codigo} | {$alumnos->cantidad_alumno}<br>";
                    }
                }
            }

            $director = $this->updateMasive_director($request->director, $request->director_telefono, $escuela->id, true);
            $mensaje .= "<br>Director: {$director->nombre}</br>";

            EscuelaSupervisor::create(
                [
                    'activo' => true,
                    'escuela_id' => $escuela->id,
                    'distrito_id' => $escuela->distrito_id,
                    'supervisor_id' => $request->supervisor_id,
                    'usuario_id' => $escuela->usuario_id
                ]
            );
            $mensaje .= "<br>Supervisor: {$supervisor->nombre}</br>";

            $persona_usuario = $this->createUsuario($request, $escuela->id, true);
            $mensaje .= "<br>Persona: {$persona_usuario['persona']->nombre} {$persona_usuario['persona']->apellido}</br>";
            $mensaje .= "<br>Usuario: {$persona_usuario['usuario']->usuario}</br>";

            DB::commit();

            toastr()->success('Registro guardado.');
            return redirect()->route('escuela.create', ['respuesta' => $mensaje]);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error("Error al guardar.");
            return redirect()->route('escuela.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Escuela  $escuela
     * @return \Illuminate\Http\Response
     */
    public function show(Escuela $escuela)
    {
        try {
            return view('sistema.escuela.show', compact('escuela'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route('escuela.index');
        }
    }

    /**
     * Update status.
     *
     * @param  \App\Models\Escuela  $escuela
     * @return \Illuminate\Http\Response
     */
    public function status(Escuela $escuela)
    {
        try {
            $escuela->activo = $escuela->activo ? false : true;
            $escuela->save();

            toastr()->success($escuela->activo ? "La escuela {$escuela->establecimiento} fue activado" : "La escuela {$escuela->establecimiento} fue desactivado");
            return redirect()->route('escuela.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al cambiar el estado.');
            return redirect()->route('escuela.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Escuela  $escuela
     * @return \Illuminate\Http\Response
     */
    public function edit(Escuela $escuela)
    {
        try {
            $municipios = Municipio::get();
            $sectores = $this->sectores();
            $areas = $this->areas();
            $jornadas = $this->jornadas();

            return view('sistema.escuela.edit', compact('municipios', 'sectores', 'areas', 'jornadas', 'escuela'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route('escuela.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Escuela  $escuela
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Escuela $escuela)
    {
        $this->validate($request, $this->rules($escuela->id), $this->messages());

        try {
            DB::beginTransaction();

            $escuela->nit = $request->nit;
            $escuela->establecimiento = $request->establecimiento;
            $escuela->direccion = $request->direccion;
            $escuela->telefono = $request->telefono;
            $escuela->sector = $request->sector;
            $escuela->area = $request->area;
            $escuela->jornada = $request->jornada;
            $escuela->plan = $request->plan;
            $escuela->departamental_id = $this->createOrselect_departamental($request->departamental_id)->id;
            $escuela->departamento_id = Municipio::find($request->municipio_id)->id;
            $escuela->municipio_id = $request->municipio_id;

            if (!empty($request->logo)) {
                Storage::disk('escuela')->exists($escuela->logo) ? Storage::disk('escuela')->delete($escuela->logo) : null;

                $img_data = file_get_contents($request->file('logo'));
                $image = Image::make($img_data);
                $image->encode('jpg', 70);
                $nombre = Str::random(10);
                $escuela->logo = "{$nombre}.jpg";

                Storage::disk('escuela')->put($escuela->logo, $image);
            }

            if (!$escuela->isDirty()) {
                throw new Exception('El sistema no detecto cambios nuevos para guardar.', 1000);
            }

            $escuela->save();
            DB::commit();

            toastr()->success('Registro actualizado.');
            return redirect()->route('escuela.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($th->getCode() == 1000)
                toastr()->info($th->getMessage());
            else
                toastr()->error('Error al guardar.');

            return redirect()->route('escuela.edit', ['escuela' => $escuela]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Escuela  $escuela
     * @return \Illuminate\Http\Response
     */
    public function destroy(Escuela $escuela)
    {
        try {
            $escuela->delete();
            Storage::disk('escuela')->exists($escuela->logo) ? Storage::disk('escuela')->delete($escuela->logo) : null;

            toastr()->success('Registro eliminado.');
            return redirect()->route('escuela.index');
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro {$escuela->establecimiento}, porque tiene información asociada.");
                return redirect()->route('escuela.index');
            }
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = array();

        if (is_null($id)) {
            $validar = [
                //Escuela
                'logo' => 'required|file',
                'nit' => 'required|min:6|max:15|unique:escuela,nit',
                'establecimiento' => 'required|max:175',
                'direccion' => 'nullable|max:500',
                'telefono' => 'nullable|digits:8',
                'sector' => 'required|starts_with:Privado,Oficial,Cooperativa,Municipal',
                'area' => 'required|starts_with:Urbana,Rural',
                'jornada' => 'required|starts_with:Matutina,Doble,Vespertina,Nocturna,Intermedia,Sin Jornada',
                'plan' => 'required|max:50',
                'departamental_id' => 'required|max:25',
                'municipio_id' => 'required|integer|exists:municipio,id',

                //Supervisor
                'supervisor_id' => 'required|integer|exists:supervisor,id',

                //Código de Escuela
                'codigo.*' => 'nullable|regex:/(^\D*\d{2}-\D*\d{2}-\D*\d{4}-\D*\d{2}$)/u|unique:escuela_codigo,codigo',
                'nivel_id.*' => 'required|integer|exists:nivel,id',

                //Alumnos por código
                'cantidad_alumno.*' => 'nullable|integer',

                //Director
                'director' => 'required|max:150',
                'director_telefono' => 'nullable|digits:8',

                //Persona
                'cui_persona' => 'required|digits:13|unique:persona,cui',
                'nombre_persona' => 'required|max:75',
                'apellido_persona' => 'required|max:75',
                'telefono_persona' => 'nullable|digits:8',
                'correo_electronico_persona' => 'nullable|email|max:75',
                'direccion_persona' => 'nullable|max:500',
                'avatar_persona' => 'required|file',
                'municipio_id_persona' => 'required|integer|exists:municipio,id',

                //Usuario
                'usuario' => 'required|max:30|unique:escuela_usuario,usuario',
                'password' => 'required|min:6',
            ];
        } else {
            $validar = [
                'logo' => 'nullable|file',
                'nit' => "required|max:25|unique:escuela,nit,{$id}",
                'establecimiento' => 'required|max:175',
                'direccion' => 'max:500',
                'telefono' => 'nullable|digits:8',
                'sector' => 'required|starts_with:Privado,Oficial,Cooperativa,Municipal',
                'area' => 'required|starts_with:Urbana,Rural',
                'jornada' => 'required|starts_with:Matutina,Doble,Vespertina,Nocturna,Intermedia,Sin Jornada',
                'plan' => 'required|max:50',
                'departamental_id' => 'required|max:25',
                'municipio_id' => 'required|integer|exists:municipio,id'
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            //Escuela
            'logo.required' => 'El logotipo de la escuela es obligatorio.',
            'logo.file' => 'El logotipo de la escuela no tiene el formato correcto.',

            'nit.required' => 'El NIT de la escuela es obligatorio.',
            'nit.min'  => 'El NIT de la escuela debe tener más de :min caracteres.',
            'nit.max'  => 'El NIT de la escuela debe tener menos de :max caracteres.',
            'nit.unique'  => 'El NIT de la escuela ingresado ya existe en el sistema.',

            'establecimiento.required' => 'El nombre de la escuela es obligatorio.',
            'establecimiento.max'  => 'El nombre de la escuela debe tener menos de :max caracteres.',

            'direccion.max'  => 'La dirección de la escuela debe tener menos de :max caracteres.',

            'telefono.digits'  => 'El teléfono de la escuela debe tener :digits dígitos.',

            'sector.required' => 'El sector de la escuela es obligatorio.',
            'sector.starts_with' => 'El sector de la escuela es no tiene un valor válido (:starts_with).',

            'area.required' => 'El area de la escuela es obligatorio.',
            'area.starts_with' => 'El area de la escuela es no tiene un valor válido (:starts_with).',

            'jornada.required' => 'La jornada de la escuela es obligatorio.',
            'jornada.starts_with' => 'La jornada de la escuela es no tiene un valor válido (:starts_with).',

            'plan.required' => 'El plan de la escuela es obligatorio.',
            'plan.max'  => 'El plan de la escuela debe tener menos de :max caracteres.',

            'departamental_id.required' => 'La departamental de la escuela es obligatorio.',
            'departamental_id.max'  => 'La departamental de la escuela debe tener menos de :max caracteres.',

            'municipio_id.required' => 'El municipio es obligatorio.',
            'municipio_id.integer'  => 'El municipio debe de ser un número entero.',
            'municipio_id.exists'  => 'El municipio seleccionado no existe.',

            //Supervisor
            'supervisor_id.required' => 'El supervisor es obligatorio.',
            'supervisor_id.integer'  => 'El supervisor debe de ser un número entero.',
            'supervisor_id.exists'  => 'El supervisor seleccionado no existe.',

            //Código de Escuela
            'codigo.*.regex'  => 'El código de la escuela no tiene formato correcto (00-00-0000-00).',
            'codigo.*.unique'  => 'El código de la escuela seleccionado ya existe en el sistema.',

            'nivel_id.*.required' => 'El nivel es obligatorio.',
            'nivel_id.*.integer'  => 'El nivel debe de ser un número entero.',
            'nivel_id.*.exists'  => 'El nivel seleccionado no existe.',

            //Alumnos por código
            'cantidad_alumno.*.integer'  => 'La cantidad de alumnos debe de ser un número entero.',

            //Director
            'director.required' => 'El nombre del director es obligatorio.',
            'director.max'  => 'El nombre del director debe tener menos de :max caracteres.',

            'director_telefono.digits'  => 'El teléfono del director debe tener :digits dígitos.',

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
