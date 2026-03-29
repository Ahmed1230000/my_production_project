<?php

namespace App\Domains\Authorization\ValueObjects\RoleVO;

use App\Domains\Authorization\Exceptions\InvalidRoleNameException;

class RoleNameVO
{
    private string $name;

    public function __construct(string $name)
    {
        $name = trim($name);

        if (empty($name)) {
            throw new InvalidRoleNameException("Role name cannot be empty.");
        }


        $this->name = strtolower($name);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
