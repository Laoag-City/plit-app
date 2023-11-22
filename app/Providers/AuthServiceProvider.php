<?php

namespace App\Providers;

use App\Models\Requirement;
use App\Models\User;
use App\Models\Office;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user, string $ability) {
            if($user->admin)
                return true;
        });

        Gate::define('owns-requirement', function(User $user, Requirement $requirement){
            return $user->office_id == $requirement->office_id;
        });

        Gate::define('pld-personnel-action-only', function(User $user){
            $pld = Office::where('name', 'CMO - Permits & Licenses Division')->first();

            return $user->office_id == $pld->office_id;
        });
    }
}
