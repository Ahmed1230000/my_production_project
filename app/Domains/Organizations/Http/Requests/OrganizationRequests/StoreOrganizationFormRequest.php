<?php

namespace App\Domains\Organizations\Http\Requests\OrganizationRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'min:3'],
            'description' => ['nullable', 'string'],
        ];
    }
}
