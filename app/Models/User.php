<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Esta función toma el nombre de colección.
    public function posts()
    {
        //Relación de 1 a muchos. Le pasamos como parámetro el modelo con el cual se relaciona. Luego en el modelo de post
        //debemos indicarle la relación de un post respecto a un usuario.
        //No le pasamos la clave foránea porque seguimos las convenciones de laravel y ya detecta que es user_id.
        //De no seguirlas, tendríamos que pasarle como otro valor la clave foránea return $this->hasMany(Post::class,'id_claveforanea');
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    //Almacena los seguidores de un usuario
    // El método followers en la tabla de followers pertenece a muchos usuarios. También hay que indicar los campos de 
    // la tabla foránea
    public function followers(){
        return $this->belongsToMany(User::class, 'followers','user_id','follower_id');
    }

    // Comprueba las personas que está siguiendo el usuario logeado
    public function followings(){
        return $this->belongsToMany(User::class, 'followers','follower_id','user_id');
    }

    // Comprueba si un usuario ya está siguiendo a otro. Este método se usa en la vista dashboard
    public function siguiendo(User $user){
        // Accede al método de arriba y revisa si el usuario que visita un muro es seguidor de este.
        return $this->followers->contains($user->id);
    }
}
