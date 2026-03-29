<?php

namespace App\Domains\Authorization\UseCases\PermissionsUseCases;

use App\Domains\Authorization\Exceptions\PermissionNotFoundException;
use App\Domains\Authorization\Repositories\Contracts\PermissionRepositoryInterface;
use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionIdVO;

class DeletePermissionUseCase
{
    public function __construct(
        private PermissionRepositoryInterface $permissionRepository
    ) {}

    public function execute(int $id): void
    {
        $permission = $this->permissionRepository->findById(
            new PermissionIdVO($id)
        );

        if (!$permission) {
            throw new PermissionNotFoundException("Permission not found.");
        }

        $this->permissionRepository->delete(new PermissionIdVO($id));
    }
}
