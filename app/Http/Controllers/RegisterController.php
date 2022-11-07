<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{    
    public function index() {
        return view('auth.register');
    }

    public function store(Request $request){ //La clase request recoge los valores que se le pasen
        // dd($request); //Esta función es el equivalente al echo de PHP.
        //dd($request->get('username')); //Así accedemos a cada valor por separado.
 
        //Modificar el request para que no nos lance laravel un mensaje de error y poder controlarlo antes.
        $request->request->add(['username' => Str::slug($request->username)]);
 
        //Validaciones. Vienen en la documentación de Laravel
        $this->validate($request,[
            'name' => 'required|min:2|max:30', //Con el caracter | podemos concatenar más validaciones al campo.
            'username' => 'required|unique:users|min:3|max:20', //users es la tabla donde se guarda.
            'email' => 'required|unique:users|email|max:60', //Con la regla email, valida que sea un email lo que se guarda.
            'password' => 'required|confirmed|min:6' //Con la regla confirmed, valida que ambos campos password sean iguales
        ]);

        //Previamente hemos rellenado el fillable del modelo.
        User::create([
            'name'=>$request->name,
            'username'=> $request->username,
            'email'=>$request->email,
            'password'=> Hash::make($request->password)
        ]);
 
        //Autenticar un usuario, lo guardamos en un array.
        //La flecha => sirve para asignar valores a un array.
        // auth()->attempt([
        //     'email'=>$request->email,
        //     'password'=>$request->password,
        // ]);
 
        //Otra forma de autenticar al usuario
        auth()->attempt($request->only('email','password'));
 
        //Redireccionar
        return redirect()->route('posts.index', auth()->user()->username);
    }   
}
