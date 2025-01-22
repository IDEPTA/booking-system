<?php

namespace App\Providers;


use App\Services\AuthServices;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\AuthServicesInterface;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServicesInterface::class, AuthServices::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
