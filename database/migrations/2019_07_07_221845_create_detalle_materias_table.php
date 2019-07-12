<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateDetalleMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_materias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('turno',60);
            $table->integer('idcursogestion')->unsigned();
            $table->foreign('idcursogestion')->references('id')->on('curso_gestiones')->onDelete('cascade');
            $table->integer('idmateria')->unsigned();
            $table->foreign('idmateria')->references('id')->on('materias')->onDelete('cascade');        
            
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_materias');
    }
}