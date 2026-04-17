<?php

namespace App\Domains\Organizations\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Domains\Organizations\DTOs\OrganizationDTOs\OrganizationDTO;
use Illuminate\Http\Request;

class OrganizationResource extends JsonResource
{
    /** @var OrganizationDTO */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->resource->getId()?->value(),
            'name'        => $this->resource->getName()->value(),
            'slug'        => $this->resource->getSlug()->value(),
            'description' => $this->resource->getDescription(),
            'owner_id'    => $this->resource->getOwnerId(),
            'created_at'  => $this->resource->getCreatedAt(),
            'updated_at'  => $this->resource->getUpdatedAt(),
            'deleted_at'  => $this->resource->getDeletedAt(),
        ];
    }
}
