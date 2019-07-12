<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{   protected $table='alumnos';
    protected $fillable = ['id','nombre','apellidos','telefono','ci','condicion'];
    public $timestamps=false;  
    // public function calificasiones()
    // {
    //     return $this->hasOne('App\Calificasion');
    // }

    //  public function inscripciones()
    //  {
    //    return $this->hasOne('App\Inscripcion');
    //  }

    //  public function Alumno()
    // {
    //     return $this->hasMany('App\Inscripcion');
    // }


}