<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    // Como pasa en los componentes de laravel, en un componente livewire una vez que creas un atributo, automáticamente 
    // está en la vista, por lo que no hace falta pasarlo a la vista.
    // public $mensaje = "Hola mundo desde livewire";
    public $post;
    public $isLiked;
    public $likes;

    // mount es una función de livewire equivalente a un constructor de php
    public function mount($post){
        // Con esto comprobamos si el usuario ya dió me gusta al post. En el momento en el que monta el componente.
        $this->isLiked = $post->checkLike(auth()->user());
        $this->likes = $post->likes->count();
    }

    public function like(){
        if($this->post->checkLike(auth()->user())){
            $this->post->likes()->where('post_id',$this->post->id)->delete();
            // Con esto reescribimos los valores y livewire lo re-renderiza y le cambia el estado.
            //Primero evalua esto en like-post.blade: fill="{{ $isLiked ? "red" : "white" }}" y aquí ya llenamos los valores y 
            //cambiamos el estado.
            $this->isLiked = false;
            $this->likes--;
        }else{
            $this->post->likes()->create([
                'user_id'=> auth()->user()->id
            ]);
            $this->isLiked = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
