<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CursoGestion extends Model
{
    protected $table='curso_gestiones';
    protected $fillable=['idcurso','idgestion','capacidad','seccion','dimension','nombre'];
    public $timestamps=false;
    public function Curso(){
        return $this->belongsTo('App\Curso');
    }
    public function Gestion(){
        return $this->belongsTo('App\Gestion');
    }
}
