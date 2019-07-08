<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscripcionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcurso')->unsigned();
            $table->foreign('idcurso')->references('id')->on('curso_gestiones')->onDelete('cascade');

            $table->integer('idalumno')->unsigned();
            $table->foreign('idalumno')->references('id')->on('alumnos')->onDelete('cascade');
            $table->dateTime('fecha_hora');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inscripciones');
    }
}
