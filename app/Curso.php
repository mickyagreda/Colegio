<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $fillable=['idParalelo','nombre','dimension','condicion','nombre_paralelo','id'];

    public function CursoGestion()
    {
        return $this->hasMany('App\CursoGestion');
    }
}
