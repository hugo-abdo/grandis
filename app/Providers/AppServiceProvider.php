<?php

namespace App\Providers;

use App\Inertia\ResponseFactory;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
        User::class => UserPolicy::class,
    ];
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
