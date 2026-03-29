<?php

namespace App\Domains\Auth\Repositories\Contracts;

use App\Domains\User\Entities\UserEntity;

interface AuthTokenServiceInterface
{
    public function generateToken(int $userId): string;

    public function refreshToken(string $refreshToken): array;
    public function revokeToken(int $tokenId): void;
}
