<?php

namespace App\Domains\Authorization\UseCases\PermissionsUseCases;

use App\Domains\Authorization\Exceptions\PermissionNotFoundException;
use App\Domains\Authorization\Repositories\Contracts\PermissionRepositoryInterface;
use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionIdVO;
use App\Domains\Authorization\Entities\PermissionEntity;

class GetPermissionByIdUseCase
{
    public function __construct(
        private PermissionRepositoryInterface $permissionRepository
    ) {}

    public function execute(int $id): PermissionEntity
    {
        $permission = $this->permissionRepository->findById(
            new PermissionIdVO($id)
        );

        if (!$permission) {
            throw new PermissionNotFoundException("Permission not found.");
        }

        return $permission;
    }
}
