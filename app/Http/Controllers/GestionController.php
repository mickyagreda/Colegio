<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;//para trabajar con transacciones
use Carbon\Carbon;//para trabajar con fecha
use App\Gestion;
use App\CursoGestion;

class GestionController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;  
        if ($buscar==''){
            $gestion = Gestion::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $gestion = Gestion::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        return [
            'pagination' => [
                'total'        => $gestion->total(),
                'current_page' => $gestion->currentPage(),
                'per_page'     => $gestion->perPage(),
                'last_page'    => $gestion->lastPage(),
                'from'         => $gestion->firstItem(),
                'to'           => $gestion->lastItem(),
            ],
            'gestiones' => $gestion
        ];
    }
    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');
         $id=$request->id;
         $gestion = Gestion::select('gestiones.id','gestiones.año as fecha_gestion')
         ->where('gestiones.id','=',$id)
         ->orderBy('gestiones.id', 'desc')->take(1)->get();
         return['gestiones'=>$gestion];

    }
    public function obtenerDetalle(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id=$request->id;
        $detalle = CursoGestion::join('cursos','curso_gestiones.idcurso','=','cursos.id')
        ->select('curso_gestiones.capacidad','cursos.nombre','cursos.dimension')
        ->where('curso_gestiones.idgestion','=',$id)
        ->orderBy('curso_gestiones.id','desc')->get();
         return['detalles'=>$detalle];
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
