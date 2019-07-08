<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use Illuminate\Support\Facades\DB;
//use Carbon\Canbon;

use App\Curso;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $cursos = Curso::join('paralelos','cursos.idParalelo','=','paralelos.id')
            ->select('cursos.id','cursos.idParalelo','cursos.nombre','cursos.dimension','paralelos.seccion as nombre_paralelo','cursos.condicion')
            ->orderBy('paralelos.seccion', 'asc')->paginate(3);
        }
        else{
            if($criterio=='seccion'){
                $cursos = Curso::join('paralelos','cursos.idParalelo','=','paralelos.id')
                ->select('cursos.id','cursos.idParalelo','cursos.nombre','cursos.dimension','paralelos.seccion as nombre_paralelo','cursos.condicion')
                ->where('paralelos.'.$criterio,'like','%'.$buscar.'%')
                ->orderBy('paralelos.seccion', 'asc')->paginate(3);
            }else{
                $cursos = Curso::join('paralelos','cursos.idParalelo','=','paralelos.id')
                ->select('cursos.id','cursos.idParalelo','cursos.nombre','cursos.dimension','paralelos.seccion as nombre_paralelo','cursos.condicion')
                ->where('cursos.'.$criterio,'like','%'.$buscar.'%')
                ->orderBy('paralelos.seccion', 'asc')->paginate(3);
            }
            
        }
        

        return [
            'pagination' => [
                'total'        => $cursos->total(),
                'current_page' => $cursos->currentPage(),
                'per_page'     => $cursos->perPage(),
                'last_page'    => $cursos->lastPage(),
                'from'         => $cursos->firstItem(),
                'to'           => $cursos->lastItem(),
            ],
            'cursos' => $cursos
        ];
    }
    public function listarCursoGestion(Request $request)
    { if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $cursos = Curso::join('paralelos','cursos.idParalelo','=','paralelos.id')
            ->select('cursos.id','cursos.idParalelo','cursos.nombre','cursos.dimension','paralelos.seccion as nombre_paralelo','cursos.condicion')
            ->where('cursos.condicion','=','1')
            ->orderBy('paralelos.seccion', 'asc')->paginate(3);
        }
        else{
            if($criterio=='seccion'){
                $cursos = Curso::join('paralelos','cursos.idParalelo','=','paralelos.id')
                ->select('cursos.id','cursos.idParalelo','cursos.nombre','cursos.dimension','paralelos.seccion as nombre_paralelo','cursos.condicion')
                ->where('paralelos.'.$criterio,'like','%'.$buscar.'%')
                ->where('cursos.condicion','=','1')
                ->orderBy('paralelos.seccion', 'asc')->paginate(3);
            }else{
                $cursos = Curso::join('paralelos','cursos.idParalelo','=','paralelos.id')
                ->select('cursos.id','cursos.idParalelo','cursos.nombre','cursos.dimension','paralelos.seccion as nombre_paralelo','cursos.condicion')
                ->where('cursos.'.$criterio,'like','%'.$buscar.'%')
                ->where('cursos.condicion','=','1')
                ->orderBy('paralelos.seccion','asc')->paginate(3);
            }
            
        }
        
        return [
            'pagination' => [
                'total'        => $cursos->total(),
                'current_page' => $cursos->currentPage(),
                'per_page'     => $cursos->perPage(),
                'last_page'    => $cursos->lastPage(),
                'from'         => $cursos->firstItem(),
                'to'           => $cursos->lastItem(),
            ],
            'cursos' => $cursos
        ];

    }
    public function buscarCursoGestion(request $request){
        if (!$request->ajax()) return redirect('/');
        $filtro=$request->filtro;
        $curso= Curso::join('paralelos','cursos.idParalelo','=','paralelos.id')
        ->select('cursos.id','cursos.nombre','cursos.dimension','paralelos.seccion as nombre_paralelo')
        ->where('cursos.nombre','=',$filtro)//la coma representa un espacio dentro de la consulta
        ->orderBy('nombre','asc')
        ->take(1)->get();
        return ['cursos'=>$curso];
    }
     /**
      * 
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
         if (!$request->ajax()) return redirect('/');
         $curso = new Curso();
         $curso->nombre = $request->nombre;
         $curso->idParalelo=$request->idParalelo;
         $curso->dimension = $request->dimension;
         $curso->condicion = '1';
         $curso->save();
     }
     /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request)
     {
         if (!$request->ajax()) return redirect('/');
         $curso = Curso::findOrFail($request->id);
         $curso->nombre = $request->nombre;
         $curso->dimension = $request->dimension;
         $curso->idParalelo = $request->idParalelo;
         $curso->condicion = '1';
         $curso->save();
     }
 
     public function desactivar(Request $request)
     {
         if (!$request->ajax()) return redirect('/');
         $curso = Curso::findOrFail($request->id);
         $curso->condicion = '0';
         $curso->save();
     }
 
     public function activar(Request $request)
     {
         if (!$request->ajax()) return redirect('/');
         $curso = Curso::findOrFail($request->id);
         $curso->condicion = '1';
         $curso->save();
     }
  

}

