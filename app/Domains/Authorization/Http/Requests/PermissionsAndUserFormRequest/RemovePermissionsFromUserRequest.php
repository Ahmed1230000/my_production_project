<?php

namespace App\Domains\Authorization\Http\Requests\PermissionsAndUserFormRequest;

use Illuminate\Foundation\Http\FormRequest;

class RemovePermissionsFromUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'permissions' => ['required', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ];
    }
}
