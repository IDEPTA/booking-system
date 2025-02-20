<?php

namespace App\Models;

use App\Services\UsersExchangeService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function users()
    {
        $usersExchangeService =  app(UsersExchangeService::class);
        $bearerToken = request()->bearerToken();

        return $usersExchangeService->users($this->user_id, $bearerToken);
    }
}
