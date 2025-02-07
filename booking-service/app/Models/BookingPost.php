<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingPost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'booking_object_id',
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

    public function checkAvailableSlots()
    {
        Log::info(["available_slots" => $this->available_slots]);
        return $this->available_slots;
    }

    public function reservation()
    {
        if ($this->checkAvailableSlots() > 0) {
            $this->available_slots -= 1;
            $this->save();
            return 0;
        }

        throw new Exception("Нет доступных слотов для бронирования", 400);
    }

    public function cancelReservation()
    {
        $this->available_slots += 1;
        $this->save();
    }
}