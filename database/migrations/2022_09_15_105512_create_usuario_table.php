<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('password');
            $table->string('usuario')->unique();
            $table->string('avatar');
            $table->boolean('admin')->default(false);
            $table->boolean('pagina')->default(false);
            $table->boolean('sistema')->default(false);
            $table->boolean('activo')->default(true);
            $table->foreignId('persona_id')->constrained('persona');
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
        Schema::dropIfExists('usuario');
    }
}
