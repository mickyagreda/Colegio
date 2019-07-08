<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table='inscripciones';
    protected $fillable=['idcurso','idgestion','idalumno','fecha_hora'];
    public $timestamps=false;
    public function Curso(){
        return $this->belongsTo('App\Curso');
    }
    public function Gestion(){
        return $this->belongsTo('App\Gestion');
    }
    public function Alumno()
    {
        return $this->belongsTo('App\Alumno');
    }
}
