<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
//use Illuminate\Support\Facades\DB;
use App\Bimestre;

class BimestreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $bimestres = Bimestre::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $bimestres = Bimestre::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $bimestres->total(),
                'current_page' => $bimestres->currentPage(),
                'per_page'     => $bimestres->perPage(),
                'last_page'    => $bimestres->lastPage(),
                'from'         => $bimestres->firstItem(),
                'to'           => $bimestres->lastItem(),
            ],
            'bimestres' => $bimestres
        ];
    }

    public function selectBimestre(Request $request){
        if (!$request->ajax()) return redirect('/');
        $bimestres = Bimestre::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['bimestres' => $bimestres];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $mytime= Carbon::now('America/Lima');

        $bimestre = new Bimestre();
        $bimestre->nombre = $request->nombre;
        $bimestre->fecha_hora = $mytime->toDateString();
        $bimestre->condicion = '1';
        $bimestre->save();
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
        if (!$request->ajax()) return redirect('/');
        $bimestre = Bimestre::findOrFail($request->id);
        $bimestre->nombre = $request->nombre;
        $bimestre->fecha_hora = $request->fecha_hora;
        $bimestre->condicion = '1';
        $bimestre->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $bimestre = Bimestre::findOrFail($request->id);
        $bimestre->condicion = '0';
        $bimestre->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $bimestre = Bimestre::findOrFail($request->id);
        $bimestre->condicion = '1';
        $bimestre->save();
    }

    
}
