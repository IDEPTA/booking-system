<?php

namespace App\Http\Controllers;

use App\Interfaces\BookingObjectInterface;
use Illuminate\Http\Request;

class BookingObjectsController extends Controller
{

    public function __construct(private readonly BookingObjectInterface $bookingService) {}

    public function index()
    {
        try {
            $bookingItems = $this->bookingService->index();

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
            $bookingItem = $this->bookingService->show($id);
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
            $newItem = $this->bookingService->create($request);
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
            $updateItem = $this->bookingService->update($request, $id);
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
            $this->bookingService->delete($id);
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