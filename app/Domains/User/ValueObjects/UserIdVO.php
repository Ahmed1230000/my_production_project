<?php

namespace App\Domains\User\ValueObjects;

use App\Domains\User\Exceptions\UserDomainException;

class UserIdVO
{
    public function __construct(public int $value)
    {
        if ($this->value <= 0) {
            trim($this->value);
            throw new UserDomainException("User ID must be a positive integer.");
        }
    }
}
