<?php

namespace App\Domains\Authorization\Http\Requests\PermissionFormRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionFormRequest extends FormRequest
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
