<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Request;
use App\Models\BookingObject;
use App\Enums\BookingTypeEnum;
use Illuminate\Validation\Rule;
use App\Enums\BookingObjectEnum;
use App\Interfaces\BookingInterface;
use Illuminate\Support\Facades\Validator;

class BookingService implements BookingInterface
{
    public function index()
    {
        $bookingItems = BookingObject::all();

        return $bookingItems;
    }

    public function show(int $id)
    {
        $bookingItem = BookingObject::find($id);
        if (!$bookingItem) {
            throw new Exception("booking item not found", 404);
        }
        return $bookingItem;
    }

    public function create(Request $request)
    {
        $validationData = $this->validated($request);
        $bookingItem = BookingObject::create($validationData);

        return $bookingItem;
    }

    public function update(Request $request, int $id)
    {
        $updatedBookingItem = $this->show($id);
        $validationData = $this->validated($request);
        $updatedBookingItem->update($validationData);

        return $updatedBookingItem;
    }

    public function delete(int $id)
    {
        $updatedBookingItem = $this->show($id);
        $updatedBookingItem->delete();
    }

    public function validated(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|string',
            'address' => 'required|min:3|string',
            'city' => 'required|min:3|string',
            'working_hours_from' => [
                'required',
                'regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/',
            ],
            'working_hours_up_to' => [
                'required',
                'regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/',
            ],
            'booking_type' => ['required', 'string', Rule::in(BookingTypeEnum::values())],
            'booking_object' => ['required', 'string', Rule::in(BookingObjectEnum::values())],
            'user_id' => 'required',
            'available' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            throw new Exception($validator->errors(), 400);
        }

        return $request->all();
    }
}