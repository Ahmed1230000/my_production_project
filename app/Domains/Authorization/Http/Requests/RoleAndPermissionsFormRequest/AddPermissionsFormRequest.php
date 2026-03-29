<?php

namespace App\Domains\Authorization\Http\Requests\RoleAndPermissionsFormRequest;

use Illuminate\Foundation\Http\FormRequest;

class AddPermissionsFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'permissions' => ['required', 'array'],
            'permissions.*' => ['integer', 'distinct']
        ];
    }
}
