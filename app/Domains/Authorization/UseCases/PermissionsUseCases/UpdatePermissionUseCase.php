<?php

namespace App\Domains\Authorization\UseCases\PermissionsUseCases;

use App\Domains\Authorization\Exceptions\PermissionNotFoundException;
use App\Domains\Authorization\Exceptions\PermissionAlreadyExistsException;
use App\Domains\Authorization\Repositories\Contracts\PermissionRepositoryInterface;
use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionIdVO;
use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionNameVO;

class UpdatePermissionUseCase
{
    public function __construct(
        private PermissionRepositoryInterface $permissionRepository
    ) {}

    public function execute(int $id, string $newName)
    {
        $permission = $this->permissionRepository->findById(
            new PermissionIdVO($id)
        );

        if (!$permission) {
            throw new PermissionNotFoundException("Permission not found.");
        }

        $nameVO = new PermissionNameVO($newName);

        $existing = $this->permissionRepository->findByName($nameVO);

        if ($existing && $existing->id()?->getId() !== $id) {
            throw new PermissionAlreadyExistsException("Permission name already exists.");
        }

        $permission->rename($nameVO);

        return $this->permissionRepository->save($permission);
    }
}
