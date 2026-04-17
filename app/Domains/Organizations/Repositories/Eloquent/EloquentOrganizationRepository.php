<?php

namespace App\Domains\Organizations\Repositories\Eloquent;

use App\Domains\Organizations\Entities\OrganizationEntity;
use App\Domains\Organizations\Exceptions\OrganizationDomainException;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationIdVO;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationNameVO;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationSlugVO;
use App\Domains\Organizations\Repositories\Contracts\OrganizationRepositoryInterface;
use App\Models\Organization;

class EloquentOrganizationRepository implements OrganizationRepositoryInterface
{
    public function mapToEntity(Organization $organization): OrganizationEntity
    {
        return OrganizationEntity::reconstitute(
            new OrganizationIdVO($organization->id),
            new OrganizationNameVO($organization->name),
            new OrganizationSlugVO($organization->slug),
            $organization->description,
            $organization->owner_id,
            $organization->created_at,
            $organization->updated_at,
            $organization->deleted_at
        );
    }
    public function save(OrganizationEntity $organizationEntity): OrganizationEntity
    {
        if ($organizationEntity->getId()  === null) {
            $organization = Organization::create([
                'name'        => $organizationEntity->getName()->value(),
                'slug'        => $organizationEntity->getSlug()->value(),
                'description' => $organizationEntity->getDescription(),
                'owner_id'    => $organizationEntity->getOwnerId(),
            ]);
        } else {
            $organization = Organization::find($organizationEntity->getId()->value());
            if (!$organization) {
                throw new OrganizationDomainException('Organization not found for update');
            }
            $organization->update([
                'name'        => $organizationEntity->getName()->value(),
                'slug'        => $organizationEntity->getSlug()->value(),
                'description' => $organizationEntity->getDescription(),
                'owner_id'    => $organizationEntity->getOwnerId(),
            ]);
        }
        return $this->mapToEntity($organization);
    }

    public function findById(OrganizationIdVO $id): ?OrganizationEntity
    {
        $organization = Organization::find($id->value());
        if (!$organization) {
            return null;
        }
        return $this->mapToEntity($organization);
    }

    public function FindBySlug(OrganizationSlugVO $slug): ?OrganizationEntity
    {
        $organization = Organization::where('slug', $slug->value())->first();
        if (!$organization) {
            return null;
        }
        return $this->mapToEntity($organization);
    }

    public function existsBySlug(string $slug): bool
    {
        return Organization::where('slug', $slug)->exists();
    }

    public function delete(OrganizationIdVO $id): void
    {
        $organization = Organization::find($id->value());

        if (!$organization) {
            throw new OrganizationDomainException('Organization not found for ownership transfer');
        }

        $organization->delete();
    }
}
