<?php

namespace App\Domains\Authorization\DTOs\Roles;

use App\Domains\Authorization\ValueObjects\RoleVO\RoleIdVO;

class RemoveRolesFromUserDTO
{
    /**
     * @param RoleIdVO[] $roleIds
     */
    public function __construct(
        public int $userId,
        public array $roleIds
    ) {}
}
