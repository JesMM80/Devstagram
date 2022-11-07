<?php

namespace App\Http\Controllers;

// Importamos la clase str

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
// Importamos la clase Image
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    // Controlamos que la ruta esté protegida y sólo pueda verla el usuario autenticado
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perfil.index');
    }

    // A los métodos store se les pasa normalmente el request
    public function store(Request $request)
    {
        //Modificar el request para que no nos lance laravel un mensaje de error y poder controlarlo antes.
        $request->request->add(['username' => Str::slug($request->username)]);
        
        //Validamos los campos
        $this->validate($request,[
            'username' => ['required','unique:users,username,'.auth()->user()->id,'min:3','max:20','not_in:editar-perfil,index'], //users es la tabla donde se guarda.
        ]);

        if($request->imagen){
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension(); //Esta línea (uuid) genera un id único para cada imagen.

            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000,1000); //Estos son métodos propios de la libreria interventionImage para tratar las imágenes.

            //Movemos la imagen al servidor en la ruta especificada.
            $imagenPath=public_path('perfiles') . '/' . $nombreImagen; 
            $imagenServidor->save($imagenPath);
        }

        //Guardamos los cambios del perfil
        //Buscamos al usuario por su id
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        //Esto lo que hace es comprobar si viene una imagen, si no, comprueba si el usuario tiene imagen en la BDD y si no lo deja a nulo.
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null; 

        // Debemos crear la migración para insertar la imagen de usuario como campo en la tabla users
        // sail artisan make:migration add_imagen_field_to_users_table al darle nombre en inglés, laravel lo detecta debido
        // a este tipo de convenciones
        $usuario->save();
        
        return redirect()->route('posts.index', $usuario->username);//Le pasamos la última copia del usuario
    }
}
