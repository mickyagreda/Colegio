<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfesoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profesores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 50)->unique();
            $table->string('apellido', 256);
            $table->string('fechaNacimiento', 255);
            $table->string('direccion', 255);
            $table->string('DNI', 255);
            $table->string('telefono', 255);
            $table->string('profesion', 255);
            $table->string('imagen', 256)->nullable();
            $table->boolean('condicion')->default(1);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profesores');
    }
}
