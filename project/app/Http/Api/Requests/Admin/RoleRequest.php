<?php

namespace App\Http\Api\Requests\Admin;

use App\Domain\Role\Enums\RoleGroupEnum;
use App\Domain\Shared\Rules\ValidEnumValue;
use App\Http\Shared\Requests\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
        return [
            'name' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('roles', 'name')
                    ->ignore(optional($this->route('role'))->id),
            ],
            'group' => [
                'required',
                'string',
                (new ValidEnumValue(RoleGroupEnum::class))->strict(),
            ],
            'permission_ids' => 'array',
            'permission_ids.*' => 'integer|distinct|exists:permissions,id',
        ];
    }
}
