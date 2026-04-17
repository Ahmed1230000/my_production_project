<?php

namespace App\Domains\Organizations\Entities;

use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationIdVO;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationNameVO;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationSlugVO;

class OrganizationEntity
{
    private function __construct(
        private ?OrganizationIdVO $id,
        private OrganizationNameVO $name,
        private OrganizationSlugVO $slug,
        private ?string $description,
        private ?int $owner_id,
        private ?string $created_at,
        private ?string $updated_at,
        private ?string $deleted_at
    ) {}

    public static function reconstitute(
        OrganizationIdVO $id,
        OrganizationNameVO $name,
        OrganizationSlugVO $slug,
        ?string $description,
        ?int $owner_id,
        ?string $created_at,
        ?string $updated_at,
        ?string $deleted_at
    ): self {
        return new self($id, $name, $slug, $description, $owner_id, $created_at, $updated_at, $deleted_at);
    }

    public static function create(
        OrganizationNameVO $name,
        OrganizationSlugVO $slug,
        ?string $description,
        ?int $owner_id
    ): self {
        return new self(null, $name, $slug, $description, $owner_id, null, null, null);
    }

    public function changeName(OrganizationNameVO $name): void
    {
        $this->name = $name;
    }

    public function changeSlug(OrganizationSlugVO $slug): void
    {
        $this->slug = $slug;
    }

    public function changeDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function transferOwnership(?int $owner_id): void
    {
        $this->owner_id = $owner_id;
    }

    public function getId(): ?OrganizationIdVO
    {
        return $this->id;
    }

    public function getName(): OrganizationNameVO
    {
        return $this->name;
    }

    public function getSlug(): OrganizationSlugVO
    {
        return $this->slug;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getOwnerId(): ?int
    {
        return $this->owner_id;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    public function getDeletedAt(): ?string
    {
        return $this->deleted_at;
    }
}
