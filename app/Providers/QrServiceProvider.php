<?php

namespace App\Providers;

use App\QRcode\PokemonQrMaker;
use App\QRcode\PokemonQrMakerInterface;
use Illuminate\Support\ServiceProvider;

class QrServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PokemonQrMakerInterface::class, PokemonQrMaker::class);
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
