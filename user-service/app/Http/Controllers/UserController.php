<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;

class UserController
{
    public function __construct(
        private readonly UserInterface $userService
    ) {}

    public function index()
    {
        try {
            $users = $this->userService->index();

            return response()->json([
                "data" => $users,
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
            $user = $this->userService->show($id);
            return response()->json([
                "data" => $user,
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
