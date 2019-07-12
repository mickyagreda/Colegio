<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table='inscripciones';
    protected $fillable=['id','idcurso','idalumno','fecha_hora'];
    public $timestamps=false;
    public function GestionCurso(){
        return $this->belongsTo('App\CursoGestion');
    }
    
    public function Alumno()
    {
        return $this->belongsTo('App\Alumno');
    }
}
