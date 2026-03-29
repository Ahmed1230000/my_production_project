<?php

namespace App\Domains\Authorization\UseCases\RolesUseCases;

use App\Domains\Authorization\Repositories\Contracts\RoleRepositoryInterface;
use App\Domains\Authorization\Exceptions\RoleNotFoundException;
use App\Domains\Authorization\ValueObjects\RoleVO\RoleIdVO;

class GetRoleByIdUseCase
{
    public function __construct(
        private RoleRepositoryInterface $roleRepository
    ) {}

    public function execute(RoleIdVO $id)
    {
        $role = $this->roleRepository->findById($id);

        if (!$role) {
            throw new RoleNotFoundException("Role not found.");
        }

        return $role;
    }
}
