<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\BookingPostInterface;
use Illuminate\Http\JsonResponse;

class BookingPostsController extends Controller
{
    public function __construct(private readonly BookingPostInterface $bookingPostService) {}

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
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

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
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

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
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

    /**
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
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

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
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

    public function reservation(int $id, Request $request)
    {
        try {
            $data = $this->validate($request, [
                'start_date' => 'required|date_format:Y-m-d H:i:s',
                'end_date' => 'required|date_format:Y-m-d H:i:s',
            ]);
            $reservation = $this->bookingPostService->reservation($data, $id);
            return response()->json([
                "success" => true,
                "msg" => "Успешно забронировано",
                "post" => $reservation
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