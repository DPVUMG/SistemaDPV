<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Escuela;
use Illuminate\Http\Request;
use App\Models\EscuelaDescuento;
use App\Models\ProductoVariante;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EscuelaDescuentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $items = EscuelaDescuento::orderBy('created_at', 'desc')->get();

            return view('sistema.descuento.index', compact('items'));
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
        $this->validate($request, [
            'precio' => 'required|numeric|between:1,100000',
            'producto_variante_id' => 'required|integer|exists:producto_variante,id',
            'escuela_id.*' => 'required|integer|exists:escuela,id',
        ], [
            'precio.required' => 'El precio del producto es obligatoria.',
            'precio.numeric'  => 'El precio del producto debe de ser un número.',
            'precio.between'  => 'El precio del producto debe ser un valor entre :min y :max.',

            'producto_variante_id.required' => 'El producto es obligatorio.',
            'producto_variante_id.integer'  => 'El producto debe de ser un número entero.',
            'producto_variante_id.exists'  => 'El producto seleccionado no existe.',

            'escuela_id.*.required' => 'La escuela es obligatorio.',
            'escuela_id.*.integer'  => 'La escuela debe de ser un número entero.',
            'escuela_id.*.exists'  => 'La escuela seleccionado no existe.'
        ]);

        try {
            DB::beginTransaction();

            $producto_variante = ProductoVariante::find($request->producto_variante_id);

            if ($request->precio > $producto_variante->precio) {
                throw new Exception("El precio original del producto no puede ser menor al descuento.", 1000);
            }

            foreach ($request->escuela_id as $escuela_id) {

                EscuelaDescuento::where('escuela_id', $escuela_id)
                    ->where('producto_variante_id', $producto_variante->id)->update([
                        'activo' => false
                    ]);

                EscuelaDescuento::create(
                    [
                        'precio_original' => $producto_variante->precio,
                        'precio' => $request->precio,
                        'escuela_id' => $escuela_id,
                        'producto_variante_id' => $producto_variante->id,
                        'producto_id' => $producto_variante->producto_id,
                        'variante_presentacion_id' => $producto_variante->variante_presentacion_id,
                        'variante_id' => $producto_variante->variante_id,
                        'presentacion_id' => $producto_variante->presentacion_id,
                        'activo' => true,
                        'usuario_id' => Auth::user()->id
                    ]
                );
            }

            DB::commit();

            toastr()->success('Registro guardado.');

            return redirect()->route('escuela_descuento.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            if ($th->getCode() == 1000)
                toastr()->info($th->getMessage());
            else
                toastr()->error('Error al guardar.');

            return redirect()->route('escuela_descuento.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Escuela  $escuela_descuento
     * @return \Illuminate\Http\Response
     */
    public function show(Escuela $escuela_descuento)
    {
        try {
            return view('sistema.adminstracion_escuela.descuento.index', compact('escuela_descuento'));
        } catch (\Throwable $th) {
            toastr()->error('Error al cargar la pantalla.');
            return redirect()->route(
                'escuela.edit',
                ['escuela' => $escuela_descuento->id]
            );
        }
    }

    /**
     * Update status.
     *
     * @param  \App\Models\EscuelaDescuento  $escuela_descuento
     * @return \Illuminate\Http\Response
     */
    public function status(EscuelaDescuento $escuela_descuento)
    {
        try {
            DB::beginTransaction();

            EscuelaDescuento::where('escuela_id', $escuela_descuento->escuela_id)
                ->where('producto_variante_id', $escuela_descuento->producto_variante_id)->update([
                    'activo' => false
                ]);

            $escuela_descuento->activo = true;
            $escuela_descuento->save();

            DB::commit();

            toastr()->success($escuela_descuento->activo ? "El descuento {$escuela_descuento->precio} para el producto {$escuela_descuento->producto->nombre} fue activado" : "El descuento {$escuela_descuento->precio} para el producto {$escuela_descuento->producto->nombre} fue desactivado");
            return redirect()->route('escuela_descuento.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error('Error al cambiar el estado.');
            return redirect()->route('escuela_descuento.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Escuela  $escuela_descuento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Escuela $escuela_descuento)
    {
        $this->validate($request, [
            'precio' => 'required|numeric|between:0,100000',
            'producto_variante_id' => 'required|integer|exists:producto_variante,id'
        ], [
            'precio.required' => 'El precio del producto es obligatoria.',
            'precio.numeric'  => 'El precio del producto debe de ser un número.',
            'precio.between'  => 'El precio del producto debe ser un valor entre :min y :max.',

            'producto_variante_id.required' => 'El producto es obligatorio.',
            'producto_variante_id.integer'  => 'El producto debe de ser un número entero.',
            'producto_variante_id.exists'  => 'El producto seleccionado no existe.'
        ]);

        try {
            DB::beginTransaction();

            $producto_variante = ProductoVariante::find($request->producto_variante_id);

            EscuelaDescuento::where('escuela_id', $escuela_descuento->id)
                ->where('producto_variante_id', $producto_variante->id)->update([
                    'activo' => false
                ]);

            EscuelaDescuento::create(
                [
                    'precio_original' => $producto_variante->precio,
                    'precio' => $request->precio,
                    'escuela_id' => $escuela_descuento->id,
                    'producto_variante_id' => $producto_variante->id,
                    'producto_id' => $producto_variante->producto_id,
                    'variante_presentacion_id' => $producto_variante->variante_presentacion_id,
                    'variante_id' => $producto_variante->variante_id,
                    'presentacion_id' => $producto_variante->presentacion_id,
                    'activo' => true,
                    'usuario_id' => Auth::user()->id
                ]
            );

            DB::commit();

            toastr()->success('Registro guardado.');

            return redirect()->route('escuela_descuento.show', $escuela_descuento);
        } catch (\Throwable $th) {
            DB::rollBack();

            if ($th->getCode() == 1000)
                toastr()->info($th->getMessage());
            else
                toastr()->error('Error al guardar.');

            return redirect()->route('escuela_descuento.show', $escuela_descuento);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EscuelaDescuento  $escuela_descuento
     * @return \Illuminate\Http\Response
     */
    public function destroy(EscuelaDescuento $escuela_descuento)
    {
        try {
            DB::beginTransaction();

            EscuelaDescuento::where('escuela_id', $escuela_descuento->escuela_id)
                ->where('producto_variante_id', $escuela_descuento->producto_variante_id)->update([
                    'activo' => false
                ]);

            $escuela_descuento->activo = true;
            $escuela_descuento->save();

            DB::commit();

            toastr()->success($escuela_descuento->activo ? "El descuento {$escuela_descuento->precio} para el producto {$escuela_descuento->producto->nombre} fue activado" : "El descuento {$escuela_descuento->precio} para el producto {$escuela_descuento->producto->nombre} fue desactivado");
            return redirect()->route('escuela_descuento.show', $escuela_descuento->escuela_id);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error('Error al cambiar el estado.');
            return redirect()->route('escuela_descuento.show', $escuela_descuento->escuela_id);
        }
    }
}
