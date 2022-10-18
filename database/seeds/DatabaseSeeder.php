<?php

use App\User;
use App\Brand;
use App\Image;
use App\Credit;
use App\Comment;
use App\Company;
use App\Product;
use App\Category;
use App\Models\Mes;
use App\SubCategory;
use App\CompanyPhone;
use App\DiscountRate;
use App\CompanyAddress;
use App\Models\Persona;
use App\Models\Usuario;
use App\ProductComment;
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
        factory(DiscountRate::class, 10)->create();
        echo "Tipos de creditos." . PHP_EOL;
        factory(Company::class, 1)->create();
        echo "Nombre de la empresa ingresado." . PHP_EOL;
        factory(CompanyPhone::class, 3)->create();
        echo "Teléfonos de la empresa ingresado." . PHP_EOL;
        factory(CompanyAddress::class, 4)->create();
        echo "Direcciones de la empresa agregados." . PHP_EOL;
        factory(User::class, 25)->create();
        User::where('id', 1)->update(['email' => 'admin@admin.com']);
        echo "Usuario ingresados" . PHP_EOL;
        factory(Credit::class, 20)->create();
        echo "Creditos a usuarios." . PHP_EOL;
        factory(Comment::class, 100)->create();
        echo "Comentarios ingresados" . PHP_EOL;
        factory(Brand::class, 25)->create();
        echo "Marcas de productos ingresados" . PHP_EOL;
        factory(Category::class, 10)->create();
        echo "Categorias para productos ingresados" . PHP_EOL;
        factory(SubCategory::class, 20)->create();
        echo "Sub categorias para productos ingresados" . PHP_EOL;
        factory(Product::class, 75)->create();
        echo "Productos ingresados" . PHP_EOL;
        factory(Image::class, 300)->create();
        echo "Imagenes para productos ingresados" . PHP_EOL;
        factory(ProductComment::class, 50)->create();
        echo "Comentarios para los productos ingresados" . PHP_EOL;


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
