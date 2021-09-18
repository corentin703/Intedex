<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPokemonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_pokemons', function (Blueprint $table) {
            $table->id();
//            $table->bigInteger("user_id");
//            $table->bigInteger("pokemon_id");
            $table->foreignId("user_id")->references('id')->on('users');
            $table->foreignId("pokemon_id")->references('id')->on('pokemons');
            $table->timestamps();

//            $table->foreign('user_id')->references('id')->on('user');
//            $table->foreign('pokemon_id')->references('id')->on('pokemons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users_pokemons');
        Schema::enableForeignKeyConstraints();
    }
}
