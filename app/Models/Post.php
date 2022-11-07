<?php

namespace App\Models;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    //fillable es la información que se va a almacenar y que laravel tiene que leer y procesar antes de enviar a la BD.
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id',
    ];

    //Creamos la relación donde un post pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class)->select(['name','username']);
    }

    // Creamos la relación que indica que un post puede tener muchos comentarios
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Creamos un método para saber si un usuario ya le dió like a una publicación.
    // Le pasaremos el usuario cuando llamemos a este método desde la vista show.blade
    public function checkLike(User $user)
    {
        // Como tenemos la relación de likes arriba, se la podemos pasar aqui como información
        // Contains se situa en la tabla y revisa si en la columna que indicamos ya se introdujo el id.
        return $this->likes->contains('user_id',$user->id);
    }
}
