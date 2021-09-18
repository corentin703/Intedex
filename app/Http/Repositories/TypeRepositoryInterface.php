<?php


namespace App\Http\Repositories;


use App\Models\Pokemon;
use App\Models\Type;
use App\Models\User;
use Illuminate\Support\Collection;

interface TypeRepositoryInterface extends BaseRepositoryInterface
{
    public function add_pokemon(Type $type, Pokemon $pokemon): void;

    public function get_types_by_user(User $user): Collection;
}
