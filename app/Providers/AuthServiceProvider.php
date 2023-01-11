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
     * @var array<class-string, class-string>
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

        // Should return TRUE or FALSE
        Gate::define('super_admin', function(User $user) {
            return $user->role == 7;
        });
        Gate::define('admin', function(User $user) {
            return $user->role == 5;
        });
        Gate::define('student', function(User $user) {
            return $user->role == 1;
        });
    }
}
