<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursoGestionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso_gestiones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcurso')->unsigned();
            $table->foreign('idcurso')->references('id')->on('cursos')->onDelete('cascade');
            $table->integer('idgestion')->unsigned();
            $table->foreign('idgestion')->references('id')->on('gestiones')->onDelete('cascade');
            $table->integer('capacidad');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curso_gestiones');
    }
}
