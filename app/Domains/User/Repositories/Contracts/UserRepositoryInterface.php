<?php

namespace App\Domains\User\Repositories\Contracts;

use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionNameVO;
use App\Domains\Authorization\ValueObjects\RoleVO\RoleNameVO;
use App\Domains\User\Entities\UserEntity;
use App\Models\User;

interface UserRepositoryInterface
{
    public function create(UserEntity $user): UserEntity;
    public function findByEmail(string $email): ?UserEntity;
    public function findById(int $id): ?UserEntity;
    public function update(UserEntity $user): UserEntity;

    public function findWithRolesAndPermissions(int $id): User;
    public function findByEmailWithRolesAndPermissions(string $email): ?User;

    /**
     * @param RoleNameVO[] $roles
     */
    public function assignRole(int $userId, array $roles): void;
    public function removeRoles(int $userId, array $roles): void;

    /**
     * @param PermissionNameVO[] $permissions
     */

    public function assignPermissions(int $userId, array $permissions): void;
    public function removePermissions(int $userId, array $permissions): void;
}
