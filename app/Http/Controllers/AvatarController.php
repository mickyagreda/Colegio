<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function myAvatar(Request $request)
    {
        // Verificamos si hay un file con nombre avatar
        if ($request->hasFile('avatar')) {
            // Si es así , almacenamos en la carpeta public/avatars
            // esta estará dentro de public/defaults/
           $url = $request->avatar->store('img/avatars');
            $userAvatarUpdate = User::find(auth()->id());
            /** Áctualización y 
             return JSON*/
        }
        return "Noo Llego una imagen";
    }


}
