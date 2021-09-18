<?php

namespace App\Providers;

use App\Http\Repositories\Eloquent\TypeRepository;
use App\Http\Repositories\Eloquent\UserRepository;
use App\Http\Repositories\Eloquent\PokemonRepository;
use App\Http\Repositories\PokemonRepositoryInterface;
use App\Http\Repositories\TypeRepositoryInterface;
use App\Http\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PokemonRepositoryInterface::class, PokemonRepository::class);
        $this->app->bind(TypeRepositoryInterface::class, TypeRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
