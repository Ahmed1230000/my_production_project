<?php

namespace App\Domains\Auth\Repositories\Contracts;

use App\Domains\User\Entities\UserEntity;

interface AuthTokenServiceInterface
{
    public function generateToken(string $email, string $password): array;
    public function refreshToken(string $refreshToken): array;
    public function revokeToken(int $tokenId): void;
}
