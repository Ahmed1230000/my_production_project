<?php

namespace App\Domains\Authorization\ValueObjects\PermissionVO;

use App\Domains\Authorization\Exceptions\InvalidPermissionNameException;

class PermissionNameVO
{
    private string $name;

    public function __construct(string $name)
    {
        $name = trim($name);

        if ($name === '') {
            throw new InvalidPermissionNameException('Permission name required');
        }

        $this->name = strtolower($name);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
