<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        // Render (and most PaaS hosts) terminate TLS at their proxy, so requests
        // reach the container as plain HTTP. Without this, Laravel generates
        // http:// URLs for assets/routes, which browsers block as mixed content
        // on an https:// page.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
