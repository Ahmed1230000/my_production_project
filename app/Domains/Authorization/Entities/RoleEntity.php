<?php

namespace App\Domains\Authorization\Entities;

use App\Domains\Authorization\ValueObjects\RoleVO\RoleIdVO;
use App\Domains\Authorization\ValueObjects\RoleVO\RoleNameVO;
use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionIdVO;

class RoleEntity
{
    private ?RoleIdVO $id;
    private RoleNameVO $name;

    /** @var PermissionIdVO[] */
    private array $permissions = [];

    private function __construct(
        ?RoleIdVO $id,
        RoleNameVO $name,
        array $permissions = []
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->permissions = $permissions;
    }

    /**
     * Create new Role
     */
    public static function create(RoleNameVO $name): self
    {
        return new self(null, $name);
    }

    /**
     * Reconstitute from persistence
     */
    public static function reconstitute(
        RoleIdVO $id,
        RoleNameVO $name,
        array $permissions = []
    ): self {
        return new self($id, $name, $permissions);
    }

    public function id(): ?RoleIdVO
    {
        return $this->id;
    }

    public function name(): RoleNameVO
    {
        return $this->name;
    }

    public function rename(RoleNameVO $newName): void
    {
        $this->name = $newName;
    }

    public function permissions(): array
    {
        return $this->permissions;
    }

    public function assignPermission(PermissionIdVO $permission): void
    {
        foreach ($this->permissions as $perm) {
            if ($perm->getId() === $permission->getId()) {
                return;
            }
        }

        $this->permissions[] = $permission;
    }

    public function revokePermission(PermissionIdVO $permission): void
    {
        $this->permissions = array_filter(
            $this->permissions,
            fn($perm) => $perm->getId() !== $permission->getId()
        );
    }

    public function syncPermissions(array $permissions): void
    {
        $this->permissions = $permissions;
    }
}
