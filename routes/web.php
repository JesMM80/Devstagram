<?php

// Para que se pueda redireccionar a los controladores deseados, tenemos que importarlos primero.

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Este routing es el más simple y es de tipo closure
// Route::get('/', function () { 
//     return view('principal');
// });

// En esta ruta como la clase HomeController tiene un método invoke no hace falta añadirle el método
Route::get('/',HomeController::class)->name('home');

// El orden de las rutas es muy importante ya que se van leyendo en secuencial y puede ser que, debido a que se use una
// variable, se cargue una ruta que no debe, por lo que es mejor dejar las rutas con variables al final.

// /register es la URL. RegisterController es el controlador. index sería el método llamado por el controlador.
Route::get('/register', [RegisterController::class,'index'])->name('register');
Route::post('/register', [RegisterController::class,'store']);
//Con esto de name podemos ponerle nombre a las rutas, indicamos que irá a la ruta del primer parámetro. En vez de cambiar la
//ruta en mil sitios, simplemente cambiamos el nombre aquí.El primer valor indicamos el nombre que aparecerá en la URL. 
//Esto aplica para href o formularios. Luego en las vistas donde tengamos las url debemos usar la función route('register') y usar
// el nombre que le hemos definido aquí con la función name().

Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'store']); //En este caso usamos el método store para guardar info.
Route::post('/logout',[LogoutController::class,'store'])->name('logout');

// Rutas para el perfil
Route::get('/editar-pefil',[PerfilController::class,'index'])->name('perfil.index'); //Muestra la info
Route::post('/editar-perfil',[PerfilController::class,'store'])->name('perfil.store');


Route::get('/posts/create',[PostController::class,'create'])->name('posts.create');
Route::post('posts',[PostController::class,'store'])->name('posts.store');
Route::get('/{user:username}/posts/{post}',[PostController::class,'show'])->name('posts.show');

//Rutas para los comentarios
Route::delete('/posts/{post}',[PostController::class,'destroy'])->name('posts.destroy');
Route::post('/{user:username}/posts/{post}',[ComentarioController::class,'store'])->name('comentarios.store');

Route::post('/imagenes',[ImagenController::class,'store'])->name('imagenes.store');

//Likes de las fotos
Route::post('/posts/{post}/likes',[LikeController::class,'store'])->name('posts.likes.store');
Route::delete('/posts/{post}/likes',[LikeController::class,'destroy'])->name('posts.likes.destroy');

//Las llaves en la ruta lo convierten en una variable. Las demás son estáticas. User es un modelo que tenemos en el proyecto y
//con ":username" indicamos que campo de la BD mostrará en la ruta. Al ponerlo entre llaves aplicamos Route Model Binding
Route::get('/{user:username}',[PostController::class,'index'])->name('posts.index');//Nos lleva al muro del usuario.

//Siguiendo a usuarios
Route::post('/{user:username}/follow',[FollowerController::class,'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow',[FollowerController::class,'destroy'])->name('users.unfollow');