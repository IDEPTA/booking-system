<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Enums\AvailableEnum;
use Illuminate\Http\Request;
use App\Models\BookingRecord;
use Illuminate\Validation\Rule;
use Junges\Kafka\Facades\Kafka;
use App\Enums\PaymentStatusEnum;
use Junges\Kafka\Message\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\BookingRecordInterface;

class BookingRecordService implements BookingRecordInterface
{
    public function index()
    {
        $bookingRecords = BookingRecord::with(['booking_post.booking_object'])->get();
        if ($bookingRecords) {
            foreach ($bookingRecords as $value) {
                $value['user'] = $value->users()['data'];
            }
        }
        return $bookingRecords;
    }

    public function show(int $id)
    {
        $bookingRecord = BookingRecord::with(['booking_post'])->find($id);
        if (!$bookingRecord) {
            throw new Exception("Запись не найдена", 404);
        }
        $bookingRecord['user'] = $bookingRecord->users()['data'];
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
        $updatedBookingRecord =  BookingRecord::find($id);
        if (!$updatedBookingRecord) {
            throw new Exception("Запись не найдена", 404);
        }

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
        $bookingRecord = BookingRecord::with(['booking_post'])->find($id);
        if (!$bookingRecord) {
            throw new Exception("Запись не найдена", 404);
        }
        if ($bookingRecord->available_status != AvailableEnum::AVAILABLE->name()) {
            $bookingPost = $bookingRecord->booking_post()->first();
            $bookingRecord->update([
                "available_status" => AvailableEnum::AVAILABLE->name(),
                "payment_status" => PaymentStatusEnum::CANCELLED->name()
            ]);

            $bookingPost->cancelReservation($bookingRecord);

            return 0;
        }
        throw new Exception("Ошибка отмены резервации", 400);
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
