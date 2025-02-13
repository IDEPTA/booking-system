<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Interfaces\ReviewInterface;

class ReviewController extends Controller
{
    public function __construct(
        private readonly ReviewInterface $reviewService
    ) {}


    public function index()
    {
        try {
            $reviews = $this->reviewService->index();
            return response()->json([
                "data" => $reviews,
                "success" => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "msg" => $th->getMessage(),
                "code" => $th->getCode(),
                "success" => false
            ]);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $review = $this->reviewService->show($id);
            return response()->json([
                "data" => $review,
                "success" => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "msg" => $th->getMessage(),
                "code" => $th->getCode(),
                "success" => false
            ]);
        }
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $newReview = $this->reviewService->create($request);
            return response()->json([
                "data" => $newReview,
                "success" => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "msg" => $th->getMessage(),
                "code" => $th->getCode(),
                "success" => false
            ]);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $updatedReview = $this->reviewService->update($request, $id);
            return response()->json([
                "data" => $updatedReview,
                "success" => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "msg" => $th->getMessage(),
                "code" => $th->getCode(),
                "success" => false
            ]);
        }
    }
    public function delete(int $id): JsonResponse
    {
        try {
            $this->reviewService->delete($id);
            return response()->json([
                "msg" => "Успешно удалено",
                "success" => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "msg" => $th->getMessage(),
                "code" => $th->getCode(),
                "success" => false
            ]);
        }
    }
}
