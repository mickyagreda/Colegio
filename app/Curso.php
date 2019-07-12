<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $fillable=['idParalelo','nombre','condicion','dimension','nombre_paralelo','id'];
    public $timestamps=false; 
    public function CursoGestion()
    {
        return $this->hasMany('App\CursoGestion');
    }
}
