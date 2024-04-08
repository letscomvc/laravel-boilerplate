<?php

namespace App\Http\Api\Requests\Auth;

use App\Http\Shared\Requests\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'email' => 'required|email|string',
            'password' => 'required|string',
        ];

        return $rules;
    }
}
