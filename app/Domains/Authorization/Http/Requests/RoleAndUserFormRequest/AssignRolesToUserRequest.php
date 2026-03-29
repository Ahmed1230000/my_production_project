<?php

namespace App\Domains\Authorization\Http\Requests\RoleAndUserFormRequest;

use Illuminate\Foundation\Http\FormRequest;

class AssignRolesToUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'roles'   => ['required', 'array'],
            'roles.*' => ['required', 'integer', 'exists:roles,id'],
        ];
    }
}
