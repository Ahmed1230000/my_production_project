<?php

namespace App\Domains\Organizations\UseCases\OrganizationUseCases;

use App\Domains\Organizations\DTOs\OrganizationDTOs\OrganizationDTO;
use App\Domains\Organizations\Entities\OrganizationEntity;
use App\Domains\Organizations\Repositories\Contracts\OrganizationRepositoryInterface;
use App\Domains\Organizations\Services\SlugService;

class CreateOrganizationUseCase
{
    public function __construct(
        private OrganizationRepositoryInterface $organizationRepository,
        private SlugService $slugService
    ) {}

    public function execute(OrganizationDTO $dto): OrganizationDTO
    {
        $slug = $this->slugService->generateUniqueSlug($dto->getName());

        $organizationEntity = OrganizationEntity::create(
            name: $dto->getName(),
            slug: $slug,
            description: $dto->getDescription(),
            owner_id: $dto->getOwnerId(),
        );

        $save = $this->organizationRepository->save($organizationEntity);

        return OrganizationDTO::fromEntity($save);
    }
}
