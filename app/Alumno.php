<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
     protected $table = 'alumnos';
    //protected $primarykey ="id";
    protected $fillable =['nombre','apellidos','telefono','ci','condicion'];
    public $timestamps=false;  
}
