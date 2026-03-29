<?php

namespace App\Domains\Authorization\DTOs\Permissions;

use App\Domains\Authorization\ValueObjects\PermissionVO\PermissionIdVO;

class PermissionToUserDTO
{
    /**
     * @param PermissionIdVO[] $permissionIds
     */
    public function __construct(
        public int $userId,
        public array $permissionIds
    ) {
        foreach ($permissionIds as $permissionId) {
            if (!$permissionId instanceof PermissionIdVO) {
                throw new \InvalidArgumentException("All permissionIds must be PermissionNameVO");
            }
        }
    }
}
