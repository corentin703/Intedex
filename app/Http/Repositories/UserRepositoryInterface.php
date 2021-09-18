<?php


namespace App\Http\Repositories;


use App\Models\Pokemon;
use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function addPokemon(User $user, Pokemon $pokemon): void;

    public function setFavoritePokemon(User $user, Pokemon $pokemon): bool;

    public function getAllUsernames(): Collection;
}
