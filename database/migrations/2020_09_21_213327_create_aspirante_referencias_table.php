<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAspiranteReferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aspirante_referencias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('aspirante_id')->unsigned();
            $table->string('nombre',250)->nullable();
            $table->string('email',250)->nullable();
            $table->string('telefono',15)->nullable();
            $table->string('empresa',250)->nullable();
            $table->string('cargo',250)->nullable();
            $table->string('nivel_cargo',250)->nullable();

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
        Schema::dropIfExists('aspirante_referencias');
    }
}
