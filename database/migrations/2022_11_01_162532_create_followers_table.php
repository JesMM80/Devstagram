<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Una vez añadimos los campos que queremos, ejecutamos la migración para que se cree la tabla
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');//No hace falta indicarle la tabla ya que la saca por el campo.
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');//Relacionado con la tabla de users
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followers');
    }
};
