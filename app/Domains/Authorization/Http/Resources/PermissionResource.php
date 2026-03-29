<?php

namespace App\Domains\Authorization\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id()?->getId(),
            'name' => $this->name()->getName(),
        ];
    }
}
