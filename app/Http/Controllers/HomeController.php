<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    // Estos métodos se usan para cuando sólo existirá un método en el controlador. Este método se llama automáticamente, como
    // un constructor
    public function __invoke()
    {
        // Obtener ids de los usuarios que seguimos
        $ids = auth()->user()->followings->pluck('id')->toArray();

        // Importamos el modelo de Post y paginamos los post ordenados descendentemente.
        $posts = Post::whereIn('user_id',$ids)->latest()->paginate(20);

        return view('home',[
            'posts' => $posts
        ]);
    }
}
