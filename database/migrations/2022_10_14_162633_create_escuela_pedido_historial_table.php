<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscuelaPedidoHistorialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escuela_pedido_historial', function (Blueprint $table) {
            $table->id();
            $table->string('estado_anterior', 15);
            $table->string('estado_actual', 15);
            $table->string('descripcion', 1500);
            $table->string('usuario', 100);
            $table->foreignId('escuela_id')->constrained('escuela');
            $table->foreignId('estado_pedido_id')->constrained('estado_pedido');
            $table->foreignId('escuela_pedido_id')->constrained('escuela_pedido');
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
        Schema::dropIfExists('escuela_pedido_historial');
    }
}
