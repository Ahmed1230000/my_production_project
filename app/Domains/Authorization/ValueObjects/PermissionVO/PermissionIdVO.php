<?php

namespace App\Domains\Authorization\ValueObjects\PermissionVO;

use App\Domains\Authorization\Exceptions\InvalidPermissionIdException;

class PermissionIdVO
{
    private int $id;

    public function __construct(int $id)
    {
        if ($id <= 0) {
            throw new InvalidPermissionIdException('Invalid permission id');
        }

        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}