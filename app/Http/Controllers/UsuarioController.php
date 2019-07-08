<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{   
    public function jsonimagen(Request $request):JsonResponse
    {
       // $usuario = $this->getUser();
   /*     $data = $request->files->get('file');
        $fileName = 'prueba.jpg';
        // moves the file to the directory where usuarios are stored
        $data->move('img/imagenes/profesor',$fileName);
        echo $data; exit;
        echo 'no se pudo subir';
        return $this->json($data);
    */
        $usuario = $this->getUser();
        $data = $request->files->get('file');
        $fileName = $usuario.'.'.$data->guessExtension();
        // moves the file to the directory where usuarios are stored
        $data->move('img/imagenes/profesor',$fileName);
        echo $data; exit;
        return $this->json($data);
    }

//$this->getParameter('/public/img/imagenes/profesor')


}

