<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    // Información que laravel va a procesar para almacenar en la BDD. Lo guardamos en array simplemente indicando los campos.
    protected $fillable = [
        'user_id',
        'post_id',
        'comentario',
    ];

    //Creamos la relación que indica que este comentario pertenece a un usuario. Esto lo hacemos para mostrar el usuario que
    //comentó una publicación
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
