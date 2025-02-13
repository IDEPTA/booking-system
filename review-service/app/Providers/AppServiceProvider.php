<?php

namespace App\Providers;

use App\Services\ReviewService;
use App\Interfaces\ReviewInterface;
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
        $this->app->bind(ReviewInterface::class, ReviewService::class);
    }
}
