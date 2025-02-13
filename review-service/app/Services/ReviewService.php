<?php

namespace App\Services;

use Exception;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Interfaces\ReviewInterface;
use Illuminate\Support\Facades\Validator;

class ReviewService implements ReviewInterface
{
    public function index()
    {
        $reviews = Review::all();

        return $reviews;
    }

    public function show(int $id)
    {
        $review = Review::find($id);
        if (!$review) {
            throw new Exception("Объект не найден", 404);
        }

        return $review;
    }

    public function create(Request $request)
    {
        $validationData = $this->validated($request);
        $review = Review::create($validationData);

        return $review;
    }

    public function update(Request $request, int $id)
    {
        $updatedReview = $this->show($id);
        $validationData = $this->validated($request);
        $updatedReview->update($validationData);

        return $updatedReview;
    }

    public function delete(int $id)
    {
        $delete = $this->show($id);
        $delete->delete();
    }

    public function validated(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grade' => 'required|numeric|between:1,5',
            'comment' => 'string|min:10|max:255',
            'booking_record_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors(), 400);
        }

        return $request->all();
    }
}
