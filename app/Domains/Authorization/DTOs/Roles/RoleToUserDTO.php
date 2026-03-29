<?php

namespace App\Domains\Authorization\DTOs\Roles;

use App\Domains\Authorization\ValueObjects\RoleVO\RoleIdVO;

class RoleToUserDTO
{
    /**
     * @param RoleIdVO[] $roleIds
     */
    public function __construct(
        public int $userId,
        public array $roleIds
    ) {
        foreach ($roleIds as $roleId) {
            if (!$roleId instanceof RoleIdVO) {
                throw new \InvalidArgumentException("All roleIds must be RoleIdVO");
            }
        }
    }
}
