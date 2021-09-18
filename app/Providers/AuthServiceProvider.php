<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();



        Gate::define("is_current_user", function (User $current_user, User $user) {
            return $current_user->id == $user->id;
        });

        Gate::define("is_email_verified", function (User $user) {
            return $user->email_verified_at != null;
        });

        $is_admin = function(User $user) {
            return $user->is_admin && $user->email_verified_at != null;
        };

        Gate::define("is_admin", $is_admin);

        // Pokedex authorizations
        Gate::define("download_qr_code", $is_admin);

        // Pokemon authorizations
        Gate::define("create_pokemon", $is_admin);
        Gate::define("update_pokemon", $is_admin);
        Gate::define("delete_pokemon", $is_admin);

        // Type authorizations
        Gate::define("create_type", $is_admin);
        Gate::define("update_type", $is_admin);
        Gate::define("delete_type", $is_admin);
    }
}
