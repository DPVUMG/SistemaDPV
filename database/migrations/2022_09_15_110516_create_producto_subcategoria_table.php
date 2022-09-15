<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoSubcategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_subcategoria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('producto');
            $table->foreignId('categoria_id')->constrained('categoria');
            $table->foreignId('sub_categoria_id')->constrained('sub_categoria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_subcategoria');
    }
}
