<div>
    @if ($posts->count())
        {{-- Con estas clases le indicamos al navegador como se vería en los diferentes dispositivos --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 ">
            
            {{-- De esta forma accedemos a la variable posts que nos llega desde el controlador y la recorremos para mostrar los datos. --}}
            @foreach ($posts as $post)
                <div>
                    <a href="{{route('posts.show',['post'=>$post,'user'=>$post->user])}}">
                        <img src="{{asset('uploads').'/'.$post->imagen}}" alt="Imagen del post {{$post->titulo}}" class="cursor-pointer">
                    </a>
                </div>
            @endforeach
        </div>

    {{-- Con el método links hacemos una paginación de los resultados. --}}
        <div class="my-10">{{$posts->links('pagination::tailwind')}}</div>   
    @else

        <p class="text-center">No hay posts</p>
    @endif
</div>