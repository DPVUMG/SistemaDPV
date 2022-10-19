<?php

use App\Models\Mes;
use App\Models\Persona;
use App\Models\Usuario;
use App\Models\EstadoPedido;
use App\Imports\EscuelasImport;
use Illuminate\Database\Seeder;
use App\Imports\MunicipioImport;
use App\Imports\ProductosImport;
use App\Imports\DepartamentoImport;
use Maatwebsite\Excel\Facades\Excel;

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
    }
}
