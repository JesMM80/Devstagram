<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{    
    Public function __construct() //El método constructor se ejecuta cuando es instanciado.
    {
        //Middleware es un método que proteje las autenticaciones para saber si está logado el user.
        $this->middleware('auth')->except(['show','index']); 
    }

    //Desde la ruta, a través de PostController le mandamos a este método un modelo
    Public function index(User $user)
    {
        //LLamamos al modelo, se situa en esa tabla automáticamente y se hace la consulta. 
        //Con el método get() traemos los resultados y con paginate creamos una paginación.
        $posts = Post::where('user_id',$user->id)->latest()->paginate(10);

        //Una vez tenemos los datos de los posts del usuario, se los pasamos a la vista junto con los datos del usuario.
        return view('dashboard',[ //Le pasamos un array a la vista gracias a Route Model Binding
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'titulo'=> 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required',
        ]);

        // Debemos haber rellenado previamente esta misma información en el modelo. Para que podamos usar la clase
        // Post y el método create para introducir un registro.
        Post::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' =>auth()->user()->id,
        ]);

        //Otra forma de crear registros
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        return redirect()->route('posts.index', auth()->user()->username);
    }

    // Con el método show obtenemos de la bdd un registro únicamente del id deseado
    // Le podemos pasar las variables a la vista ya que están importados los modelos
    public function show (User $user, Post $post)
    {
        return view('posts.show',[
            'post' => $post,
            'user' => $user
        ]);
    }

    //Borramos un registro de la BDD y le pasamos por parámetro el post con su información
    public function destroy(Post $post)
    {
        // Con este método llamamos al método delete de la policy y este comprueba si tiene autorización
        $this->authorize('delete',$post);
        $post->delete();//Se borra si se autorizó

        // Eliminamos la imagen del servidor. 
        //Con el método public_path apuntamos directamente a la carpeta de las imágenes, a la url completa.
        $imagen_path = public_path('uploads/' . $post->imagen);
        //Importamos FILE, que pertenece a facades
        if(File::exists($imagen_path)){
            unlink($imagen_path);
        }

        // Redireccionamos a su muro y le pasamos el usuario autenticado
        return redirect()->route('posts.index',auth()->user()->username);
    }
}
