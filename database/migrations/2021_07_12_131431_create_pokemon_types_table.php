<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePokemonTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemon_types', function (Blueprint $table) {
            $table->id();
//            $table->bigInteger('pokemon_id');
//            $table->bigInteger('type_id');
            $table->foreignId('pokemon_id')->references('id')->on('pokemons');
            $table->foreignId('type_id')->references('id')->on('types');
            $table->timestamps();

//            $table->foreign('pokemon_id')->references('id')->on('pokemons');
//            $table->foreign('type_id')->references('id')->on('types');
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
        Schema::dropIfExists('pokemon_types');
        Schema::enableForeignKeyConstraints();
    }
}
