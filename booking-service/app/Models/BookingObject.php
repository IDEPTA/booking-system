<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingObject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'address',
        'city',
        'working_hours_from',
        'working_hours_up_to',
        'booking_type',
        'booking_object',
        'user_id',
        'available',
    ];

    public function booking_post()
    {
        return $this->hasMany(BookingPost::class);
    }
}