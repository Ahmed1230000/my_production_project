<?php

namespace App\Domains\Authorization\UseCases\RolesUseCases;

use App\Domains\Authorization\Repositories\Contracts\RoleRepositoryInterface;
use App\Domains\Authorization\Exceptions\RoleNotFoundException;
use App\Domains\Authorization\ValueObjects\RoleVO\RoleIdVO;

class DeleteRoleUseCase
{
    public function __construct(
        private RoleRepositoryInterface $roleRepository
    ) {}

    public function execute(RoleIdVO $id): void
    {
        $role = $this->roleRepository->findById($id);

        if (!$role) {
            throw new RoleNotFoundException("Role not found.");
        }

        $this->roleRepository->delete($id);
    }
}
