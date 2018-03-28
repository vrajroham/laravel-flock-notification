<?php

namespace Vrajroham\LaravelFlockNotification;

use Illuminate\Support\ServiceProvider;

class FlockServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(FlockChannel::class)
            ->needs(Flock::class)
            ->give(function () {
                return new Flock();
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
