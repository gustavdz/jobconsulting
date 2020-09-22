<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAspiranteExperienciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aspirante_experiencia', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('aspirante_id')->unsigned();
            $table->string('empresa',250)->nullable();
            $table->date('inicio')->nullable();
            $table->date('fin')->nullable();
            $table->string('sector',250)->nullable();
            $table->string('cargo',250)->nullable();
            $table->text('funciones')->nullable();
            $table->text('personal_cargo')->nullable();

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
        Schema::dropIfExists('aspirante_experiencias');
    }
}
