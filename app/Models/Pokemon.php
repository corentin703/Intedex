<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = "pokemons";

    protected $fillable = [
        'name',
        'sex',
        'desc',
        'weaknesses',
        'strengths',
        'rareness',
        'picture_link',
    ];

    public const rareness_display_strings = [
        "COMMON" => "Commun",
        "RARE" => "Rare",
        "LEGENDARY" => "Légendaire",
    ];

    public const sex_display_strings = [
        "M" => "Mâle",
        "F" => "Femelle",
    ];

    public function getRarenessDisplayString() : string {
        return self::rareness_display_strings[$this->attributes["rareness"]];
    }

    public function getSexDisplayString() : string {
        return self::sex_display_strings[$this->attributes["sex"]];
    }

    public function likedBy(): HasMany {
        return $this->hasMany(User::class, 'favorite_pokemon_id', 'id');
    }

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'users_pokemons');
    }

    public function types(): BelongsToMany {
        return $this->belongsToMany(Type::class, 'pokemon_types');
    }
}
