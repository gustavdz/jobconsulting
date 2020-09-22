<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAspiranteFormacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aspirante_formacion', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('aspirante_id')->unsigned();
            $table->text('institucion_educativa')->nullable();
            $table->text('titulo')->nullable();
            $table->date('inicio')->nullable();
            $table->date('fin')->nullable();

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
        Schema::dropIfExists('aspirante_formacions');
    }
}
