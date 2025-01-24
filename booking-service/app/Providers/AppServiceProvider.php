<?php

namespace App\Providers;

use App\Http\Controllers\BookingItemsController;
use App\Interfaces\BookingInterface;
use App\Services\BookingService;
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
        $this->app->bind(BookingInterface::class, BookingService::class);
    }
}