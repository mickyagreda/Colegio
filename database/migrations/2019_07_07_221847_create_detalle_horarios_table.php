<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_horarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hora_entrada' ,60);
            
            $table->integer('idhorario')->unsigned();
            $table->foreign('idhorario')->references('id')->on('horarios')->onDelete('cascade');

            $table->integer('idcursomateria')->unsigned();
            $table->foreign('idcursomateria')->references('id')->on('detalle_materias')->onDelete('cascade');

            $table->integer('idprofesor')->unsigned();
            $table->foreign('idprofesor')->references('id')->on('profesores')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_horarios');
    }
}
