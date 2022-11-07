<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!auth()->attempt($request->only('email','password'),$request->remember)){ //Si esto devuelve false, por eso se pregunta con negación
            return back()->with('mensaje','Credenciales incorrectas'); //Este mensaje se le pasa a la plantilla para mostrarlo y 
            //back vuelve a la página anterior.
        }

        return redirect()->route('posts.index', auth()->user()->username);

    }

}
