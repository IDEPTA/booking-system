<?php

namespace App\Services;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginValidation;
use App\Http\Requests\RegisterValidation;
use App\Interfaces\AuthServicesInterface;

class AuthServices implements AuthServicesInterface
{
    public function login(LoginValidation $loginData)
    {
        $validationData = $loginData->validated();
        $user = User::where("email", $validationData['login'])->first();

        if ($user && Hash::check($validationData['password'], $user->password)) {
            // if ($user->tfa) {
            //     $this->sendCodeConfirm($user);
            //     return "код отправлен в телеграмм. Срок действия 15 минут";
            // }
            $token = $user->createToken("auth_token")->plainTextToken;

            return $token;
        }

        throw new Exception("Неверный пароль", 401);
    }

    public function register(RegisterValidation $registerData)
    {
        $validationData = $registerData->validated();
        $newUser = User::create($validationData);

        if ($newUser) {
            $token = $newUser->createToken("auth_token")->plainTextToken;
            return $token;
        }

        return new Exception("Регистрация не удалась", 500);
    }
}
