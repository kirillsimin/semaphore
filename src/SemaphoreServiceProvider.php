<?php

namespace Kirillsimin\Semaphore\Src;

use Illuminate\Support\ServiceProvider;

class SemaphoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->app['bleh'] = $this->app->publishes(function($app) {
        //     return new VersionedRoute;
        // });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('kirillsimin\semaphore\src\VersionedRoute', function ($app) {
            return new VersionedRoute();
        });
    }
}
