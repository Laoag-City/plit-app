<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('current_url', url()->current());

        Paginator::defaultView('vendor.pagination.tailwind');

        Paginator::defaultSimpleView('vendor.pagination.simple-tailwind');
    }
}
