@extends('layouts.app') {{-- Esto es el equivalente a un include de php. Así cargamos otra vista en esta --}}

@section('titulo')
    Página principal
@endsection

@section('contenido')
    {{-- Los componentes empizan siempre con <x-NombreTemplate... En la plantilla ponemos el código que se va a mostrar en este
    lugar--}}
    <x-listar-post :posts="$posts" />
@endsection     