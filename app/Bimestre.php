<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bimestre extends Model
{
    //protected $table = 'bimestres';
    //protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'fecha_hora',
        'condicion'
    ];
    public $timestamps=false;  
    public function bimestres()
    {
        return $this->hasMany('App\Calificasiones');
    }
}
