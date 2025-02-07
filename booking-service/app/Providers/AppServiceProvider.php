<?php

namespace App\Providers;

use App\Services\BookingObjectService;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\BookingObjectInterface;
use App\Interfaces\BookingPostInterface;
use App\Interfaces\BookingRecordInterface;
use App\Services\BookingPostService;
use App\Services\BookingRecordService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BookingObjectInterface::class, BookingObjectService::class);
        $this->app->bind(BookingPostInterface::class, BookingPostService::class);
        $this->app->bind(BookingRecordInterface::class, BookingRecordService::class);
    }
}
