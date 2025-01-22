<?php

namespace App\Interfaces;

use App\Http\Requests\LoginValidation;
use App\Http\Requests\RegisterValidation;


interface AuthServicesInterface
{
    public function login(LoginValidation $loginData);
    // public function sendCodeConfirm(User $user);
    // public function confirmTfaCode(string $code);
    public function register(RegisterValidation $registerData);
    // public function logout(Request $token);
    // public function resetPassword(PasswordResetRequest $resetData);
}
