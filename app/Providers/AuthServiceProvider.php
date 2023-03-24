<?php

namespace App\Providers;

use App\Http\Controllers\ApiWhatsapp;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
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
        Gate::define('student', function(User $user) {
            return $user->role == 1;
        });
        Gate::define('edit', function(User $user) {
            return $user->role == 2 || $user->role == 3 || $user->role == 4 || $user->role == 5 || $user->role == 6 || $user->role == 7 || $user->role == 8;
        });
        Gate::define('sales', function (User $user) {
            return $user->role == 2 || $user->role == 6 || $user->role == 7 || $user->role == 8;
        });
        Gate::define('e-commerce', function (User $user) {
            return $user->role == 3 || $user->role == 6 || $user->role == 7 || $user->role == 8;
        });
        Gate::define('secretary', function (User $user) {
            return $user->role == 4 || $user->role == 6 || $user->role == 7 || $user->role == 8;
        });
        Gate::define('finance', function (User $user) {
            return $user->role == 5 || $user->role == 6 || $user->role == 7 || $user->role == 8;
        });
        Gate::define('manager', function (User $user) {
            return $user->role == 6 || $user->role == 7 || $user->role == 8;
        });
        Gate::define('admin', function (User $user) {
            return $user->role == 7 || $user->role == 8;
        });
        Gate::define('api', function (User $user) {
            return $user->role == 8 ;
        });    

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            //dd($token . " / " . $user->username);
            $phone = $user->cellphone;
            $name = $user->name;
            $text = 'Segue o link para redefinição de senha ' . 'https://alunos.profissionalizaead.com.br/reset-password/'.$token.'?username='.$user->username;

            $whatsapp = new ApiWhatsapp;
            $whatsapp->msg_send($phone, $name, $text);
            return 'https://alunos.profissionalizaead.com.br/reset-password/'.$token.'?username='.$user->username;
        });
    }



}
