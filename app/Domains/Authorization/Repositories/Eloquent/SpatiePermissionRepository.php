<?php

namespace App\Domains\Authorization\Repositories\Eloquent;

use Spatie\Permission\Models\Permission;
use App\Domains\Authorization\Entities\PermissionEntity;
use App\Domains\Authorization\Repositories\Contracts\PermissionRepositoryInterface;
use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionIdVO;
use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionNameVO;

class SpatiePermissionRepository implements PermissionRepositoryInterface
{
    private const GUARD = 'api';

    public function save(PermissionEntity $permission): PermissionEntity
    {
        if ($permission->id() === null) {

            // Create
            $eloquentPermission = Permission::create([
                'name'       => $permission->name()->getName(),
                'guard_name' => self::GUARD,
            ]);
        } else {

            // Update
            $eloquentPermission = Permission::findOrFail(
                $permission->id()->getId()
            );

            $eloquentPermission->update([
                'name' => $permission->name()->getName(),
            ]);
        }

        return PermissionEntity::reconstitute(
            new PermissionIdVO($eloquentPermission->id),
            new PermissionNameVO($eloquentPermission->name)
        );
    }

    public function findById(PermissionIdVO $id): ?PermissionEntity
    {
        $permission = Permission::find($id->getId());

        if (!$permission) {
            return null;
        }

        return PermissionEntity::reconstitute(
            new PermissionIdVO($permission->id),
            new PermissionNameVO($permission->name)
        );
    }

    public function findByName(PermissionNameVO $name): ?PermissionEntity
    {
        $permission = Permission::where('name', $name->getName())
            ->where('guard_name', self::GUARD)
            ->first();

        if (!$permission) {
            return null;
        }

        return PermissionEntity::reconstitute(
            new PermissionIdVO($permission->id),
            new PermissionNameVO($permission->name)
        );
    }

    public function findAll(): array
    {
        return Permission::where('guard_name', self::GUARD)
            ->get()
            ->map(fn($perm) => PermissionEntity::reconstitute(
                new PermissionIdVO($perm->id),
                new PermissionNameVO($perm->name)
            ))
            ->toArray();
    }

    public function delete(PermissionIdVO $id): void
    {
        Permission::findOrFail($id->getId())->delete();
    }

    public function findManyByIds(array $ids): array
    {
        $rawIds = array_map(
            fn($id) => $id->getId(),
            $ids
        );

        return Permission::whereIn('id', $rawIds)
            ->where('guard_name', self::GUARD)
            ->get()
            ->map(fn($perm) => PermissionEntity::reconstitute(
                new PermissionIdVO($perm->id),
                new PermissionNameVO($perm->name)
            ))
            ->toArray();
    }
}
