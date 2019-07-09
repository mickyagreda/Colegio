<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumno;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $alumnos = Alumno::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $alumnos = Alumno::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $alumnos->total(),
                'current_page' => $alumnos->currentPage(),
                'per_page'     => $alumnos->perPage(),
                'last_page'    => $alumnos->lastPage(),
                'from'         => $alumnos->firstItem(),
                'to'           => $alumnos->lastItem(),
            ],
            'alumnos' => $alumnos
        ];
    }

    public function selectAlumno(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $alumnos = Alumno::where('nombre', 'like', '%'. $filtro . '%')
        ->select('id','nombre','apellidos','telefono','ci')
        ->orderBy('nombre', 'asc')->get();

        return ['alumno' => $alumnos];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $alumno = new Alumno();
        $alumno->nombre = $request->nombre;
        $alumno->apellidos = $request->apellidos;
        $alumno->telefono = $request->telefono;
        $alumno->ci = $request->ci;

        $alumno->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $alumno = Alumno::findOrFail($request->id);
        $alumno->nombre = $request->nombre;
        $alumno->apellidos = $request->apellidos;
        $alumno->telefono = $request->telefono;
        $alumno->ci = $request->ci;
        $alumno->save();
    }
    
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $alumno = Alumno::findOrFail($request->id);
        $alumno->condicion = '0';
        $alumno->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $alumno = Alumno::findOrFail($request->id);
        $alumno->condicion = '1';
        $alumno->save();
    }
 
}
