<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Alumno;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $alumnos = Alumno::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $alumnos = Alumno::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }

        return[
            'pagination' =>[
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $alumno = new Alumno();
        $alumno->nombre =$request->nombre;
        $alumno->apellidos =$request->apellidos;
        $alumno->telefono =$request->telefono;
        $alumno->ci =$request->ci;
        $alumno->condicion= "1";
        $alumno->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $alumno = Alumno::findOrFail($request->id);
        $alumno->nombre =$request->nombre;
        $alumno->apellidos =$request->apellidos;
        $alumno->telefono =$request->telefono;
        $alumno->ci =$request->ci;
        $alumno->condicion= "1";
        $alumno->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $alumno = Alumno::findOrFail($request->id);
        $alumno->condicion= "0";
        $alumno->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $alumno = Alumno::findOrFail($request->id);
        $alumno->condicion= "1";
        $alumno->save();
    }
}
