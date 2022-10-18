<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoComentarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_comentario', function (Blueprint $table) {
            $table->id();
            $table->string('comment', 250);
            $table->foreignId('producto_id')->constrained('producto');
            $table->foreignId('escuela_usuario_id')->constrained('escuela_usuario');
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
        Schema::dropIfExists('producto_comentario');
    }
}
