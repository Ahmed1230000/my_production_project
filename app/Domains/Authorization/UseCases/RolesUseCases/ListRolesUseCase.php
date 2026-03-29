<?php

namespace App\Domains\Authorization\UseCases\RolesUseCases;

use App\Domains\Authorization\Repositories\Contracts\RoleRepositoryInterface;

class ListRolesUseCase
{
    public function __construct(
        private RoleRepositoryInterface $roleRepository
    ) {}

    public function execute(): array
    {
        return $this->roleRepository->findAll();
    }
}
