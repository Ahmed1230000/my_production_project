<?php

namespace App\Domains\Authorization\Repositories\Contracts;

use App\Domains\Authorization\Entities\RoleEntity;
use App\Domains\Authorization\ValueObjects\RoleVO\RoleIdVO;
use App\Domains\Authorization\ValueObjects\RoleVO\RoleNameVO;

interface RoleRepositoryInterface
{
    public function save(RoleEntity $role): RoleEntity;

    public function findById(RoleIdVO $id): ?RoleEntity;

    public function findByName(RoleNameVO $name): ?RoleEntity;

    public function findAll(): array;

    public function delete(RoleIdVO $id): void;
}
