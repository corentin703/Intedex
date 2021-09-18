<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPokemon extends Model
{
    use HasFactory;

    protected $table = "users_pokemons";

    protected $fillable = [
        'pokemon_id',
        'user_id',
    ];
}
