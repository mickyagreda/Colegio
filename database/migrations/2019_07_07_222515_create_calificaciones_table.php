<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('idbimestre')->unsigned();
            $table->foreign('idbimestre')->references('id')->on('bimestres')->onDelete('cascade');
            
            $table->integer('idalumno')->unsigned();
            $table->foreign('idalumno')->references('id')->on('alumnos')->onDelete('cascade');
              
            $table->integer('idmateriahorario')->unsigned();
            $table->foreign('idmateriahorario')->references('id')->on('detalle_horarios')->onDelete('cascade');

            $table->decimal('ser',11,1);
            $table->decimal('saber',11,1);
            $table->decimal('decidir',11,1);
            $table->decimal('nota',11,1);
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calificaciones');
    }
}
