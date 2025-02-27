<?php

namespace App\Models;

use Exception;
use Carbon\Carbon;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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

    public function reservation(BookingRecord $bookingRecord)
    {
        if ($this->checkAvailableSlots() > 0) {
            $this->available_slots -= 1;
            $this->save();
            $message = new Message(
                headers: [],
                body: [
                    'user_email' => Auth::user()->email,
                    'subject'    => 'Подтверждение бронирования',
                    'message'    => "Уважаемый " .
                        Auth::user()->name . " " .
                        Auth::user()->surname . " " .
                        Auth::user()->patronymic .
                        "! \nВаше бронирование на период " .
                        $bookingRecord['start_date'] .
                        "-" .
                        $bookingRecord['end_date'] .
                        " подтверждено!\n" . Carbon::now(),
                ],
                key: 0
            );

            Kafka::publishOn('booking-events')->withMessage($message)->send();
            return 0;
        }

        throw new Exception("Нет доступных слотов для бронирования", 400);
    }

    public function cancelReservation(BookingRecord $bookingRecord)
    {
        $this->available_slots += 1;
        $this->save();
        $message = new Message(
            headers: [],
            body: [
                'user_email' => Auth::user()->email,
                'subject'    => 'Отмена бронировани!',
                'message'    => "Уважаемый " .
                    Auth::user()->name . " " .
                    Auth::user()->surname . " " .
                    Auth::user()->patronymic .
                    "! \nВаше бронирование на период " .
                    $bookingRecord['start_date'] .
                    "-" .
                    $bookingRecord['end_date'] .
                    " отменено!\n" . Carbon::now(),
            ],
            key: 0
        );

        Kafka::publishOn('booking-events')->withMessage($message)->send();
    }
}
