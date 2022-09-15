<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->string('cui', 13)->unique();
            $table->string('nombre', 75);
            $table->string('apellido', 75);
            $table->string('telefono', 15)->nullable(true);
            $table->string('correo_electronico')->nullable(true);
            $table->string('direccion', 150)->nullable(true);
            $table->foreignId('departamento_id')->constrained('departamento');
            $table->foreignId('municipio_id')->constrained('municipio');
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
        Schema::dropIfExists('persona');
    }
}
