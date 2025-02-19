<?php

namespace App\Providers;


use App\Services\AuthServices;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\AuthServicesInterface;
use App\Interfaces\UserInterface;
use App\Services\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServicesInterface::class, AuthServices::class);
        $this->app->bind(UserInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
