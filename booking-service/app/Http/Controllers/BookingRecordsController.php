<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Interfaces\BookingRecordInterface;

class BookingRecordsController extends Controller
{
    public function __construct(private readonly BookingRecordInterface $bookingRecordService) {}

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $bookingItems = $this->bookingRecordService->index();

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

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $bookingItem = $this->bookingRecordService->show($id);
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

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $newItem = $this->bookingRecordService->create($request);
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

    /**
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $updateItem = $this->bookingRecordService->update($request, $id);
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

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            $this->bookingRecordService->delete($id);
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

    public function cancelReservation(int $id)
    {
        try {
            $this->bookingRecordService->cancelReservation($id);
            return response()->json([
                "msg" => "Запись отменена",
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