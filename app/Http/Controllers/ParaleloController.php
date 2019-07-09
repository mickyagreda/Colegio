<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paralelo;

class ParaleloController extends Controller
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
            $paralelos = Paralelo::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $paralelos = Paralelo::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $paralelos->total(),
                'current_page' => $paralelos->currentPage(),
                'per_page'     => $paralelos->perPage(),
                'last_page'    => $paralelos->lastPage(),
                'from'         => $paralelos->firstItem(),
                'to'           => $paralelos->lastItem(),
            ],
            'paralelos' => $paralelos
        ];
    }

    public function selectParalelo(Request $request){
        if (!$request->ajax()) return redirect('/');
        $Paralelos = Paralelo::where('condicion','=','1')
        ->select('id','seccion')->orderBy('seccion', 'asc')->get();
        return ['paralelos' => $Paralelos];
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

        $paralelo = new Paralelo();
        $paralelo->seccion = $request->seccion;
        $paralelo->condicion = '1';
        $paralelo->save();
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
        $paralelo = Paralelo::findOrFail($request->id);
        $paralelo->seccion = $request->seccion;
        $paralelo->condicion = '1';
        $paralelo->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $paralelo = Paralelo::findOrFail($request->id);
        $paralelo->condicion = '0';
        $paralelo->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $paralelo = Paralelo::findOrFail($request->id);
        $paralelo->condicion = '1';
        $paralelo->save();
    }

    
}
