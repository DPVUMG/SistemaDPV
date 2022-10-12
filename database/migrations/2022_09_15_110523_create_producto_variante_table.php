<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoVarianteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_variante', function (Blueprint $table) {
            $table->id();
            $table->double('precio', 8, 2);
            $table->foreignId('producto_id')->constrained('producto');
            $table->foreignId('variante_presentacion_id')->constrained('variante_presentacion');
            $table->foreignId('variante_id')->constrained('variante');
            $table->foreignId('presentacion_id')->constrained('presentacion');
            $table->boolean('activo')->default(true);
            $table->foreignId('usuario_id')->constrained('usuario');
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
        Schema::dropIfExists('producto_variante');
    }
}
