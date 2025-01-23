<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'booking_item_id',
        'price',
        'available_slots'
    ];

    public function booking_object()
    {
        return $this->belongsTo(BookingObject::class);
    }

    public function booking_record()
    {
        return $this->hasMany(BookingRecord::class);
    }
}