<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

use App\Models\UserCertificatesEmit;
use App\Observers\UserCertificatesEmitObserver;

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
        Paginator::defaultView('view-name');
 
        Paginator::defaultSimpleView('view-name');

        UserCertificatesEmit::observe(UserCertificatesEmitObserver::class);
    }
}
