<?php


namespace App\Http\Repositories\Eloquent;


use App\Http\Repositories\TypeRepositoryInterface;
use App\Models\Pokemon;
use App\Models\PokemonType;
use App\Models\Type;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TypeRepository extends BaseRepository implements TypeRepositoryInterface
{
    public function __construct(Type $model)
    {
        parent::__construct($model);
    }

    public function add_pokemon(Type $type, Pokemon $pokemon): void
    {
        $auth_user_id = Auth::id();
        Log::info("auth user -> $auth_user_id add pokemon -> $pokemon->id to $this->model_class_name -> $type->id");

        PokemonType::create([
            'pokemon_id' => $pokemon->id,
            'type_id' => $type->id,
        ]);
    }

    public function get_types_by_user(User $user): Collection
    {
        $types = DB::table('types')->join('pokemon_types', 'types.id', '=', 'pokemon_types.type_id')
            ->join('users_pokemons', 'pokemon_types.pokemon_id', '=', 'users_pokemons.pokemon_id')
            ->where('users_pokemons.user_id', '=', $user->id)
            ->select('types.*')
            ->distinct()
            ->orderBy('name')
            ->get();

        return Type::hydrate($types->toArray());
    }
}
