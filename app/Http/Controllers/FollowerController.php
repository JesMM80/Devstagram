<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(User $user)
    {
        // Como es una relación con tablas pivote, es mejor usar el método attach
        // Esto va a leer el usuario que estamos visitando su muro y le va a agregar a la persona que lo está siguiendo y está logeada
        // El método detach elimina
        $user->followers()->attach(auth()->user()->id);
        return back();
    }

    public function destroy(User $user){
        $user->followers()->detach(auth()->user()->id);
        return back();
    }
}
