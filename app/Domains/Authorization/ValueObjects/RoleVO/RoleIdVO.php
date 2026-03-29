<?php

namespace App\Domains\Authorization\ValueObjects\RoleVO;

use App\Domains\Authorization\Exceptions\InvalidRoleIdException;

class RoleIdVO
{
    private int $id;

    public function __construct(int $id)
    {
        if ($id <= 0) {
            throw new InvalidRoleIdException("Role ID must be a positive integer.");
        }

        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
