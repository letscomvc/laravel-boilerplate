<?php

namespace App\Http\Api\Requests\Auth;

use App\Http\Shared\Requests\FormRequest;
use Illuminate\Validation\Rule;

class MeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|min:2|max:255',
            'email' => [
                'required',
                'email',
                'string',
                Rule::unique('users', 'email')
                    ->ignore(current_user()->id),
            ],
        ];

        return $rules;
    }
}
