<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAspiranteIdiomasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aspirante_idiomas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('aspirante_id')->unsigned();
            $table->string('idioma',250)->nullable();
            $table->string('nivel',250)->nullable();

            $table->foreign('aspirante_id')->references('id')->on('aspirantes');
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
        Schema::dropIfExists('aspirante_idiomas');
    }
}
