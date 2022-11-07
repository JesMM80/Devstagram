<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // Desde la rutas enviamos el post, por lo que tenemos acceso a request. También post.
    public function store(Request $request, Post $post)
    {
        $post->likes()->create([
            'user_id'=> $request->user()->id
        ]);

        return back();//Regresamos a la página anterior
    }

    public function destroy(Request $request, Post $post)
    {
        // El request ya tiene el usuario y el usuario tiene el método likes que es la relación con los likes.
        $request->user()->likes()->where('post_id',$post->id)->delete();
        return back();
    }
}
