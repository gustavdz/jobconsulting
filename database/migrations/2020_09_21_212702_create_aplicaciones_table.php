<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAplicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aplicaciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('oferta_id')->unsigned();
            $table->bigInteger('aspirante_id')->unsigned();
            $table->bigInteger('estado_oferta_id')->unsigned();
            $table->double('salario_aspirado', 10, 4)->nullable();

            $table->foreign('oferta_id')->references('id')->on('ofertas');
            $table->foreign('aspirante_id')->references('id')->on('habilidades');
            $table->foreign('estado_oferta_id')->references('id')->on('estado_ofertas');

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
        Schema::dropIfExists('aplicaciones');
    }
}
