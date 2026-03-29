<?php

namespace App\Domains\Auth\DTOs;

use App\Domains\User\Entities\UserEntity;
use App\Models\User;

class AuthResultDTO
{
    public function __construct(
        public UserEntity $user,
        public string $accessToken,
        public ?string $refreshToken = null,
        public ?int $expiresIn = null,
        public ?User $userModel = null
    ) {}
}
