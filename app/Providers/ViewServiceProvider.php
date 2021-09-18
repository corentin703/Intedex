<?php

namespace App\Providers;

use App\Services\Views\FontColorService;
use App\Services\Views\FontColorServiceInterface;
use App\Services\Views\UserAutocompletionServiceService;
use App\Services\Views\UserAutocompletionServiceInterface;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserAutocompletionServiceInterface::class, UserAutocompletionServiceService::class);
        $this->app->bind(FontColorServiceInterface::class, FontColorService::class);
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
