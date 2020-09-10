<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasOfertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias_ofertas', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('categoria_id')->unsigned();
            $table->bigInteger('oferta_id')->unsigned();

            $table->foreign('categoria_id')->references('id')->on('categorias');
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
        Schema::dropIfExists('categorias_ofertas');
    }
}
