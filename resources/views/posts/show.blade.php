@extends('layouts.app')

@section('titulo')
    {{$post->titulo}}
@endsection

@section('contenido')
    <div class="container mx-auto md:flex">
        <div class="md:w-1/2">
            <img src="{{asset('uploads').'/'. $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
            <div class="p-3 flex items-center gap-4">
                @auth
                    {{-- Para pasar datos desde la vista padre al componente o la vista livewire lo hacemos parecido a un 
                    componente de laravel, añadimos dos puntos después del nombre de la vista y el nombre de la variable 
                    que tenemos. La variable la hemos creado previamente con un bloque de código php --}}
                    {{-- 
                    @php
                        $mensaje = "hola desde variable php";
                    @endphp --}}
                    <livewire:like-post :post="$post" />
                @endauth
                
            </div>
            <div>
                {{-- Los datos del usuario viene de la relación entre post y usuario --}}
                <p class="font-bold">{{$post->user->username}}</p>
                <p class="text-sm text-gray-500">
                    {{-- Con el método diff.. formateamos la fecha --}}
                    {{$post->created_at->diffForHumans()}}
                </p>
                <p class="mt-5">
                    {{$post->descripcion}}
                </p>
            </div>

            {{-- Comprobamos si el usuario está autenticado --}}
            @auth
                {{-- Comprobamos si es id del usuario que creó el post es el mismo que está autenticado, lo mostramos --}}
                @if ($post->user_id === auth()->user()->id)
                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        {{-- Con esta directiva añadimos el método spoofing para añadir otras peticiones ya que el navegador
                        sólo soporta GET y POST --}}
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Eliminar publicación" class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer">
                    </form>
                @endif
            @endauth
        </div>

        <div class="md:w-1/2 p-5">

            <div class="shadow bg-white p-5 mb-5">
                @auth
                    
                <p class="text-xl font-bold text-center mb-4">Agrega un nuevo comentario</p>

                @if(session('mensaje'))
                    <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                        {{session('mensaje')}}
                    </div>
                @endif

                {{-- Le pasamos a la ruta las variables de post y usuario --}}
                <form action="{{route('comentarios.store',['post'=>$post,'user'=>$user])}}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">
                            Añade un comentario
                        </label>
                        <textarea id="comentario" name="comentario" placeholder="Agrega un comentario" 
                            class="border p-1 w-full rounded-lg 
                                @error('comentario')
                                border-red-500
                                @enderror"></textarea>                        
                                <!-- Con esta directiva mostramos el error que se produjo al validar el campo en el controller -->
                                @error('comentario')
                                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center "> {{ $message }} </p>
                        @enderror
                    </div> 
                    <input 
                    type="submit" 
                    value="Comentar" 
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
                </form>
                @endauth

                <div class="bg-white mb-5 shadow max-h-96 overflow-y-scroll mt-10">
                    @if ($post->comentarios->count())
                        @foreach ($post->comentarios as $comentario)
                            <div class="p-5 border-gray-300 border-b">
                                <a href="{{ route('posts.index',$comentario->user) }}" class="font-bold">
                                    {{$comentario->user->name}}
                                    "{{$comentario->user->username}}"
                                </a>
                                <p>{{$comentario->post_id}} {{$comentario->comentario}} </p>
                                <p class="text-sm text-gray-500">{{$comentario->created_at->diffForHumans()}}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="p-10 text-center">No hay comentarios aún</p>                        
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection