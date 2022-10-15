<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoPedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_pedido', function (Blueprint $table) {
            $table->id();
            $table->string('numero_cheque')->nullable();
            $table->enum('tipo_pago', ['Cheque']);
            $table->smallInteger('anio');
            $table->foreignId('mes_id')->constrained('mes');
            $table->foreignId('escuela_id')->constrained('escuela');
            $table->foreignId('escuela_pedido_id')->constrained('escuela_pedido');
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
        Schema::dropIfExists('pago_pedido');
    }
}
