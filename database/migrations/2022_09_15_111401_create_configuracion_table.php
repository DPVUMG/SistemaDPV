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
            $table->string('slogan', 250)->nullable();
            $table->longText('vision')->nullable();
            $table->longText('mision')->nullable();
            $table->string('logotipo', 100);
            $table->string('ubicacion_x')->nullable();
            $table->string('ubicacion_y')->nullable();
            $table->string('facebook', 250)->nullable();
            $table->string('twitter', 250)->nullable();
            $table->string('instagram', 250)->nullable();
            $table->string('url', 250)->nullable();
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
