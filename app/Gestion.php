<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    protected $table='gestiones';
    protected $fillable=['id','año','condicion'];
    public $timestamps=false;  
    public function CursoGestion()
    {
        return $this->hasMany('App\CursoGestion');
    }
}
