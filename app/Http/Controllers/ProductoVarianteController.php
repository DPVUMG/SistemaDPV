<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\ProductoVariante;
use Illuminate\Support\Facades\DB;
use App\Models\VariantePresentacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class ProductoVarianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::join('producto_variante', 'producto_variante.producto_id', 'producto.id')
            ->select(
                'producto.id AS id',
                'producto.nombre AS producto'
            )
            ->where('producto.activo', true)
            ->groupBy('id', 'producto')
            ->orderby('producto.nombre', 'asc')->get();

        $precios = ProductoVariante::join('producto', 'producto.id', 'producto_variante.producto_id')
            ->join('variante', 'variante.id', 'producto_variante.variante_id')
            ->join('presentacion', 'presentacion.id', 'producto_variante.presentacion_id')
            ->select(
                'producto_variante.id AS id',
                'producto.id AS producto_id',
                DB::RAW("CONCAT(variante.nombre,' - ',presentacion.nombre) AS producto"),
                DB::raw("FORMAT(producto_variante.precio, 2) AS precio")
            )
            ->where('producto_variante.activo', true)
            ->where('producto.activo', true)
            ->orderby('producto.nombre', 'asc')->get();

        return response()->json(['productos' => $productos, 'precios' => $precios]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductoVariante  $producto_variante
     * @return \Illuminate\Http\Response
     */
    public function show(ProductoVariante $producto_variante)
    {
        try {
            DB::beginTransaction();

            ProductoVariante::where('producto_id', $producto_variante->producto_id)
                ->where('variante_presentacion_id', $producto_variante->variante_presentacion_id)
                ->update(['activo' => false]);

            $producto_variante->activo = true;
            $producto_variante->save();
            DB::commit();

            toastr()->success("El precio de la variante {$producto_variante->variante->nombre} y presentación {$producto_variante->presentacion->nombre} activado.");
            return redirect()->route('producto.edit', $producto_variante->producto_id);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error('Error al cambiar el estado del precio.');
            return redirect()->route('producto.edit', $producto_variante->producto_id);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto_variante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto_variante)
    {
        $this->validate($request, $this->rules(), $this->messages());

        try {
            DB::beginTransaction();

            ProductoVariante::where('producto_id', $producto_variante->id)
                ->where('variante_presentacion_id', $request->variante_presentacion_id)
                ->update(['activo' => false]);

            $variante_presentacion = VariantePresentacion::find($request->variante_presentacion_id);

            $data['usuario_id'] = Auth::user()->id;
            $data['producto_id'] = $producto_variante->id;
            $data['variante_presentacion_id'] = $variante_presentacion->id;
            $data['variante_id'] = $variante_presentacion->variante_id;
            $data['presentacion_id'] = $variante_presentacion->presentacion_id;
            $data['precio'] = $request->precio;
            $data['activo'] = true;

            ProductoVariante::create($data); //Guardamos el precio del producto

            DB::commit();

            toastr()->success('Registro guardado.');
            return redirect()->route('producto.edit', $producto_variante->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error('Error al guardar.');
            return redirect()->route('producto.edit', $producto_variante->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductoVariante  $producto_variante
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductoVariante $producto_variante)
    {
        try {
            $producto_variante->delete();
            toastr()->success('Registro eliminado.');
            return redirect()->route('producto.edit', $producto_variante->producto_id);
        } catch (\Exception $e) {
            if ($e instanceof QueryException) {
                toastr()->error("El sistema no puede eliminar el registro {$producto_variante->variante->nombre} - {$producto_variante->presentacion->nombre}, porque tiene información asociada.");
                return redirect()->route('producto.edit', $producto_variante->producto_id);
            }
        }
    }

    //Reglas de validaciones
    public function rules($id = null)
    {
        $validar = [
            'variante_presentacion_id' => 'required|integer|exists:variante_presentacion,id',
            'precio' => 'required|numeric|between:1,100000',
        ];

        return $validar;
    }

    //Mensajes para las reglas de validaciones
    public function messages($id = null)
    {
        return [
            'variante_presentacion_id.required' => 'La variante y presentación es obligatoria.',
            'variante_presentacion_id.integer'  => 'La variante y presentación debe de ser un número entero.',
            'variante_presentacion_id.exists'  => 'La variante y presentación seleccionada no existe.',

            'precio.required' => 'El precio del producto es obligatoria.',
            'precio.numeric'  => 'El precio del producto debe de ser un número.',
            'precio.between'  => 'El precio del producto debe ser un valor entre :min y :max.'
        ];
    }
}
