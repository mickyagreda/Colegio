<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;//para trabajar con transacciones
use App\Inscripcion;
use App\Curso;
use App\Gestion;
use App\CursoGestion;
use Carbon\Carbon;//para trabajar con fecha


class InscripcionController extends Controller
{
    public function index(Request $request)
    {
       //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if($buscar==''){
        $inscripciones = Inscripcion::join('alumnos','inscripciones.idalumno','=','alumnos.id')
        ->join('curso_gestiones','curso_gestiones.id','=','inscripciones.idcurso')
        ->join('cursos','curso_gestiones.idcurso','=','cursos.id')
        ->join('gestiones','curso_gestiones.idgestion','=','gestiones.id')
        
       ->select('inscripciones.id','alumnos.nombre as Nombre Alumno','alumnos.apellidos as Apellidos','curso_gestiones.capacidad as  Capacidad de Alumno','cursos.nombre as  Curso Paralelo','gestiones.año as año Gestion De La Incripcion')
       ->paginate(5);
        }
       else{
        $inscripciones = Inscripcion::join('alumnos','inscripciones.idalumno','=','alumnos.id')
        ->join('curso_gestiones','curso_gestiones.id','=','inscripciones.idcurso')
        ->join('cursos','curso_gestiones.idcurso','=','cursos.id')
        ->join('gestiones','curso_gestiones.idgestion','=','gestiones.id')
        >select('inscripciones.id','alumnos.nombre as Nombre Alumno','alumnos.apellidos as Apellidos','curso_gestiones.capacidad as  Capacidad de Alumno','cursos.nombre as  Curso Paralelo','gestiones.año as año Gestion De La Incripcion')
        ->where('inscripciones.'.$criterio, 'like', '%'. $buscar . '%')
        ->orderBy('inscripciones.id', 'desc')->paginate(5);
         }
        return [
            'pagination' => [
                'total'        => $inscripciones->total(),
                'current_page' => $inscripciones->currentPage(),
                'per_page'     => $inscripciones->perPage(),
                'last_page'    => $inscripciones->lastPage(),
                'from'         => $inscripciones->firstItem(),
                'to'           => $inscripciones->lastItem(),
            ],
            'inscripciones' => $inscripciones
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
    public function obtenerAlumno(Request $request){
        if (!$request->ajax()) return redirect('/');
        $id=$request->id;
        $gestion = Alumno::select('alumno.id','alumno.nombre  as Nombre Alumno')
        ->where('alumno.id','=',$id)
        ->orderBy('alumno.id', 'desc')->take(1)->get();
        return['alumno'=>$gestion];
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

            DB::beginTransaction();
            $mytime=Carbon::now('america/Lima');
            $alumno =new Alumno();
            $alumno->capacidad=$det['id'];
            $alumno->capacidad=$det['nombre'];
            $alumno->capacidad=$det['apellidos'];
            $alumno->condicion='1';
            $alumno->save();

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
