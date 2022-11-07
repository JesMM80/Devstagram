<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request,User $user, Post $post)
    {
        //Validar el formulario
        $this->validate($request,[
            'comentario'=> 'required|max:255',
        ]);

        //Almacenamos el comentario y tenemos que rellenar con estos datos el fillable del modelo.
        // El modelo Comentario es el que permite usar el método create para insertar un registro.
        Comentario::create([
            'user_id'=> auth()->user()->id,
            'post_id'=> $post->id,
            'comentario'=> $request->comentario,
        ]);

        //Regresamos a la página anterior (la vista) con ciertos datos dados.
        //Los mensajes del método with se imprimen con el método session en la parte de la vista.
        return back()->with('mensaje', 'Comentario guardado correctamente.');
    }
}
