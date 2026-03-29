<?php

namespace App\Domains\Authorization\UseCases\PermissionAndUserUseCases;

use App\Domains\Auth\Exceptions\UserNotFoundException;
use App\Domains\Authorization\DTOs\Permissions\PermissionToUserDTO;
use App\Domains\Authorization\DTOs\Permissions\RemovePermissionsFromUserDTO;
use App\Domains\Authorization\Exceptions\PermissionNotFoundException;
use App\Domains\Authorization\Repositories\Contracts\PermissionRepositoryInterface;
use App\Domains\User\DTOs\UserResponseDTO;
use App\Domains\User\Repositories\Contracts\UserRepositoryInterface;

class RemovePermissionFromUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PermissionRepositoryInterface $permissionRepository
    ) {}
    public function execute(RemovePermissionsFromUserDTO $dto): UserResponseDTO
    {
        $user = $this->userRepository->findById($dto->userId);

        if (!$user) {
            throw new UserNotFoundException('User not found with ID: ' . $dto->userId);
        }
        $PermissionsNames = [];

        foreach ($dto->permissionIds as $permissionId) {
            $permission = $this->permissionRepository->findById($permissionId);

            if (!$permission) {
                throw new PermissionNotFoundException('Permission not found with ID: ' . $permissionId);
            }
            $PermissionsNames[] = $permission->Name(); // PermissionNameVO
        }

        $this->userRepository->removePermissions($dto->userId, $PermissionsNames);

        $model = $this->userRepository->findWithRolesAndPermissions($dto->userId);

        return new UserResponseDTO(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            created_at: $model->created_at,
            updated_at: $model->updated_at,
            roles: $model->roles()->pluck('name')->toArray(),
            permissions: $model->permissions()->pluck('name')->toArray()
        );
    }
}
