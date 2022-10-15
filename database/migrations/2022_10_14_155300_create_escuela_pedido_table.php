<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscuelaPedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escuela_pedido', function (Blueprint $table) {
            $table->id();
            $table->boolean('pagado')->default(false);
            $table->date('fecha_pedido');
            $table->date('fecha_entrega');
            $table->double('sub_total', 8, 2)->default(0);
            $table->double('descuento', 8, 2)->default(0);
            $table->double('total', 8, 2)->default(0);
            $table->smallInteger('anio');
            $table->longText('descripcion');
            $table->foreignId('escuela_usuario_id')->constrained('escuela_usuario');
            $table->foreignId('escuela_id')->constrained('escuela');
            $table->foreignId('estado_pedido_id')->constrained('estado_pedido');
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
        Schema::dropIfExists('escuela_pedido');
    }
}
