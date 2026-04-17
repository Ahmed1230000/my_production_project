<?php

namespace App\Domains\Organizations\Repositories\Contracts;

use App\Domains\Organizations\Entities\OrganizationEntity;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationIdVO;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationNameVO;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationSlugVO;

interface OrganizationRepositoryInterface
{
    public function save(OrganizationEntity $data): OrganizationEntity;

    public function delete(OrganizationIdVO $id): void;

    public function findById(OrganizationIdVO $id): ?OrganizationEntity;

    public function FindBySlug(OrganizationSlugVO $slug): ?OrganizationEntity;


    public function existsBySlug(string $slug): bool;
}
