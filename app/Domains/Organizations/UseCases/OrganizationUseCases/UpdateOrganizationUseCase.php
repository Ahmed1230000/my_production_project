<?php

namespace App\Domains\Organizations\UseCases\OrganizationUseCases;

use App\Domains\Organizations\DTOs\OrganizationDTOs\OrganizationDTO;
use App\Domains\Organizations\Exceptions\OrganizationDomainException;
use App\Domains\Organizations\Repositories\Contracts\OrganizationRepositoryInterface;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationIdVO;

class UpdateOrganizationUseCase
{
    public function __construct(
        private OrganizationRepositoryInterface $organizationRepository
    ) {}

    public function execute(OrganizationDTO $dto): OrganizationDTO
    {
        $id = new OrganizationIdVO($dto->getId()->value());
        $organizationEntity = $this->organizationRepository->findById($id);
        if (!$organizationEntity) {
            throw new OrganizationDomainException('Organization not found for update');
        }

        if ($dto->getName() !== null) {
            $organizationEntity->changeName($dto->getName());
        }
        if ($dto->getDescription() !== null) {
            $organizationEntity->changeDescription($dto->getDescription());
        }
        // if ($dto->getSlug() !== null) {
        //     $organizationEntity->changeSlug($dto->getSlug());
        // }
        // if ($dto->getOwnerId() !== null) {
        //     $organizationEntity->transferOwnership($dto->getOwnerId());
        // }

        $save = $this->organizationRepository->save($organizationEntity);

        return OrganizationDTO::fromEntity($save);
    }
}
