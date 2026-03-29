<?php

namespace App\Domains\Authorization\UseCases\RoleAndUserUseCases;

use App\Domains\Auth\Exceptions\UserNotFoundException;
use App\Domains\Authorization\DTOs\Roles\RoleToUserDTO;
use App\Domains\Authorization\Exceptions\RoleNotFoundException;
use App\Domains\Authorization\Repositories\Contracts\RoleRepositoryInterface;
use App\Domains\Authorization\ValueObjects\RoleVO\RoleIdVO;
use App\Domains\User\DTOs\UserResponseDTO;
use App\Domains\User\Entities\UserEntity;
use App\Domains\User\Repositories\Contracts\UserRepositoryInterface;

class AssignRoleToUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private RoleRepositoryInterface $roleRepository
    ) {}

    public function execute(RoleToUserDTO $dto): UserResponseDTO
    {
        $user = $this->userRepository->findById($dto->userId);
        if (!$user) {
            throw new UserNotFoundException('User not found with ID: ' . $dto->userId);
        }

        $roleNames = [];

        foreach ($dto->roleIds as $roleId) {

            $role = $this->roleRepository->findById($roleId);

            if (!$role) {
                throw new RoleNotFoundException('Role not found with ID: ' . $roleId->getId());
            }

            $roleNames[] = $role->Name(); // RoleNameVO
        }

        $this->userRepository->assignRole($dto->userId, $roleNames);

        $model =  $this->userRepository->findWithRolesAndPermissions($dto->userId);

        return new UserResponseDTO(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            created_at: $model->created_at,
            updated_at: $model->updated_at,
            roles: $model->roles->pluck('name')->toArray(),
            permissions: $model->permissions->pluck('name')->toArray()
        );
    }
}
