<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gestion;
use App\CursoGestion;

class CursoGestionController extends Controller
{  
    public function mostrarCursosDadoGestion(Request $request){//MOSTRAR TODOS LOS CURSOS DADO LA GESTION
        $buscar = $request->buscar;
        if (!$request->ajax()) return redirect('/');
       
        $curso_gestion = CursoGestion::join('cursos','curso_gestiones.idcurso','=','cursos.id')
        ->join('gestiones','gestiones.id','=','curso_gestiones.idgestion')
        ->join('paralelos','cursos.idParalelo','=','paralelos.id')
        ->select('cursos.id','curso_gestiones.id as idCursoGestiones','cursos.nombre','paralelos.seccion','curso_gestiones.capacidad','curso_gestiones.id as idCursoGestiones')
        ->where('gestiones.año','like', '%'. $buscar . '%')
        ->orderBy('paralelos.seccion','desc')
        ->paginate();     
         return [
            'pagination' => [
                'total'        => $curso_gestion->total(),
                'current_page' => $curso_gestion->currentPage(),
                'per_page'     => $curso_gestion->perPage(),
                'last_page'    => $curso_gestion->lastPage(),
                'from'         => $curso_gestion->firstItem(),
                'to'           => $curso_gestion->lastItem(),
            ],
            'curso_gestion' => $curso_gestion
        ];
    }
    public function store(Request $request){
        if (!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
            $mytime=Carbon::now('america/Lima');
            $gestion =new Gestion();
            $gestion->año=$mytime->toDateString();
            $gestion->condicion='1';
            $gestion->save();

            $detalles=$request->data;
            foreach($detalles as $ep=>$det){
            $detalle=new CursoGestion();
            $detalle->idgestion=$gestion->id;
            $detalle->idcurso=$det['idcurso'];
            $detalle->capacidad=$det['capacidad'];
            $detalle->save();
            }  
            DB::commit();
        }catch(Exception $e)
        {
            DB::rollBack();
        }
    }
    public function desactivar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $gestion = Gestion::findOrFail($request->id);
        $gestion->condicion = '0';
        $gestion->save();
    }


    



}
