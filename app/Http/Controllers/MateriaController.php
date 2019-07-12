<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materia;
class MateriaController extends Controller
{
 
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $materias = Materia::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $materias = Materia::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $materias->total(),
                'current_page' => $materias->currentPage(),
                'per_page'     => $materias->perPage(),
                'last_page'    => $materias->lastPage(),
                'from'         => $materias->firstItem(),
                'to'           => $materias->lastItem(),
            ],
            'materias' => $materias
        ];
    }

    public function selectMateria(Request $request){
        if (!$request->ajax()) return redirect('/');
        $Materias = Materia::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['materias' => $Materias];
    }
     public function listarMateriaGestion(Request $request)
    { if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $materias = Materia::select('materias.id','materias.nombre','materias.condicion')
            ->where('materias.condicion','=','1')
            ->orderBy('paralelos.seccion', 'asc')->paginate(3);
        }
        else{
            $materias = Materia::select('materias.id','materias.nombre','materias.condicion')
            ->where('materias.condicion','=','1')
            ->where('materias.nombre', 'like', '%'. $buscar . '%')
            ->orderBy('materias.nombre', 'asc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total'        => $materias->total(),
                'current_page' => $materias->currentPage(),
                'per_page'     => $materias->perPage(),
                'last_page'    => $materias->lastPage(),
                'from'         => $materias->firstItem(),
                'to'           => $materias->lastItem(),
            ],
            'materias' => $materias
        ];

    }

   
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $materia = new Materia();
        $materia->nombre = $request->nombre;
        $materia->condicion = '1';
        $materia->save();
    }
  
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $materia = Materia::findOrFail($request->id);
        $materia->nombre = $request->nombre;
        $materia->condicion = '1';
        $materia->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $materia = Materia::findOrFail($request->id);
        $materia->condicion = '0';
        $materia->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $materia = Materia::findOrFail($request->id);
        $materia->condicion = '1';
        $materia->save();
    }

}
