<?php

namespace App\Providers;

use App\Inertia\ResponseFactory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->extend(\Inertia\ResponseFactory::class, function ($app) {
            return new \App\Inertia\ResponseFactory();
        });
    }
}
