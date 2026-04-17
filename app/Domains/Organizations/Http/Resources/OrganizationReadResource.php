<?php


namespace App\Domains\Organizations\Http\Resources;

use App\Domains\User\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationReadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description,
            'owner'       => UserResource::make($this->whenLoaded('owner')),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'deleted_at'  => $this->deleted_at,
        ];
    }
}
