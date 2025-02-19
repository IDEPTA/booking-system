<?php

namespace App\Models;

use App\Services\BookingRecordsExchangeService;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'grade',
        'comment',
        'booking_record_id'
    ];

    public function booking_records()
    {
        $bookingRecordsExchangeService = app(BookingRecordsExchangeService::class);
        $bearerToken = request()->bearerToken();

        return $bookingRecordsExchangeService->booking_records($this->booking_record_id, $bearerToken);
    }
}
