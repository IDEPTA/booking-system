<?php

namespace App\Providers;

use App\Services\ReviewService;
use App\Interfaces\ReviewInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\BookingRecordsExchangeService;

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
        $this->app->singleton(BookingRecordsExchangeService::class, function ($app) {
            return new BookingRecordsExchangeService();
        });
    }
}
