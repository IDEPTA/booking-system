<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\BookingPostInterface;



class BookingPostsController extends Controller
{
    public function __construct(private readonly BookingPostInterface $bookingPostService) {}

    public function index()
    {
        try {
            $bookingItems = $this->bookingPostService->index();

            return response()->json([
                "data" => $bookingItems,
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

    public function show(int $id)
    {
        try {
            $bookingItem = $this->bookingPostService->show($id);
            return response()->json([
                "data" => $bookingItem,
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

    public function create(Request $request)
    {
        try {
            $newItem = $this->bookingPostService->create($request);
            return response()->json([
                "data" => $newItem,
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

    public function update(Request $request, int $id)
    {
        try {
            $updateItem = $this->bookingPostService->update($request, $id);
            return response()->json([
                "data" => $updateItem,
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

    public function delete(int $id)
    {
        try {
            $this->bookingPostService->delete($id);
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