<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginValidation;
use App\Http\Requests\RegisterValidation;
use App\Interfaces\AuthServicesInterface;

class AuthController extends Controller
{
    private $authServices;
    public function __construct(
        AuthServicesInterface $authServices
    ) {
        $this->authServices = $authServices;
    }

    public function login(LoginValidation $loginData)
    {
        try {
            $token = $this->authServices->login($loginData);
            return response()->json([
                "token" => $token,
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

    public function register(RegisterValidation $registerData)
    {
        try {
            $token = $this->authServices->register($registerData);
            return response()->json([
                "token" => $token,
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
