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
        Schema::table('users', function (Blueprint $table) {
            // Como en este caso, las migraciones no son sólo para añadir tablas sino también para añadir campos extra
            $table->string('imagen')->nullable();//Puede ir vacío el campo
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //Hacemos que se elimine el campo en caso de hacer un rollback
            $table->dropColumn('imagen');
        });
    }
};
