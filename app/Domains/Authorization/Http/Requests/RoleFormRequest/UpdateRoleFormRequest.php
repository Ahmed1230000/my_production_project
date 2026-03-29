<?php

namespace App\Domains\Authorization\Http\Requests\RoleFormRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255']
        ];
    }
}
