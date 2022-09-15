<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfiguracionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracion', function (Blueprint $table) {
            $table->id();
            $table->string('nit', 10)->unique();
            $table->string('nombre', 250);
            $table->string('slogan', 250);
            $table->longText('vision');
            $table->longText('mision');
            $table->string('logotipo', 100);
            $table->string('ubicacion_x');
            $table->string('ubicacion_y');
            $table->string('facebook', 250)->nullable();
            $table->string('twitter', 250)->nullable();
            $table->string('instagram', 250)->nullable();
            $table->string('url', 250);
            $table->boolean('pagina')->default(false);
            $table->boolean('sistema')->default(false);
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
        Schema::dropIfExists('configuracion');
    }
}
