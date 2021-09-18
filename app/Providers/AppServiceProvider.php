<?php

namespace App\Providers;

use App\Models\Pokemon;
use App\Models\Type;
use App\Observers\PokemonObserver;
use App\Observers\TypeObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(env('ENABLE_HTTPS') == true) {
            URL::forceScheme('https');
        }

        Pokemon::observe(PokemonObserver::class);
        Type::observe(TypeObserver::class);
    }
}
