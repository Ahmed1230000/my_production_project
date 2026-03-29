<?php

namespace App\Domains\Authorization\UseCases\PermissionsToRoleUseCases;

use App\Domains\Authorization\Entities\RoleEntity;
use App\Domains\Authorization\Exceptions\RoleNotFoundException;
use App\Domains\Authorization\Exceptions\PermissionNotFoundException;
use App\Domains\Authorization\Repositories\Contracts\RoleRepositoryInterface;
use App\Domains\Authorization\Repositories\Contracts\PermissionRepositoryInterface;
use App\Domains\Authorization\ValueObjects\RoleVO\RoleIdVO;
use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionIdVO;

class AddPermissionsToRoleUseCase
{
    public function __construct(
        private RoleRepositoryInterface $roleRepository,
        private PermissionRepositoryInterface $permissionRepository
    ) {}

    public function execute(int $roleId, array $permissionIds): RoleEntity
    {
        $role = $this->roleRepository->findById(
            new RoleIdVO($roleId)
        );

        if (!$role) {
            throw new RoleNotFoundException();
        }

        $permissionVOs = array_map(
            fn($id) => new PermissionIdVO($id),
            $permissionIds
        );

        $permissions = $this->permissionRepository
            ->findManyByIds($permissionVOs);

        if (count($permissions) !== count($permissionVOs)) {
            throw new PermissionNotFoundException("One or more permissions not found");
        }

        foreach ($permissionVOs as $permissionVO) {
            $role->assignPermission($permissionVO);
        }

        return $this->roleRepository->save($role);
    }
}
