<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|min:2",
            "surname" => "required|min:3",
            "patronymic" => "required|min:3",
            "phone" => "required|min:11|numeric|unique:users,phone",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:5|required",
        ];
    }
}
