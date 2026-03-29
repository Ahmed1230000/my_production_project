<?php

namespace App\Domains\Authorization\UseCases\RolesUseCases;

use App\Domains\Authorization\DTOs\Roles\RoleDTO;
use App\Domains\Authorization\Repositories\Contracts\RoleRepositoryInterface;
use App\Domains\Authorization\Exceptions\RoleNotFoundException;
use App\Domains\Authorization\Exceptions\RoleAlreadyExistsException;

class UpdateRoleUseCase
{
    public function __construct(
        private RoleRepositoryInterface $roleRepository
    ) {}

    public function execute(RoleDTO $roleDTO)
    {
        $existingRole = $this->roleRepository->findById($roleDTO->getId());

        if (!$existingRole) {
            throw new RoleNotFoundException("Role not found.");
        }

        $roleWithSameName = $this->roleRepository->findByName($roleDTO->getName());

        if (
            $roleWithSameName &&
            $roleWithSameName->id()->getId() !== $roleDTO->getId()->getId()
        ) {
            throw new RoleAlreadyExistsException("Role name already exists.");
        }

        $existingRole->rename($roleDTO->getName());
        return $this->roleRepository->save($existingRole);
    }
}
