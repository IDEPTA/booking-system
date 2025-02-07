<?php

namespace App\Services;

use App\Enums\AvailableEnum;
use App\Enums\PaymentStatusEnum;
use Exception;
use App\Models\BookingPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\BookingPostInterface;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\BookingRecordInterface;

class BookingPostService implements BookingPostInterface
{
    public function __construct(
        private readonly BookingRecordInterface $bookingRecordService
    ) {}

    public function index()
    {
        $bookingPosts = BookingPost::with(['booking_object'])->get();

        return $bookingPosts;
    }

    public function show(int $id)
    {
        $bookingPost = BookingPost::with(['booking_object'])->find($id);
        if (!$bookingPost) {
            throw new Exception("booking post not found", 404);
        }
        return $bookingPost;
    }

    public function create(Request $request)
    {
        $validationData = $this->validated($request);
        $bookingPost = BookingPost::create($validationData);

        return $bookingPost;
    }

    public function update(Request $request, int $id)
    {
        $updatedBookingPost = $this->show($id);
        $validationData = $this->validated($request);
        $updatedBookingPost->update($validationData);

        return $updatedBookingPost;
    }

    public function delete(int $id)
    {
        $deleteBookingPost = $this->show($id);
        $deleteBookingPost->delete();
    }

    public function reservation(array $data, int $id)
    {
        $post = $this->show($id);
        $post->reservation();
        $data["user_id"] = Auth::user()->id;
        $data["booking_post_id"] = $post->id;
        $data["available_status"] = AvailableEnum::RESERVED->name();
        $data["payment_status"] = PaymentStatusEnum::PENDING->name();
        $this->bookingRecordService->create($data);
        return $post;
    }

    public function validated(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_object_id' => 'required|integer',
            'price' => 'required|numeric',
            'available_slots' => 'required|integer'
        ]);
        if ($validator->fails()) {
            throw new Exception($validator->errors(), 400);
        }

        return $request->all();
    }
}