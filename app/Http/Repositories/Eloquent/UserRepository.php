<?php


namespace App\Http\Repositories\Eloquent;


use App\Http\Repositories\UserRepositoryInterface;
use App\Models\Pokemon;
use App\Models\User;
use App\Models\UserPokemon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function addPokemon(User $user, Pokemon $pokemon): void
    {
        $auth_user_id = Auth::id();

        Log::info("auth user -> $auth_user_id made catch $this->model_class_name -> $pokemon->id to user -> $user->id");

        UserPokemon::create([
            'pokemon_id' => $pokemon->id,
            'user_id' => $user->id,
        ]);
    }

    public function update(Model $model, array $attributes): bool
    {
        $log_attributes = json_encode($attributes);

        if (isset($attributes['name'])) {
            $model->name = $attributes['name'];
        }

        if (isset($attributes['email']) && $model->email !== $attributes['email']) {
            $model->email = $attributes['email'];
        }

        if (isset($attributes['password'])) {
            $model->password = Hash::make($attributes['password']);
        }

        $auth_user_id = Auth::id();

        Log::info("auth user -> $auth_user_id updated a $this->model_class_name -> $model->id, args : $log_attributes");

        return $model->save();
    }

    public function setFavoritePokemon(User $user, $pokemon): bool
    {
        $auth_user_id = Auth::id();

        if ($pokemon != null && $pokemon->exists)
        {
            $user->favorite_pokemon_id = $pokemon->id;
            Log::info("auth user -> $auth_user_id set pokemon -> $pokemon->id to favorite for user -> {$user->id}");
        }
        else
        {
            Log::info("auth user -> $auth_user_id unset pokemon -> $user->favorite_pokemon_id from favorite for user -> {$user->id}");
            $user->favorite_pokemon_id = null;
        }

        return $user->save();
    }

    public function getAllUsernames(): Collection
    {
        return DB::table('users')->select('name')->orderBy('name')->get();
    }
}
