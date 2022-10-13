<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscuelaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escuela', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('nit', 15)->nullable();
            $table->string('establecimiento', 175);
            $table->string('direccion', 500)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->enum('sector', ['Privado', 'Oficial', 'Cooperativa', 'Municipal']);
            $table->enum('area', ['Urbana', 'Rural']);
            $table->enum('jornada', ['Matutina', 'Doble', 'Vespertina', 'Nocturna', 'Intermedia', 'Sin Jornada']);
            $table->string('plan', 50);
            $table->boolean('activo')->default(false);
            $table->foreignId('distrito_id')->constrained('distrito');
            $table->foreignId('departamental_id')->constrained('departamental');
            $table->foreignId('departamento_id')->constrained('departamento');
            $table->foreignId('municipio_id')->constrained('municipio');
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
        Schema::dropIfExists('escuela');
    }
}
