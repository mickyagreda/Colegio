<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table='profesores';
    //protected $primarykey='idProfesor';
    //public $timestamp=false;
    protected $fillable=['nombre','apellido','fechaNacimiento','direccion','DNI','telefono','profesion','imagen','condicion'];
    public $timestamps=false;  
}
