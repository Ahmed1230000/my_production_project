<?php

namespace App\Domains\Authorization\Http\Requests\RoleFormRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255']
        ];
    }
}
