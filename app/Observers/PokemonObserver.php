<?php

namespace App\Observers;

use App\Http\Repositories\UserRepositoryInterface;
use App\Models\Pokemon;

class PokemonObserver
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function created(Pokemon $pokemon) {
        $pokemon->sha1_hash = sha1($pokemon->id . env('APP_KEY'));
        $pokemon->save();
    }

    /**
     * Handle the Type "deleted" event.
     *
     * @param  \App\Models\Pokemon  $pokemon
     * @return void
     */
    public function deleting(Pokemon $pokemon)
    {
        $pokemon->types()->detach();
        $pokemon->users()->detach();

        foreach ($pokemon->likedBy as $user)
            $this->userRepository->setFavoritePokemon($user, null);
    }
}
