<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paralelo extends Model
{
    protected $table = 'paralelos';
    //protected $primaryKey = 'id';
    protected $fillable =[
        'id',
        'seccion',
        'condicion'
    ];
    public $timestamps=false;  
   // public $timestamps=false;  
    /*public function paralelos()
    {
        return $this->hasMany('App\Paralelos');
    }*/
}
