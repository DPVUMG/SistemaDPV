<?php

use App\Models\Mes;
use App\Models\Banco;
use App\Models\Gasto;
use App\Models\Escuela;
use App\Models\Persona;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\PagoPedido;
use App\Models\EstadoPedido;
use App\Models\Configuracion;
use App\Models\EscuelaPedido;
use App\Models\EscuelaUsuario;
use App\Imports\EscuelasImport;
use Illuminate\Database\Seeder;
use App\Imports\MunicipioImport;
use App\Imports\ProductosImport;
use App\Models\ProductoVariante;
use App\Imports\DepartamentoImport;
use App\Models\EscuelaDetallePedido;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\EscuelaPedidoHistorial;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Migrando Departamento y Municipios asociados
        Excel::import(new DepartamentoImport, 'database/seeds/Catalogos/Departamentos.xlsx');
        Excel::import(new MunicipioImport, 'database/seeds/Catalogos/Municipios.xlsx');

        factory(Persona::class, 25)->create();
        echo "Personas." . PHP_EOL;
        factory(Usuario::class, 25)->create();
        Usuario::where('id', 1)->update(['usuario' => 'admin@admin.com']);
        echo "Usuarios." . PHP_EOL;

        $meses = [
            ['nombre' => 'Enero'],
            ['nombre' => 'Febrero'],
            ['nombre' => 'Marzo'],
            ['nombre' => 'Abril'],
            ['nombre' => 'Mayo'],
            ['nombre' => 'Junio'],
            ['nombre' => 'Julio'],
            ['nombre' => 'Agosto'],
            ['nombre' => 'Septiembre'],
            ['nombre' => 'Octubre'],
            ['nombre' => 'Noviembre'],
            ['nombre' => 'Diciembre']
        ];
        Mes::insert($meses);
        echo "Meses." . PHP_EOL;

        Excel::import(new EscuelasImport, 'database/seeds/Catalogos/establecimientos.xlsx');
        Excel::import(new ProductosImport, 'database/seeds/Catalogos/Productos.xlsx');

        $estados = [
            ['nombre' => 'Ingresado'],
            ['nombre' => 'Confirmado'],
            ['nombre' => 'Entregado'],
            ['nombre' => 'Pagado'],
            ['nombre' => 'Anulado'],
            ['nombre' => 'Cancelado']
        ];
        EstadoPedido::insert($estados);
        echo "Estados de pedidos." . PHP_EOL;

        $bancos = [
            ['nombre' => 'Banco G&T'],
            ['nombre' => 'Scotiabank'],
            ['nombre' => 'Multibank'],
            ['nombre' => 'HSBC'],
            ['nombre' => 'Óptima Servicios Financieros'],
            ['nombre' => 'Financiera Fama'],
            ['nombre' => 'Fedecrédito'],
            ['nombre' => 'Credimás'],
            ['nombre' => 'Credicorp Bank'],
            ['nombre' => 'Corporación Pacífico'],
            ['nombre' => 'Banistmo'],
            ['nombre' => 'Banco de Finanzas'],
            ['nombre' => 'Banco Davivienda'],
            ['nombre' => 'Grupo Lafise'],
            ['nombre' => 'Banco Atlántida'],
            ['nombre' => 'Integral'],
            ['nombre' => 'Banco Hipotecario'],
            ['nombre' => 'Banco Agrícola'],
            ['nombre' => 'Grupo Financiero Occidente, S.A.'],
            ['nombre' => 'Banco Promerica'],
            ['nombre' => 'BAC'],
            ['nombre' => 'Banco de Credito'],
            ['nombre' => 'Financiera Summa'],
            ['nombre' => 'Westrust Bank'],
            ['nombre' => 'Banrural'],
            ['nombre' => 'Compartamos S.A.'],
            ['nombre' => '5B'],
            ['nombre' => 'Vivi Banco'],
            ['nombre' => 'Invest in Guatemala'],
            ['nombre' => 'Bantrab'],
            ['nombre' => 'Banco Industrial']
        ];
        Banco::insert($bancos);
        echo "Bancos." . PHP_EOL;

        Configuracion::create(
            [
                'nit' => 'default',
                'nombre' => 'default',
                'slogan' => 'default',
                'vision' => 'default',
                'mision' => 'default',
                'logotipo' => 'default',
                'ubicacion_x' => '0',
                'ubicacion_y' => '0',
                'facebook' => 'default',
                'twitter' => 'default',
                'instagram' => 'default',
                'url' => 'default',
                'pagina' => true,
                'sistema' => false
            ]
        );

        $escuelas = Escuela::all()->random()->get();

        foreach ($escuelas as $key => $escuela) {

            $cantidad_pedidos = random_int(1, 200);

            for ($i = 0; $i < $cantidad_pedidos; $i++) {

                $estado = random_int(1, 6);
                $estado_pedido = EstadoPedido::find($estado);

                $fecha = $this->fecha_aleatoria();
                $fecha_entrega = date("Y-m-d", strtotime($fecha . "+ 3 days"));
                $usuario = EscuelaUsuario::where('escuela_id', $escuela->id)->first();

                $sub_total = 0;
                $descuento = 0;
                $total = 0;

                $pedido = EscuelaPedido::create(
                    [
                        'pagado' => false,
                        'fecha_pedido' => $fecha,
                        'fecha_entrega' => $fecha_entrega,
                        'sub_total' => $sub_total,
                        'descuento' => $descuento,
                        'total' => $total,
                        'anio' => date('Y', strtotime($fecha)),
                        'descripcion' => "data prueba desde el seeder",
                        'escuela_usuario_id' => $usuario->id,
                        'escuela_id' => $escuela->id,
                        'estado_pedido_id' => $estado_pedido->id,
                        'mes_id' => date('m', strtotime($fecha))
                    ]
                );

                $cantidad_productos = random_int(1, 50);

                for ($j = 0; $j < $cantidad_productos + 1; $j++) {

                    $producto = Producto::all()->random()->first();
                    $precio_variante = ProductoVariante::where('id', $producto->id)->where('activo', true)->first();

                    $cantidad = random_int(1, 250);

                    $estado_detalle = random_int(0, 1);

                    $detalle = EscuelaDetallePedido::create(
                        [
                            'cantidad' => $cantidad,
                            'precio_real' => $precio_variante->precio,
                            'precio_descuento' => 0,
                            'descuento' => 0,
                            'sub_total' => ($cantidad * $precio_variante->precio),
                            'anio' => $pedido->anio,
                            'activo' => $estado_detalle == 1,
                            'escuela_pedido_id' => $pedido->id,
                            'escuela_id' => $pedido->escuela_id,
                            'producto_variante_id' => $precio_variante->id,
                            'producto_id' => $producto->id,
                            'variante_presentacion_id' => $precio_variante->variante_presentacion_id,
                            'variante_id' => $precio_variante->variante_id,
                            'presentacion_id' => $precio_variante->presentacion_id,
                            'mes_id' => $pedido->mes_id
                        ]
                    );

                    if ($detalle->activo) {
                        $total += $cantidad * $precio_variante->precio;
                    }
                }

                $pedido->sub_total = $total;
                $pedido->total = $total;
                $pedido->save();

                switch ($estado_pedido->id) {
                    case 1:
                        $this->historialPedido(1, 1, $pedido->id, $escuela->id);
                        break;
                    case 2:
                        $this->historialPedido(1, 1, $pedido->id, $escuela->id);
                        $this->historialPedido(1, 2, $pedido->id, $escuela->id);
                        break;
                    case 3:
                        $this->historialPedido(1, 1, $pedido->id, $escuela->id);
                        $this->historialPedido(1, 2, $pedido->id, $escuela->id);
                        $this->historialPedido(2, 3, $pedido->id, $escuela->id);
                        break;
                    case 4:
                        $this->historialPedido(1, 1, $pedido->id, $escuela->id);
                        $this->historialPedido(1, 2, $pedido->id, $escuela->id);
                        $this->historialPedido(2, 3, $pedido->id, $escuela->id);
                        $this->historialPedido(3, 4, $pedido->id, $escuela->id);

                        PagoPedido::create(
                            [
                                'numero_cheque' => random_int(10000, 99999999),
                                'tipo_pago' => PagoPedido::CHEQUE,
                                'anio' => date('Y', strtotime($fecha_entrega)),
                                'mes_id' => date('m', strtotime($fecha_entrega)),
                                'escuela_id' => $pedido->escuela_id,
                                'escuela_pedido_id' => $pedido->id,
                                'banco_id' => Banco::all()->random()->first()->id,
                                'monto' => $pedido->total,
                                'usuario_id' => 1
                            ]
                        );

                        $pedido->pagado = true;
                        $pedido->save();
                        break;
                    case 5:
                        $this->historialPedido(1, 1, $pedido->id, $escuela->id);
                        $this->historialPedido(1, 5, $pedido->id, $escuela->id);

                        EscuelaDetallePedido::where('escuela_pedido_id', $pedido->id)->update(['activo' => false]);
                        break;
                    case 6:
                        $this->historialPedido(1, 1, $pedido->id, $escuela->id);
                        $this->historialPedido(1, 6, $pedido->id, $escuela->id);
                        break;
                }
            }
        }

        $cantidad_gastos = random_int(100, 200);
        for ($i = 0; $i < $cantidad_gastos; $i++) {
            $fecha = $this->fecha_aleatoria();
            Gasto::create(
                [
                    'monto' => random_int(75, 500),
                    'descripcion' => "gasto ficticio",
                    'anio' => date('Y', strtotime($fecha)),
                    'mes_id' => date('m', strtotime($fecha)),
                    'usuario_id' => 1,
                    'created_at' => date('Y-m-d H:i:s', strtotime($fecha))
                ]
            );
        }
    }

    public function fecha_aleatoria($limiteInferior = "2022-01-01")
    {
        $limiteSuperior = date('Y-m-d');

        // Convertimos la fecha como cadena a milisegundos
        $milisegundosLimiteInferior = strtotime($limiteInferior);
        $milisegundosLimiteSuperior = strtotime($limiteSuperior);

        // Buscamos un número aleatorio entre esas dos fechas
        $milisegundosAleatorios = mt_rand($milisegundosLimiteInferior, $milisegundosLimiteSuperior);

        // Regresamos la fecha con el formato especificado y los milisegundos aleatorios
        return date("Y-m-d", $milisegundosAleatorios);
    }

    public function historialPedido(int $estado_anterior, int $estado_actual, int $escuela_pedido_id, int $escuela_id, string $descripcion = null)
    {
        if (is_null($descripcion)) {
            switch ($estado_actual) {
                case 1:
                    $descripcion = "El pedido con número {$escuela_pedido_id} fue ingresado.";
                    break;
                case 2:
                    $descripcion = "El pedido con número {$escuela_pedido_id} fue confirmado.";
                    break;
                case 3:
                    $descripcion = "El pedido con número {$escuela_pedido_id} fue entregado.";
                    break;
                case 4:
                    $descripcion = "El pedido con número {$escuela_pedido_id} fue pagado.";
                    break;
                case 5:
                    $descripcion = "El pedido con número {$escuela_pedido_id} fue anulado.";
                    break;
                case 6:
                    $descripcion = "El pedido con número {$escuela_pedido_id} fue cancelado.";
                    break;
            }
        }

        EscuelaPedidoHistorial::create(
            [
                'estado_anterior' => EstadoPedido::find($estado_anterior)->nombre,
                'estado_actual' => EstadoPedido::find($estado_actual)->nombre,
                'descripcion' => $descripcion,
                'usuario' => 'Prueba',
                'escuela_id' => $escuela_id,
                'estado_pedido_id' => $estado_actual,
                'escuela_pedido_id' => $escuela_pedido_id
            ]
        );
    }
}
