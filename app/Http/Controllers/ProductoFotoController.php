<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Support\Str;
use App\Models\ProductoFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class ProductoFotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductoFoto  $producto_foto
     * @return \Illuminate\Http\Response
     */
    public function show(ProductoFoto $producto_foto)
    {
        try {
            Producto::where('id', $producto_foto->producto_id)
                ->update(['foto' => $producto_foto->foto]);

            toastr()->success("La fotografía principal fue actualizada.");
            return redirect()->route('producto_foto.edit', $producto_foto->producto_id);
        } catch (\Throwable $th) {
            toastr()->error('Error al cambiar la imagen principal.');
            return redirect()->route('producto_foto.edit', $producto_foto->producto_id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto_foto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto_foto)
    {
        try {
            $producto = $producto_foto;
            $items = ProductoFoto::where('producto_id', $producto_foto->id)->paginate(10);

            return view('sistema.producto.show', compact('producto', 'items'));
        } catch (\Throwable $th) {
            toastr()->error('Error al seleccionar el producto.');
            return redirect()->route('producto.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto_foto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto_foto)
    {
        $this->validate($request, $this->rules(), $this->messages());

        try {
            $img_data = file_get_contents($request->file('foto'));
            $image = Image::make($img_data);
            $image->encode('jpg', 70);
            $nombre = Str::random(10);
            $data['usuario_id'] = Auth::user()->id;
            $data['foto'] = "{$nombre}.jpg";
            $data['producto_id'] = $producto_foto->id;

            Storage::disk('producto')->put("{$producto_foto->id}/{$data['foto']}", $image);
            ProductoFoto::create($data); //Guardamos la fotografia del producto

            toastr()->success('Registro guardado.');
            return redirect()->route('producto_foto.edit', $producto_foto->id);
        } catch (\Throwable $th) {
            toastr()->error('Error al guardar.');
            return redirect()->route('producto_foto.edit', $producto_foto->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductoFoto  $producto_foto
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductoFoto $producto_foto)
    {
        try {
            $producto_foto->delete();
            Storage::disk('producto')->exists("{$producto_foto->producto_id}/{$producto_foto->foto}") ? Storage::disk('producto')->delete("{$producto_foto->producto_id}/{$producto_foto->foto}") : null;
            toastr()->success('Registro eliminado.');
            return redirect()->route('producto_foto.edit', $producto_foto->producto_id);
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar la fotografía.");
                return redirect()->route('producto_foto.edit', $producto_foto->producto_id);
            }
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = [
            'foto' => 'required|file'
        ];

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'foto.required' => 'La foto del producto es obligatorio.',
            'foto.file'  => 'La foto del producto debe de ser imagen.'
        ];
    }
}
