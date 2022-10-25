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
use App\Models\Banco;
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
    }
}
