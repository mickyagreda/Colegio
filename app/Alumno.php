<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{   protected $table='alumnos';
    protected $fillable = ['nombre','apellidos','telefono','ci','condicion'];

    // public function calificasiones()
    // {
    //     return $this->hasOne('App\Calificasion');
    // }

    // public function inscripciones()
    // {
    //     return $this->hasOne('App\Inscripcion');
    // }


}