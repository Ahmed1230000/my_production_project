<?php

namespace App\Domains\User\DTOs;

use App\Domains\User\ValueObjects\UserIdVO;

class UserDeleteDTO
{
    public function __construct(
        public UserIdVO $id
    ) {}
}
