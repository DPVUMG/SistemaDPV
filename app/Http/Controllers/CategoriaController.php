<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Support\Str;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
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
                $items = Categoria::with('sub_categorias')->search($request->search)->orderBy('nombre', 'asc')->paginate(10);
            else
                $items = Categoria::with('sub_categorias')->orderBy('nombre', 'asc')->paginate(10);

            return view('sistema.catalogo.categoria.index', compact('items'));
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
        //
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
            $img_data = file_get_contents($request->file('icono'));
            $image = Image::make($img_data);
            $image->encode('jpg', 70);
            $nombre = Str::random(10);
            $data = $request->all();
            $data['icono'] = "{$nombre}.jpg";
            $data['usuario_id'] = Auth::user()->id;
            Categoria::create($data);
            Storage::disk('categoria')->put($data['icono'], $image);
            toastr()->success('Registro guardado.');
            return redirect()->route('categoria.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar.');
            return redirect()->route('categoria.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categorium
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Categoria $categorium)
    {
        try {
            if ($request->has('search'))
                $items = SubCategoria::search($request->search)->where('categoria_id', $categorium->id)->orderBy('nombre', 'asc')->paginate(10);
            else
                $items = SubCategoria::where('categoria_id', $categorium->id)->orderBy('nombre', 'asc')->paginate(10);

            return view('sistema.catalogo.categoria.sub_categoria.index', compact('items', 'categorium'));
        } catch (\Throwable $th) {
            toastr()->error('Error al buscar las sub categorías.');
            return redirect()->route('categoria.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categorium
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categorium)
    {
        return view('sistema.catalogo.categoria.edit', compact('categorium'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categorium
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categorium)
    {
        $this->validate($request, $this->rules($categorium->id), $this->messages());

        try {
            $categorium->nombre = $request->nombre;

            if (!empty($request->icono)) {
                Storage::disk('categoria')->exists($categorium->icono) ? Storage::disk('categoria')->delete($categorium->icono) : null;

                $img_data = file_get_contents($request->file('icono'));
                $image = Image::make($img_data);
                $image->encode('jpg', 70);
                $nombre = Str::random(10);
                $categorium->icono = "{$nombre}.jpg";

                Storage::disk('categoria')->put($categorium->icono, $image);
            }

            if (!$categorium->isDirty()) {
                toastr()->info('El sistema no detecto cambios nuevos para guardar.');
                return redirect()->route('categoria.index');
            }

            $categorium->save();
            toastr()->success('Registro actualizado.');
            return redirect()->route('categoria.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar.');
            return redirect()->route('categoria.edit', ['categorium' => $categorium]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categorium
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categorium)
    {
        try {
            $categorium->delete();
            Storage::disk('categoria')->exists($categorium->icono) ? Storage::disk('categoria')->delete($categorium->icono) : null;
            toastr()->success('Registro eliminado.');
            return redirect()->route('categoria.index');
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro {$categorium->nombre}, porque tiene información asociada.");
                return redirect()->route('categoria.index');
            }
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = array();

        if (is_null($id)) {
            $validar = [
                'nombre' => 'required|max:25|unique:categoria,nombre',
                'icono' => 'required|file'
            ];
        } else {
            $validar = [
                'nombre' => 'required|max:25|unique:categoria,nombre,' . $id
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'nombre.required' => 'El nombre de la categoria es obligatorio.',
            'nombre.max'  => 'El nombre debe tener menos de :max caracteres.',
            'nombre.unique'  => 'El nombre de la categoria ingresado ya existe en el sistema.',

            'icono.required' => 'El icono de la categoria es obligatorio.',
            'icono.file'  => 'El icono de la categoria debe de ser imagen.'
        ];
    }
}
