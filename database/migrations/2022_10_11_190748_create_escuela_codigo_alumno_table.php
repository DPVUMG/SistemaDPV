<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscuelaCodigoAlumnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escuela_codigo_alumno', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('cantidad_alumno');
            $table->boolean('activo')->default(true);
            $table->foreignId('escuela_codigo_id')->constrained('escuela_codigo');
            $table->foreignId('escuela_id')->constrained('escuela');
            $table->foreignId('nivel_id')->constrained('nivel');
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
        Schema::dropIfExists('escuela_codigo_alumno');
    }
}
