<?php

namespace App\Domains\Organizations\Http\Requests\OrganizationRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrganizationFormRequest extends FormRequest
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
            // 'slug'        => ['nullable', 'string', 'alpha_dash', 'min:3'],
            // 'owner_id'    => ['nullable', 'integer', Rule::exists('users', 'id')->whereNull('deleted_at')],
        ];
    }
}
