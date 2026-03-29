<?php

namespace App\Domains\Authorization\UseCases\PermissionsUseCases;

use App\Domains\Authorization\Entities\PermissionEntity;
use App\Domains\Authorization\Exceptions\PermissionAlreadyExistsException;
use App\Domains\Authorization\Repositories\Contracts\PermissionRepositoryInterface;
use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionNameVO;

class CreatePermissionUseCase
{
    public function __construct(
        private PermissionRepositoryInterface $permissionRepository
    ) {}

    public function execute(string $name): PermissionEntity
    {
        $nameVO = new PermissionNameVO($name);

        $existing = $this->permissionRepository->findByName($nameVO);

        if ($existing) {
            throw new PermissionAlreadyExistsException(
                "Permission '{$name}' already exists."
            );
        }

        $permission = PermissionEntity::create($nameVO);

        return $this->permissionRepository->save($permission);
    }
}
