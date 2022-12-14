<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Models\ConfiguracionDireccion;
use App\Models\ConfiguracionTelefono;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ConfiguracionController extends Controller
{
    ///Vista de la pantalla de todos los registros
    public function index_pagina()
    {
        $web = Configuracion::with('telefonos', 'direcciones')->where('pagina', true)->first();
        return view('sistema.configuracion.index_pagina', compact('web'));
    }

    ///Vista de la pantalla de todos los registros
    public function index_sistema()
    {
        $web = Configuracion::with('telefonos', 'direcciones')->where('sistema', true)->first();
        return view('sistema.configuracion.index_sistema', compact('web'));
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

            $configuracion = new Configuracion();
            $img_data = file_get_contents($request->file('logotipo'));
            $image = Image::make($img_data);
            $image->encode('jpg', 70);
            $nombre = Str::random(10);
            $path = "{$nombre}.jpg";
            $configuracion->logotipo = $path;
            $configuracion->nit = $request->nit;
            $configuracion->nombre = $request->nombre;
            $configuracion->slogan = $request->slogan;
            $configuracion->vision = $request->vision;
            $configuracion->mision = $request->mision;
            $configuracion->ubicacion_x = $request->ubicacion_x;
            $configuracion->ubicacion_y = $request->ubicacion_y;
            $configuracion->facebook = $request->facebook;
            $configuracion->twitter = $request->twitter;
            $configuracion->instagram = $request->instagram;
            $configuracion->url = $request->url;
            $configuracion->pagina = false;
            $configuracion->sistema = true;
            $configuracion->save();

            Storage::disk('logotipo')->put($path, $image);

            toastr()->success('Registro guardado.');
            return redirect()->route('configuracion.index_sistema');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->route('configuracion.index_sistema');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Configuracion  $configuracion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Configuracion $configuracion)
    {
        if (is_null($request->logotipo))
            $this->validate($request, $this->rules(1), $this->messages());
        else
            $this->validate($request, $this->rules($configuracion->id), $this->messages());

        try {
            $configuracion->nit = $request->nit;
            $configuracion->nombre = $request->nombre;
            $configuracion->slogan = $request->slogan;
            $configuracion->vision = $request->vision;
            $configuracion->mision = $request->mision;
            $configuracion->ubicacion_x = $request->ubicacion_x;
            $configuracion->ubicacion_y = $request->ubicacion_y;
            $configuracion->facebook = $request->facebook;
            $configuracion->twitter = $request->twitter;
            $configuracion->instagram = $request->instagram;
            $configuracion->url = $request->url;

            if (!empty($request->logotipo)) {
                Storage::disk('logotipo')->exists($configuracion->logotipo) ? Storage::disk('logotipo')->delete($configuracion->logotipo) : null;

                $img_data = file_get_contents($request->file('logotipo'));
                $image = Image::make($img_data);
                $image->encode('jpg', 70);
                $nombre = Str::random(10);
                $path = "{$nombre}.jpg";
                $configuracion->logotipo = $path;

                Storage::disk('logotipo')->put($path, $image);
            }

            if (!$configuracion->isDirty()) {
                toastr()->info('El sistema no detecto cambios nuevos para guardar.');
                return redirect()->route("configuracion.{$request->redireccionar}");
            }

            $configuracion->save();
            toastr()->success('Registro actualizado.');
            return redirect()->route("configuracion.{$request->redireccionar}");
        } catch (\Throwable $th) {
            toastr()->error('Error al actualizar la informaci??n.');
            return redirect()->route("configuracion.{$request->redireccionar}");
        }
    }

    //Insert de datos telefono
    public function telefono_store(Request $request, Configuracion $configuracion)
    {
        $rules = [
            'redireccionar' => 'required|starts_with:index_pagina,index_sistema',
            'telefono' => 'required|integer|digits:8'
        ];

        $messages = [
            'redireccionar.required' => 'El par??metro de redireccionamiento es obligatorio.',
            'redireccionar.starts_with' => 'El par??metro de redireccionamiento solo pueder ser index_pagina o index_sistema.',

            'telefono.required' => 'El n??mero de tel??fono es obligatorio.',
            'telefono.digits' => 'El n??mero de tel??fono debe contener :digits d??gitos.',
            'telefono.integer' => 'El n??mero de tel??fono debe de ser n??meros enteros.',
        ];

        $this->validate($request, $rules, $messages);

        try {
            $nuevo_telefono = new ConfiguracionTelefono();
            $nuevo_telefono->telefono = $request->telefono;
            $nuevo_telefono->configuracion_id = $configuracion->id;
            $nuevo_telefono->save();

            $configuracion->updated_at = $nuevo_telefono->updated_at;
            $configuracion->save();

            toastr()->success("N??mero de tel??fono {$nuevo_telefono->telefono} agregado.");
            return redirect()->route("configuracion.{$request->redireccionar}");
        } catch (\Throwable $th) {
            toastr()->error("Error al agregar el n??mero.");
            return redirect()->route("configuracion.{$request->redireccionar}");
        }
    }

    //Insert de datos direccion
    public function direccion_store(Request $request, Configuracion $configuracion)
    {
        $rules = [
            'redireccionar' => 'required|starts_with:index_pagina,index_sistema',
            'direccion' => 'required|max:200'
        ];

        $messages = [
            'redireccionar.required' => 'El par??metro de redireccionamiento es obligatorio.',
            'redireccionar.starts_with' => 'El par??metro de redireccionamiento solo pueder ser index_pagina o index_sistema.',

            'direccion.required' => 'La direcci??n es obligatorio.',
            'direccion.max'  => 'La direcci??n debe tener menos de :max caracteres.'
        ];

        $this->validate($request, $rules, $messages);

        try {
            $nueva_direccion = new ConfiguracionDireccion();
            $nueva_direccion->direccion = $request->direccion;
            $nueva_direccion->configuracion_id = $configuracion->id;
            $nueva_direccion->save();

            $configuracion->updated_at = $nueva_direccion->updated_at;
            $configuracion->save();

            toastr()->success("Direcci??n {$nueva_direccion->direccion} agregada.");
            return redirect()->route("configuracion.{$request->redireccionar}");
        } catch (\Throwable $th) {
            toastr()->error("Error al agregar la direcci??n.");
            return redirect()->route("configuracion.{$request->redireccionar}");
        }
    }

    //Delete de datos telefono
    public function telefono_delete(ConfiguracionTelefono $telefono)
    {
        try {
            $telefono->delete();
            toastr()->success("El n??mero de tel??fono {$telefono->telefono} fue eliminado.");
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error("Error al eliminar el n??mero de tel??fonno.");
            return redirect()->back();
        }
    }

    //Delete de datos direccion
    public function direccion_delete(ConfiguracionDireccion $direccion)
    {
        try {
            $direccion->delete();
            toastr()->success("La direcci??n {$direccion->direccion} fue eliminada.");
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error("Error al eliminar la direcci??n.");
            return redirect()->back();
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        if (is_null($id)) {
            return [
                'redireccionar' => 'required|starts_with:index_pagina,index_sistema',
                'nit' => 'required|max:10|unique:configuracion,nit',
                'nombre' => 'required|max:50',
                'slogan' => 'required|max:5',
                'vision' => 'nullable|max:1000',
                'mision' => 'nullable|max:1000',
                'logotipo' => 'required|file',
                'ubicacion_x' => 'nullable|numeric',
                'ubicacion_y' => 'nullable|numeric',
                'facebook' => 'nullable|max:100',
                'twitter' => 'nullable|max:100',
                'instagram' => 'nullable|max:100',
                'url' => 'nullable|max:100',
            ];
        } else {
            return [
                'redireccionar' => 'required|starts_with:index_pagina,index_sistema',
                'nit' => 'required|max:10|unique:configuracion,nit,' . $id,
                'nombre' => 'required|max:50',
                'slogan' => 'required|max:5',
                'vision' => 'nullable|max:1000',
                'mision' => 'nullable|max:1000',
                'logotipo' => 'nullable|file',
                'ubicacion_x' => 'nullable|numeric',
                'ubicacion_y' => 'nullable|numeric',
                'facebook' => 'nullable|max:100',
                'twitter' => 'nullable|max:100',
                'instagram' => 'nullable|max:100',
                'url' => 'nullable|max:100',
            ];
        }
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'redireccionar.required' => 'El par??metro de redireccionamiento es obligatorio.',
            'redireccionar.starts_with' => 'El par??metro de redireccionamiento solo pueder ser index_pagina o index_sistema.',

            'nit.required' => 'El nit es obligatorio.',
            'nit.max'  => 'El nit debe tener menos de :max caracteres.',
            'nit.unique'  => 'El nit ingresado ya existe en el sistema.',

            'nombre.required' => 'El nombre de la empresa es obligatorio.',
            'nombre.max'  => 'El nombre de la empresa debe tener menos de :max caracteres.',

            'slogan.required' => 'El slogan es obligatorio.',
            'slogan.max'  => 'El slogan debe tener menos de :max caracteres.',

            'vision.required' => 'La visi??n de la empresa es obligatorio.',
            'vision.max'  => 'La visi??n de la empresa debe tener menos de :max caracteres.',

            'mision.required' => 'La misi??n de la empresa es obligatorio.',
            'mision.max'  => 'La misi??n de la empresa debe tener menos de :max caracteres.',

            'logotipo.required' => 'El logotipo de la empresa es obligatorio.',
            'logotipo.file'  => 'El logotipo de la empresa debe de ser imagen.',

            'ubicacion_x.required' => 'La longitud es obligatoria.',
            'ubicacion_x.numeric'  => 'La longitud solo debe contener n??meros.',

            'ubicacion_y.required' => 'La latitud es obligatoria.',
            'ubicacion_y.numeric'  => 'La latitud solo debe contener n??meros.',

            'facebook.required' => 'La URL de facebook es obligatorio.',
            'facebook.url' => 'La URL de facebook no es v??lida.',
            'facebook.max'  => 'La URL de facebook debe tener menos de :max caracteres.',

            'twitter.required' => 'La URL de twitter es obligatorio.',
            'twitter.url' => 'La URL de twitter no es v??lida.',
            'twitter.max'  => 'La URL de twitter debe tener menos de :max caracteres.',

            'instagram.required' => 'La URL de instagram es obligatorio.',
            'instagram.url' => 'La URL de instagram no es v??lida.',
            'instagram.max'  => 'La URL de instagram debe tener menos de :max caracteres.',

            'url.required' => 'La URL de p??gina es obligatorio.',
            'url.url' => 'La URL de p??gina no es v??lida.',
            'url.max'  => 'La URL de p??gina debe tener menos de :max caracteres.',
        ];
    }
}
