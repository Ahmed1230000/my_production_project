<?php

namespace App\Domains\Authorization\UseCases\PermissionsUseCases;

use App\Domains\Authorization\Repositories\Contracts\PermissionRepositoryInterface;
use App\Domains\Authorization\Entities\PermissionEntity;

class ListPermissionsUseCase
{
    public function __construct(
        private PermissionRepositoryInterface $permissionRepository
    ) {}

    /**
     * @return PermissionEntity[]
     */
    public function execute(): array
    {
        return $this->permissionRepository->findAll();
    }
}
