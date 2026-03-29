<?php

namespace App\Domains\User\Http\Resources;

use App\Domains\Authorization\Http\Resources\PermissionResource;
use App\Domains\Authorization\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'roles'       => collect($this->roles)->pluck('name') ?? 'No Roles Assigned',
            'permissions' => collect($this->permissions)->pluck('name') ?? 'No Permissions Assigned',
        ];
    }
}
