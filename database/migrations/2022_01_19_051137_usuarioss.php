<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Usuarios extends Migration

{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('usuarios', function(Blueprint $table){
            $table->id();
            $table->string('nome', 50);
            $table->string('email', 50);
            $table->string('senha',200);
            $table->dateTime('Ultiomo_Login')->nullable();
            $table->tinyInteger('ativo')->default(1);
            $table->Timestamps();
            $table->softDeletes();
            


        });

        }
    

        /**
     * Reverse the migrations.
     *
     * @return void
     */
    
    public function down()
    {
        
        Schema::dropIfExists('usuarios');
}
}