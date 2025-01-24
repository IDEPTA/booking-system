<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        "user_id",
        "booking_post_id",
        "start_date",
        "end_date",
        "available_status",
        "payment_status"
    ];

    public function booking_post()
    {
        return $this->belongsTo(BookingPost::class);
    }
}