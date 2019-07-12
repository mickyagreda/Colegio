<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleMateria extends Model
{
    protected $table='detalle_materias';
    protected $fillable=['id','turno','idcursogestion','idmateria'];
    public function Materia(){
        return $this->belongsTo('App\Materia');
    }
    public function CursoGestion(){
        return $this->belongsTo('App\CursoGestion');
    }
}
