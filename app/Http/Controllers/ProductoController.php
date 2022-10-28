<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Producto;
use App\Models\ProductoFoto;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use App\Models\ProductoVariante;
use Illuminate\Support\Facades\DB;
use App\Models\ProductoSubCategoria;
use App\Models\VariantePresentacion;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
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
                $items = Producto::with('marca', 'producto_subcategoria')->search($request->search)->orderBy('producto.created_at', 'desc')->paginate(10);
            else
                $items = Producto::with('marca', 'producto_subcategoria')->orderBy('producto.created_at', 'desc')->paginate(10);

            $marcas = Marca::orderBy('nombre', 'asc')->get();
            $subcategorias = SubCategoria::with('categoria')->get();
            $variantes_presentaciones = VariantePresentacion::with('variante', 'presentacion')->get();

            return view('sistema.producto.index', compact('items', 'marcas', 'subcategorias', 'variantes_presentaciones'));
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
            DB::beginTransaction(); //Inciamos la transacción

            $data = $request->all();
            $data['usuario_id'] = Auth::user()->id;
            $data['codigo'] = $this->generadorCodigo('P', Producto::count());
            $data['foto'] = null;
            $data['nuevo'] = true;
            $data['activo'] = false;
            $data['temporada'] = $request->has('temporada');

            $producto = Producto::create($data); //Guardamos el producto

            $img_data = file_get_contents($request->file('foto'));
            $image = Image::make($img_data);
            $image->encode('jpg', 70);
            $nombre = "{$producto->id}.jpg";

            $data['foto'] = $nombre;
            Storage::disk('producto')->put("{$producto->id}/{$nombre}", $image);

            $producto->foto = $nombre;

            $data['producto_id'] = $producto->id;
            ProductoFoto::create($data); //Guardamos la fotografia del producto

            foreach ($request->producto_subcategoria as $value) {
                $data['sub_categoria_id'] = $value;
                $data['categoria_id'] = SubCategoria::find($value)->categoria_id;

                ProductoSubCategoria::create($data); //Guardamos las categorias asignadas al producto
            }

            $variante_presentacion = VariantePresentacion::find($data['variante_presentacion_id']);

            $data['variante_id'] = $variante_presentacion->variante_id;
            $data['presentacion_id'] = $variante_presentacion->presentacion_id;
            $data['activo'] = true;
            ProductoVariante::create($data); //Guardamos el precio del producto

            DB::commit(); //Terminamos la transacción, se cumple todo.

            toastr()->success('Registro guardado.');
            return redirect()->route('producto.index');
        } catch (\Throwable $th) {
            DB::rollBack(); //Si hay error revertimos los datos guardados en las tablas previas al error
            toastr()->error('Error al guardar.');
            return redirect()->route('producto.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        try {
            $producto->activo = $producto->activo ? false : true;
            $producto->save();

            toastr()->success($producto->activo ? "Producto {$producto->codigo} desactivado." : "Producto {$producto->codigo} activado.");
            return redirect()->route('producto.index');
        } catch (\Throwable $th) {
            toastr()->error('Error al cambiar el estado el producto.');
            return redirect()->route('producto.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        $marcas = Marca::orderBy('nombre', 'asc')->get();
        $subcategorias = SubCategoria::with('categoria')->get();
        $variantes_presentaciones = VariantePresentacion::with('variante', 'presentacion')->get();
        return view('sistema.producto.edit', compact('producto', 'marcas', 'subcategorias', 'variantes_presentaciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $this->validate($request, $this->rules($producto->id), $this->messages());

        try {
            DB::beginTransaction(); //Inciamos la transacción

            $producto->nombre = $request->nombre;
            $producto->marca_id = $request->marca_id;
            $producto->descripcion = $request->descripcion;
            $producto->temporada = $request->has('temporada');
            $producto->save(); //Guardamos el producto

            ProductoSubCategoria::where('producto_id', $producto->id)->delete();
            foreach ($request->producto_subcategoria as $value) {
                $data['usuario_id'] = Auth::user()->id;
                $data['producto_id'] = $producto->id;
                $data['sub_categoria_id'] = $value;
                $data['categoria_id'] = SubCategoria::find($value)->categoria_id;

                ProductoSubCategoria::create($data); //Guardamos las categorias asignadas al producto
            }

            DB::commit(); //Terminamos la transacción, se cumple todo.

            toastr()->success('Registro actualizado.');

            return redirect()->route('producto.edit', $producto->id);
        } catch (\Throwable $th) {
            DB::rollBack(); //Si hay error revertimos los datos guardados en las tablas previas al error
            toastr()->error('Error al guardar.');
            return redirect()->route('producto.edit', $producto->id);
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = array();

        if (is_null($id)) {
            $validar = [
                'nombre' => 'required|max:75|unique:producto,nombre',
                'marca_id' => 'required|integer|exists:marca,id',
                'producto_subcategoria' => 'required|array',
                'producto_subcategoria.*' => 'required|integer|exists:sub_categoria,id',
                'descripcion' => 'required',
                'variante_presentacion_id' => 'required|integer|exists:variante_presentacion,id',
                'precio' => 'required|numeric|between:1,100000',
                'foto' => 'required|file'
            ];
        } else {
            $validar = [
                'nombre' => 'required|max:75|unique:producto,nombre,' . $id,
                'marca_id' => 'required|integer|exists:marca,id',
                'producto_subcategoria' => 'required|array',
                'producto_subcategoria.*' => 'required|integer|exists:sub_categoria,id',
                'descripcion' => 'required'
            ];
        }

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'temporada.required' => 'El parámetro de temporada es obligatorio.',
            'temporada.accepted' => 'La temporada del producto solo puede ser verdadera o falsa.',

            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.unique' => 'El nombre del producto ya existe en el sistema.',
            'nombre.max'  => 'El nombre debe tener menos de :max caracteres.',

            'marca_id.required' => 'La marca es obligatoria.',
            'marca_id.integer'  => 'La marca debe de ser un número entero.',
            'marca_id.exists'  => 'La marca seleccionada no existe.',

            'producto_subcategoria.array' => 'Debe de seleccionar al menos una categoria.',
            'producto_subcategoria.required' => 'Debe de seleccionar al menos una categoria.',

            'producto_subcategoria.*.required' => 'La categoría es obligatoria.',
            'producto_subcategoria.*.integer'  => 'La categoría debe de ser un número entero.',
            'producto_subcategoria.*.exists'  => 'La categoría seleccionada no existe.',

            'descripcion.required' => 'La descripción del producto es obligatoria.',

            'variante_presentacion_id.required' => 'La variante y presentación es obligatoria.',
            'variante_presentacion_id.integer'  => 'La variante y presentación debe de ser un número entero.',
            'variante_presentacion_id.exists'  => 'La variante y presentación seleccionada no existe.',

            'precio.required' => 'El precio del producto es obligatoria.',
            'precio.numeric'  => 'El precio del producto debe de ser un número.',
            'precio.between'  => 'El precio del producto debe ser un valor entre :min y :max.',

            'foto.required' => 'La foto del producto es obligatorio.',
            'foto.file'  => 'La foto del producto debe de ser imagen.'
        ];
    }
}
