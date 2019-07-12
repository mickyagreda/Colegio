<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesor;

class ProfesorController extends Controller
{
   
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;  
        if ($buscar==''){
            $profesor = Profesor::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $profesor = Profesor::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        return [
            'pagination' => [
                'total'        => $profesor->total(),
                'current_page' => $profesor->currentPage(),
                'per_page'     => $profesor->perPage(),
                'last_page'    => $profesor->lastPage(),
                'from'         => $profesor->firstItem(),
                'to'           => $profesor->lastItem(),
            ],
            'profesor' => $profesor
        ];
    }
   
   
    public function store(Request $request)
    {
        \Log::info($request->all());
      if(!$request->ajax()) return redirect('/'); 
        $profesor = new Profesor();
        $profesor->nombre = $request->nombre;
        $profesor->apellido = $request->apellido;
        $profesor->fechaNacimiento = $request->fechaNacimiento;
        $profesor->direccion=$request->direccion;
        $profesor->DNI=$request->DNI;
        $profesor->telefono=$request->telefono;
        $profesor->profesion=$request->profesion;
        $profesor->condicion='1';
      if($request->imagen==null){//si no tiene imagen entonces se le asigna una imagen por defecto
        $profesor->imagen ='defecto.png';
        }else{
                /*guardando la super imagen */
                $explode=explode(',',$request->imagen);
                $decoded=\base64_decode($explode[1]);
                if(str_contains($explode[0],'jpeg')){
                    $extension='jpg';
                }else{
                    $extension='png';
                }
                $fileName = \str_random().'.'.$extension;
                $path='img/imagenes/profesor'.'/'.$fileName;
                \file_put_contents($path,$decoded);
                /*terminando de guardar la superImagen */
                $profesor->imagen=$fileName;   
        }
        $profesor->save();
    }

    public function update(Request $request)
    {   \Log::info($request->all());
        if(!$request->ajax()) return redirect('/');
        $profesor = Profesor::findOrFail($request->id);
        $profesor->nombre = $request->nombre;
        $profesor->apellido  =$request->apellido;
        $profesor->fechaNacimiento = $request->fechaNacimiento;

        $profesor->direccion=$request->direccion;
        $profesor->DNI=$request->DNI;
        $profesor->telefono=$request->telefono;
        $profesor->profesion=$request->profesion;
      
        if( $request->imagen==null){
                $profesor->imagen=$request->copia;
        }else{
               if($request->copia == 'defecto.png'){
                /*guardando la super imagen */
                $explode=explode(',',$request->imagen);
                $decoded=\base64_decode($explode[1]);
                if(str_contains($explode[0],'jpeg')){
                $extension='jpg';
                }else{ 
                $extension='png';
                }
                $fileName = \str_random().'.'.$extension;
                $path= 'img/imagenes/profesor'.'/'.$fileName;
                \file_put_contents($path,$decoded); /*terminando de guardar la superImagen */ 
                $profesor->imagen=$fileName;   
               }else{
                 /*guardando la super imagen */
                 $explode=explode(',',$request->imagen);
                 $decoded=\base64_decode($explode[1]);
                 if(str_contains($explode[0],'jpeg')){
                 $extension='jpg';
                 }else{
                 $extension='png';
                 }
                 $fileName = \str_random().'.'.$extension;
                 $path= 'img/imagenes/profesor'.'/'.$fileName;
                 \file_put_contents($path,$decoded); /*terminando de guardar la superImagen */ 
                 $rutaAnterior='img/imagenes/profesor'.'/'.$request->copia;
                 \unlink(\public_path($rutaAnterior)); /*terminamos de eliminamos la imagen anterior*/ 
                 $profesor->imagen=$fileName;   
               }
                 
            }  
        $profesor->save();  
    }
    public function desactivar(Request $request)
     {
         if (!$request->ajax()) return redirect('/');
         $profesor = Profesor::findOrFail($request->id);
         $profesor->condicion = '0';
         $profesor->save();
     }
 
     public function activar(Request $request)
     {
         if (!$request->ajax()) return redirect('/');
         $profesor = Profesor::findOrFail($request->id);
         $profesor->condicion = '1';
         $profesor->save();
     }
   
}

