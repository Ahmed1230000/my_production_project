<?php

namespace App\Domains\Authorization\DTOs\Permissions;

use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionIdVO;

class RemovePermissionsFromUserDTO
{
    /**
     * @param PermissionIdVO[] $permissionIds
     */
    public function __construct(
        public int $userId,
        public array $permissionIds
    ) {}
}
