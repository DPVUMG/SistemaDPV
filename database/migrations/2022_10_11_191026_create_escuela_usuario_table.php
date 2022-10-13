<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscuelaUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escuela_usuario', function (Blueprint $table) {
            $table->id();
            $table->string('password');
            $table->string('usuario', 30)->unique();
            $table->boolean('activo')->default(true);
            $table->foreignId('persona_id')->constrained('persona');
            $table->foreignId('escuela_id')->constrained('escuela');
            $table->foreignId('usuario_id')->constrained('usuario');
            $table->rememberToken();
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
        Schema::dropIfExists('escuela_usuario');
    }
}
