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
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Kirillsimin\Semaphore\VersionedRoute', function ($app) {
            return new VersionedRoute();
        });
    }
}
