<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 25)->unique();
            $table->string('nombre', 100);
            $table->longText('descripcion');
            $table->string('foto', 50);
            $table->boolean('nuevo')->default(true);
            $table->boolean('activo')->default(true);
            $table->foreignId('marca_id')->constrained('marca');
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
        Schema::dropIfExists('producto');
    }
}
