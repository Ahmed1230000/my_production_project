<?php

namespace App\Domains\User\Repositories\Eloquent;

use App\Domains\Authorization\ValueObjects\RoleVO\RoleNameVO;
use App\Domains\User\Entities\UserEntity;
use App\Domains\User\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    private function mapToEntity(User $model): UserEntity
    {
        return new UserEntity(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            password: $model->password,
            status: $model->status,
            emailVerifiedAt: $model->email_verified_at,
            created_at: $model->created_at,
            updated_at: $model->updated_at,

        );
    }
    public function create(UserEntity $user): UserEntity
    {
        $model = User::create([
            'name'     => $user->getName(),
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
            'status'   => $user->getStatus(),
            'email_verified_at' => $user->getEmailVerifiedAt(),
        ]);
        return $this->mapToEntity($model);
    }
    public function findByEmail(string $email): ?UserEntity
    {
        $model = User::where('email', $email)->first();
        return $model ? $this->mapToEntity($model) : null;
    }

    public function findByEmailWithRolesAndPermissions(string $email): ?User
    {
        $model = User::with(['roles', 'permissions:name'])->where('email', $email)->first();
        return $model;
    }

    public function findById(int $id): ?UserEntity
    {
        $model = User::find($id);
        return $model ? $this->mapToEntity($model) : null;
    }

    public function update(UserEntity $user): UserEntity
    {
        $model = User::find($user->id);
        if (!$model) {
            throw new \Exception("User not found");
        }
        $model->update([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'status' => $user->getStatus(),
            'email_verified_at' => $user->getEmailVerifiedAt(),
        ]);
        return $this->mapToEntity($model);
    }

    public function findWithRolesAndPermissions(int $id): User
    {
        $model =  User::with('roles.permissions')->findOrFail($id);
        return $model;
    }

    public function assignRole(int $userId, array $roles): void
    {
        $user = User::findOrFail($userId);

        $roleNames = array_map(
            fn($roleNameVO) => $roleNameVO->getName(),
            $roles
        );

        $user->assignRole($roleNames);
    }

    public function removeRoles(int $userId, array $roles): void
    {
        $user = User::findOrFail($userId);

        $roleNames = array_map(
            fn($roleNameVO) => $roleNameVO->getName(),
            $roles
        );

        $user->removeRole($roleNames);
    }

    public function assignPermissions(int $userId, array $permissions): void
    {
        $user = User::findOrFail($userId);

        $permissionNames = array_map(
            fn($permissionNameVO) => $permissionNameVO->getName(),
            $permissions
        );

        $user->givePermissionTo($permissionNames);
    }

    public function removePermissions(int $userId, array $permissions): void
    {
        $user = User::findOrFail($userId);

        $permissionNames = array_map(
            fn($permissionNameVO) => $permissionNameVO->getName(),
            $permissions
        );

        $user->revokePermissionTo($permissionNames);
    }
}
