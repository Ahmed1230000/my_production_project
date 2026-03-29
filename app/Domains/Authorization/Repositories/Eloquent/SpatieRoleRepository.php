<?php

namespace App\Domains\Authorization\Repositories\Eloquent;

use App\Domains\Authorization\Entities\RoleEntity;
use App\Domains\Authorization\Repositories\Contracts\RoleRepositoryInterface;
use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionIdVO;
use App\Domains\Authorization\ValueObjects\RoleVO\RoleIdVO;
use App\Domains\Authorization\ValueObjects\RoleVO\RoleNameVO;
use Spatie\Permission\Models\Role;

class SpatieRoleRepository implements RoleRepositoryInterface
{
    private const GUARD = 'api';
    public function save(RoleEntity $role): RoleEntity
    {
        if ($role->id() === null) {

            $eloquentRole = Role::create([
                'name' => $role->name()->getName(),
                'guard_name' => self::GUARD,
            ]);
        } else {

            $eloquentRole = Role::findOrFail($role->id()->getId());
            $eloquentRole->update([
                'name' => $role->name()->getName(),
            ]);
        }

        // Sync permissions
        $permissionIds = array_map(
            fn($perm) => $perm->getId(),
            $role->permissions()
        );

        $eloquentRole->syncPermissions($permissionIds);

        return RoleEntity::reconstitute(
            new RoleIdVO($eloquentRole->id),
            new RoleNameVO($eloquentRole->name),
            $role->permissions()
        );
    }

    public function findById(RoleIdVO $id): ?RoleEntity
    {
        $model = Role::with('permissions')->find($id->getId());
        if (!$model) {
            return null;
        }
        $permissions = $model->permissions->map(function ($permission) {
            return new PermissionIdVO($permission->id);
        })->toArray();
        return RoleEntity::reconstitute(
            new RoleIdVO($model->id),
            new RoleNameVO($model->name),
            $permissions
        );
    }

    public function findByName(RoleNameVO $name): ?RoleEntity
    {
        $model = Role::where('name', $name->getName())->first();
        if (!$model) {
            return null;
        }
        return RoleEntity::reconstitute(
            new RoleIdVO($model->id),
            new RoleNameVO($model->name)
        );
    }

    public function findAll(): array
    {
        return Role::with('permissions')
            ->get()
            ->map(function ($model) {
                return RoleEntity::reconstitute(
                    new RoleIdVO($model->id),
                    new RoleNameVO($model->name)
                );
            })->toArray();
    }

    public function delete(RoleIdVO $id): void
    {
        Role::destroy($id->getId());
    }
}
