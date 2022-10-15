<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscuelaDescuentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escuela_descuento', function (Blueprint $table) {
            $table->id();
            $table->double('precio_original', 8, 2);
            $table->double('precio', 8, 2);
            $table->boolean('activo')->default(true);
            $table->foreignId('escuela_id')->constrained('escuela');
            $table->foreignId('producto_variante_id')->constrained('producto_variante');
            $table->foreignId('producto_id')->constrained('producto');
            $table->foreignId('variante_presentacion_id')->constrained('variante_presentacion');
            $table->foreignId('variante_id')->constrained('variante');
            $table->foreignId('presentacion_id')->constrained('presentacion');
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
        Schema::dropIfExists('escuela_descuento');
    }
}
