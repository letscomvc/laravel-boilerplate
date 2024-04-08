<?php

namespace App\Http\Api\Requests\Admin;

use App\Domain\Role\Enums\RoleGroupEnum;
use App\Domain\Role\Rules\RoleBelongsToUserGroup;
use App\Domain\Shared\Rules\ValidEnumValue;
use App\Http\Shared\Requests\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
                    ->ignore($this->route('user')),
            ],
            'group' => [
                'required',
                'string',
                (new ValidEnumValue(RoleGroupEnum::class))->strict(),
            ],
            'password' => 'required|min:2|max:255|confirmed',
            'roles' => 'required|array',
            'roles.*' => [
                'required',
                'string',
                Rule::exists('roles', 'name'),
                new RoleBelongsToUserGroup($this->input('group')),
            ],
        ];

        if ($this->isMethod('PUT')) {
            $rules['password'] = 'nullable|string|confirmed';
        }

        return $rules;
    }
}
