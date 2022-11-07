<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $imagen = $request->file('file');

        $nombreImagen = Str::uuid() . "." . $imagen->extension(); //Esta línea (uuid) genera un id único para cada imagen.

        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000,1000); //Estos son métodos propios de la libreria interventionImage para tratar las imágenes.

        //Movemos la imagen al servidor en la ruta especificada.
        $imagenPath=public_path('uploads') . '/' . $nombreImagen; 
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]); //Convierte el arreglo a json
    }
}
