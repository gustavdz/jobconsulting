<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAspirantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aspirantes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono',150)->nullable();
            $table->string('celular',150)->nullable();
            $table->string('pais',250)->nullable();
            $table->string('provincia',250)->nullable();
            $table->string('ciudad',250)->nullable();
            $table->string('remuneracion_actual')->nullable();
            $table->string('espectativa_salarial')->nullable();

            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('aspirantes');
    }
}
