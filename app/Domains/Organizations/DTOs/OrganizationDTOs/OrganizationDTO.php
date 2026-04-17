<?php

namespace App\Domains\Organizations\DTOs\OrganizationDTOs;

use App\Domains\Organizations\Entities\OrganizationEntity;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationIdVO;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationNameVO;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationSlugVO;

class OrganizationDTO
{
    public function __construct(
        private ?OrganizationIdVO $id,
        private OrganizationNameVO $name,
        private ?OrganizationSlugVO $slug = null,
        private ?string $description,
        private ?int $owner_id,
        private ?string $created_at = null,
        private ?string $updated_at = null,
        private ?string $deleted_at = null,

    ) {}

    public function getId(): ?OrganizationIdVO
    {
        return $this->id;
    }

    public function getName(): OrganizationNameVO
    {
        return $this->name;
    }

    public function getSlug(): ?OrganizationSlugVO
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

    public static function fromEntity(OrganizationEntity $entity): self
    {
        return new self(
            $entity->getId(),
            $entity->getName(),
            $entity->getSlug(),
            $entity->getDescription(),
            $entity->getOwnerId(),
            $entity->getCreatedAt(),
            $entity->getUpdatedAt(),
            $entity->getDeletedAt()
        );
    }
}
