<?php

namespace App\Domains\Organizations\UseCases\OrganizationUseCases;

use App\Domains\Organizations\DTOs\OrganizationDTOs\OrganizationDTO;
use App\Domains\Organizations\Exceptions\OrganizationDomainException;
use App\Domains\Organizations\Repositories\Contracts\OrganizationRepositoryInterface;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationIdVO;

class DeleteOrganizationUseCase
{
    public function __construct(
        private OrganizationRepositoryInterface $organizationRepository
    ) {}

    public function execute(OrganizationIdVO $id): void
    {
        $organizationEntity = $this->organizationRepository->findById($id);
        if (!$organizationEntity) {
            throw new OrganizationDomainException('Organization not found for delete');
        }
        $this->organizationRepository->delete($id);
    }
}
