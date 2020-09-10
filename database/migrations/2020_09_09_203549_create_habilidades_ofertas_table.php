<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabilidadesOfertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habilidades_ofertas', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('habilidad_id')->unsigned();
            $table->bigInteger('oferta_id')->unsigned();

            $table->foreign('habilidad_id')->references('id')->on('habilidades');
            $table->foreign('oferta_id')->references('id')->on('ofertas');

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
        Schema::dropIfExists('habilidades_ofertas');
    }
}
