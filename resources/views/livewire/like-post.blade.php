<div>
    <div class="flex gap-2 items-center">

        {{-- Livewire siempre va a devolver el html dentro de un div, por lo que es obligatorio usarlos --}}
        <button
            {{-- Vamos a registar un evento con livewire, suelen estar los que hay en JS. Usamos "" en vez de simples.
            Con este evento, cuando hagamos like en el botón, va a buscar la función llamada "like" en el archivo de 
            componentes de livewire LikePost.php y la va a ejecutar. --}}
            wire:click="like"
        >
            <svg 
                xmlns="http://www.w3.org/2000/svg" 
                {{-- Aquí evaluamos si el usuario le dio like, si ya le dío lo pintamos de rojo y si no de blanco --}}
                fill="{{ $isLiked ? "red" : "white" }}" 
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
            </svg>
        </button>
    
        {{-- Como el modelo de post ya tiene la relación con los likes, podemos usar el método de count para saber cuantos 
            likes tiene y como esta variable ya está cargada en el componente, la muestra aquí livewire --}}
        <p class="font-bold">{{$likes}} 
            <span class="font-normal">likes</span> 
        </p>
    </div>
    
</div>
