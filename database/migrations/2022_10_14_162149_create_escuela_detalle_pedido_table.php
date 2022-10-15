<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscuelaDetallePedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escuela_detalle_pedido', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('cantidad');
            $table->double('precio_real', 8, 2);
            $table->double('precio_descuento', 8, 2);
            $table->double('descuento', 8, 2);
            $table->double('sub_total', 8, 2);
            $table->smallInteger('anio');
            $table->boolean('activo')->default(true);
            $table->foreignId('escuela_pedido_id')->constrained('escuela_pedido');
            $table->foreignId('escuela_id')->constrained('escuela');
            $table->foreignId('producto_variante_id')->constrained('producto_variante');
            $table->foreignId('producto_id')->constrained('producto');
            $table->foreignId('variante_presentacion_id')->constrained('variante_presentacion');
            $table->foreignId('variante_id')->constrained('variante');
            $table->foreignId('presentacion_id')->constrained('presentacion');
            $table->foreignId('mes_id')->constrained('mes');
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
        Schema::dropIfExists('escuela_detalle_pedido');
    }
}
