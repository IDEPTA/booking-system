<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Interfaces\UserInterface;

class UserService implements UserInterface
{
    public function index()
    {
        $users = User::all();

        return $users;
    }

    public function show(int $id)
    {
        $user = User::find($id);
        if (!$user) {
            throw new Exception("Запись не найдена", 404);
        }
        return $user;
    }
}
