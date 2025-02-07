<?php

namespace App\Services;

use App\Enums\AvailableEnum;
use App\Enums\PaymentStatusEnum;
use Exception;
use Illuminate\Http\Request;
use App\Interfaces\BookingRecordInterface;
use App\Models\BookingRecord;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class BookingRecordService implements BookingRecordInterface
{
    public function index()
    {
        $bookingRecords = BookingRecord::with(['booking_post.booking_object'])->get();

        return $bookingRecords;
    }

    public function show(int $id)
    {
        $bookingRecord = BookingRecord::with(['booking_post'])->find($id);
        if (!$bookingRecord) {
            throw new Exception("Запись не найдена", 404);
        }
        return $bookingRecord;
    }

    public function create(Request|array $request)
    {
        if ($request instanceof Request) {
            $request = $this->validated($request);
        }
        $bookingRecord = BookingRecord::create($request);

        return $bookingRecord;
    }

    public function update(Request $request, int $id)
    {
        $updatedBookingRecord = $this->show($id);
        $validationData = $this->validated($request);
        $updatedBookingRecord->update($validationData);

        return $updatedBookingRecord;
    }

    public function delete(int $id)
    {
        $deleteBookingRecord = $this->show($id);
        $deleteBookingRecord->delete();
    }

    public function cancelReservation(int $id)
    {
        $bookengRecord = $this->show($id);
        $bookingPost = $bookengRecord->booking_post()->first();
        $bookingPost->cancelReservation();
        $bookengRecord->delete($id);
    }

    public function validated(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'booking_post_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'available_status' => ['required', 'string', Rule::in(AvailableEnum::values())],
            'payment_status' =>
            ['required', 'string', Rule::in(PaymentStatusEnum::values())],
        ]);
        if ($validator->fails()) {
            throw new Exception($validator->errors(), 400);
        }

        return $request->all();
    }
}