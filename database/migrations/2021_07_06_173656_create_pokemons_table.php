<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePokemonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemons', function (Blueprint $table) {
            $table->id();
            $table->string('sha1_hash')->nullable();
            $table->string("name");
            $table->enum("sex", ["M", "F"]);
            $table->longText("desc")->nullable();
            $table->longText("weaknesses")->nullable();
            $table->longText("strengths")->nullable();
            $table->enum("rareness", ["COMMON", "RARE", "LEGENDARY"]);
            $table->string("picture_link");
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('pokemons');
        Schema::enableForeignKeyConstraints();
    }
}
