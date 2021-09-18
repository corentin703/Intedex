<?php

namespace App\Observers;

use App\Models\Type;

class TypeObserver
{
    /**
     * Handle the Type "deleted" event.
     *
     * @param  \App\Models\Type  $type
     * @return void
     */
    public function deleting(Type $type)
    {
        $pokemons = $type->pokemons;
        $type->pokemons()->detach();

        foreach ($pokemons as $pokemon) {
            if ($pokemon->types()->count() === 0) {
                $pokemon->delete();
            }
        }
    }
}
