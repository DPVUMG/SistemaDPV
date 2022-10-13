<?php

namespace App\Imports;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Presentacion;
use App\Models\Producto;
use App\Models\ProductoSubCategoria;
use App\Models\ProductoVariante;
use App\Models\SubCategoria;
use App\Models\Usuario;
use App\Models\Variante;
use App\Models\VariantePresentacion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductosImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            if ($key > 1) {
                $mensaje = "";
                if (!is_null($value[1])) {
                    $marca = Marca::firstOrCreate(
                        ['nombre' => $value[1], 'usuario_id' => Usuario::all()->random()->first()->id],
                        ['nombre' => $value[1]]
                    );

                    $mensaje .= "Marca: {$marca->nombre}";

                    $variante = Variante::firstOrCreate(
                        ['nombre' => $value[2], 'usuario_id' => Usuario::all()->random()->first()->id],
                        ['nombre' => $value[2]]
                    );

                    $mensaje .= " - Variante: {$variante->nombre}";

                    $categoria = Categoria::firstOrCreate(
                        ['nombre' => $value[3], 'usuario_id' => Usuario::all()->random()->first()->id],
                        ['nombre' => $value[3]]
                    );

                    $mensaje .= " - Categoría: {$categoria->nombre}";

                    $sub_categoria = SubCategoria::firstOrCreate(
                        ['nombre' => $value[4], 'categoria_id' => $categoria->id, 'usuario_id' => Usuario::all()->random()->first()->id],
                        ['nombre' => $value[4]]
                    );

                    $mensaje .= " - Sub Categoría: {$sub_categoria->nombre}";

                    $presentacion = Presentacion::firstOrCreate(
                        ['nombre' => $value[5], 'usuario_id' => Usuario::all()->random()->first()->id],
                        ['nombre' => $value[5]]
                    );

                    $mensaje .= " - Presentacion: {$presentacion->nombre}";

                    $variante_presentacion = VariantePresentacion::firstOrCreate(
                        ['variante_id' => $variante->id, 'presentacion_id' => $presentacion->id, 'usuario_id' => Usuario::all()->random()->first()->id],
                        ['variante_id' => $variante->id, 'presentacion_id' => $presentacion->id]
                    );

                    $producto = Producto::firstOrCreate(
                        [
                            'codigo' => $this->generadorCodigo('P', Producto::count()),
                            'nombre' => $value[6],
                            'descripcion' => $value[9],
                            'temporada' => is_null($value[7]) ? false : true,
                            'marca_id' => $marca->id,
                            'usuario_id' => Usuario::all()->random()->first()->id
                        ],
                        ['nombre' => $value[6]]
                    );

                    $mensaje .= " - Producto: {$producto->nombre}";

                    ProductoSubCategoria::create([
                        'producto_id' => $producto->id,
                        'categoria_id' => $categoria->id,
                        'sub_categoria_id' => $sub_categoria->id,
                        'usuario_id' => $producto->usuario_id,
                    ]);

                    $producto_variante = ProductoVariante::create([
                        'precio' => $producto->temporada ? 0 : $value[8],
                        'producto_id' => $producto->id,
                        'variante_presentacion_id' => $variante_presentacion->id,
                        'variante_id' => $variante_presentacion->variante_id,
                        'presentacion_id' => $variante_presentacion->presentacion_id,
                        'usuario_id' => $producto->usuario_id,
                    ]);

                    $mensaje .= " - Precio: {$producto_variante->precio}";

                    echo $mensaje . PHP_EOL;
                }
            }
        }
    }

    protected function generadorCodigo(string $palabra, int $correlativo)
    {
        $correlativo = $correlativo === 0 ? 1 : $correlativo + 1;
        $codigo = str_pad(strval($correlativo), 5, "0", STR_PAD_LEFT);
        $anio = date('Y');
        return "{$palabra}{$codigo}{$anio}";
    }
}
