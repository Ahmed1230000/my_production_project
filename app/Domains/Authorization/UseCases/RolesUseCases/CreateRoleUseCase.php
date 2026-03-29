<?php

namespace App\Domains\Authorization\UseCases\RolesUseCases;

use App\Domains\Authorization\DTOs\Roles\RoleDTO;
use App\Domains\Authorization\Entities\RoleEntity;
use App\Domains\Authorization\Exceptions\RoleAlreadyExistsException;
use App\Domains\Authorization\Repositories\Contracts\RoleRepositoryInterface;

class CreateRoleUseCase
{
    public function __construct(
        private RoleRepositoryInterface $roleRepository
    ) {}

    public function execute(RoleDTO $roleDTO): RoleEntity
    {
        $existingRole = $this->roleRepository->findByName($roleDTO->getName());

        if ($existingRole) {
            throw new RoleAlreadyExistsException(
                "A role with the name '{$roleDTO->getName()->getName()}' already exists."
            );
        }

        $role = RoleEntity::create($roleDTO->getName());
        return $this->roleRepository->save($role);
    }
}
