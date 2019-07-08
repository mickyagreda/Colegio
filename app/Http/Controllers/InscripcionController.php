<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inscripcione;

class InscripcionController extends Controller
{
    public function index(Request $request)
    {
       //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
                $inscripciones = Inscripcione::join('alumnos','inscripciones.idalumno','=','alumnos.id')
                ->join('curso_gestiones','inscripciones.idcursogestion','=','curso_gestiones.id')
                ->join('cursos','curso_gestiones.idcurso','=','cursos.id')
                ->join('gestiones','curso_gestiones.idgestion','=','gestiones.id')
                ->select('inscripciones.id','inscripciones.idalumno','cursos.nombre','gestiones.año','alumnos.nombre as alumno','inscripciones.fecha_hora')
                ->orderBy ('inscripciones.id','desc')->paginate(3);
        }
        else{
            $inscripciones = Inscripcione::join('alumnos','inscripciones.idalumno','=','alumnos.id')
            ->join('curso_gestiones','inscripciones.idcurso','=','curso_gestiones.id')
            ->join('cursos','=','curso_gestiones.idcurso','cursos.id')
            ->join('gestiones','curso_gestiones.idgestion','=','gestiones.id')
            ->select('inscripciones.id','inscripciones.idalumno','cursos.nombre','gestiones.año','alumnos.nombre as alumno','inscripciones.fecha_hora')
            ->where('alumnos.nombre','like','%'.$buscar . '%')
            ->orderBy('inscripciones.id','desc')->paginate(3);
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
            '$inscripciones' => $inscripciones
        ];
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $inscripcion = new Inscripcion();
        $inscripcion->idalumno = $request->idalumno;
        $inscripcion->idcurso = $request->idcurso;
        $inscripcion->idgestion = $request->idgestion;
        $inscripcion->condicion = '1';
        $inscripcion->save();
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $inscripcion = Inscripcione::findOrFail($request->id);
        $inscripcion->idalumno = $request->idalumno;
        $inscripcion->idcurso = $request->idcurso;
        $inscripcion->idgestion = $request->idgestion;

        $inscripcion->condicion = '1';
        $inscripcion->save();
    }

  

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $inscripcion = Inscripcione::findOrFail($request->id);
        $inscripcion->condicion = '1';
        $inscripcion->save();
    }

}
